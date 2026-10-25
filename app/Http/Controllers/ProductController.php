<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use Auth;

class ProductController extends Controller
{
  // Show the create product form
  public function create() {
    return view('products.create_form');
  }

  // Get all the Product data to a view (.blade.php) 
  public function index($view_type = 'home') {    
    $products = Product::orderBy("id", "desc")->paginate(5);

    return view($view_type, compact('products'));
  }

  private function getCategoryCounts($baseQuery) {
      return [
          'All' => (clone $baseQuery)->count(),
          'Preloved' => (clone $baseQuery)->where('category', 'Preloved')->count(),
          'Food' => (clone $baseQuery)->where('category', 'Food')->count(),
          'Beverage' => (clone $baseQuery)->where('category', 'Beverage')->count(),
          'Service' => (clone $baseQuery)->where('category', 'Service')->count(),
      ];
  }

  private function applySearch($query, Request $request) {
      if ($request->has('search') && $request->search != '') {
          $query->where('name', 'like', '%' . $request->search . '%');
      }
      return $query;
  }

  private function applySort($query, Request $request) {
      $sort = $request->query('sort', 'Newest');
      if ($sort == 'Price: Low → High') {
          $query->orderBy('price', 'asc');
      } elseif ($sort == 'Price: High → Low') {
          $query->orderBy('price', 'desc');
      } else {
          $query->orderBy('created_at', 'desc');
      }
      return $query;
  }

  // Show all the products to the catalog view
  public function catalog(Request $request) {
      $baseQuery = Product::query();
      $baseQuery = $this->applySearch($baseQuery, $request);
      
      $categoryCounts = $this->getCategoryCounts($baseQuery);
      
      $query = clone $baseQuery;
      if ($request->has('filter') && $request->filter != 'All') {
        $query->where('category', $request->filter);
      }
      $query = $this->applySort($query, $request);
      
      $products = $query->paginate(20)->withQueryString();
      return view('products.show_catalog', compact('products', 'categoryCounts'));
  }

  // Show current User product to the catalog view
  public function myProducts(Request $request) {
      $baseQuery = Product::where('user_id', Auth::id());
      $baseQuery = $this->applySearch($baseQuery, $request);
      
      $categoryCounts = $this->getCategoryCounts($baseQuery);
      
      $query = clone $baseQuery;
      if ($request->has('filter') && $request->filter != 'All') {
        $query->where('category', $request->filter);
      }
      $query = $this->applySort($query, $request);
      
      $products = $query->paginate(20)->withQueryString();
      return view('users.show_my-products', compact('products', 'categoryCounts'));
  }

    // Add new Product based on the User added Product when the Product is being submitted
  public function store(Request $request) {
    // Check if the uploaded file is valid
    if ($request->hasFile('image_urls')) {
      $validFiles = array_values(array_filter($request->file('image_urls'), function ($file) {
        return $file && $file->isValid();
      }));
      $request->files->set('image_urls', $validFiles);
    }

    // Add Product data to the database
    $request->merge([
      'user_id' => Auth::id(),
      'condition' => $request->condition ?? '-',
    ]);

    // Validate the request
    $validation = $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'description' => ['required', 'string', 'max:500'],
      'price' => ['required', 'numeric', 'min:10000', 'max:1000000'],
      'stock' => ['nullable', 'required_unless:category,Service', 'numeric', 'min:1', 'max:999'],
      'category' => ['required', 'string'],
      'condition' => ['nullable', 'string', 'required_if:category,Preloved'],
      'image_urls' => ['required', 'array', 'min:1', 'max:5'],
      'image_urls.*' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:5120'],
      'user_id' => ['required', 'exists:users,id'],
    ]);

    // Check whether the category is 'Service', then set stock to null
    if ($validation['category'] === 'Service') {
      $validation['stock'] = null;
    }

    // Make a new product (without image_url first)
    $productData = collect($validation)->except('image_urls')->toArray();
    $product = Product::create($productData);

    // Store the image file to storage and create a product_images relationship
    if ($request->hasFile('image_urls')) {
      $firstImagePath = null;

      foreach ($request->file('image_urls') as $index => $file) {
        $path = $file->store('products', 'public');
        $product->images()->create(['image_url' => $path]);

        if ($index === 0) {
          $firstImagePath = $path;
        }
      }

      // Update main product cover image with the first image
      if ($firstImagePath) {
        $product->update(['image_url' => $firstImagePath]);
      }
    }

    // Redirect to the product index page with a success toast message
    return redirect()
      ->route('product.index', ['view_type' => 'home'])
      ->with('toast_success', 'Product has been successfully saved!');
  }


  // Show the data to User in the detail form
   public function show($id) {
    $product = Product::with(['user', 'images', 'comments.user'])->findOrFail($id);
    return view('products.show_detail', compact('product'));
  }
  // public function show($id) {
  //   $product = Product::findOrFail($id);
  //   return view('products.show_detail', compact('product'));
  // }

  // Show the data to User in the edit form
  public function edit($id) {
    $product = Product::findOrFail($id);

    // Only the product owner can edit
    if (Auth::id() !== $product->user_id) {
      abort(403, 'You do not have permission to edit this product.');
    }

    return view('products.edit_form', compact('product'));
  }

  // Update the Product data based on the User updated Product when the Product is being submitted
  public function update(Request $request, $id) {
    $product = Product::findOrFail($id);

    // Only the product owner can update
    if (Auth::id() !== $product->user_id) {
      abort(403, 'You do not have permission to edit this product.');
    }

    $validation = $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'description' => ['required', 'string', 'max:500'],
      'category' => ['required', 'string'],
      'price' => ['required', 'numeric', 'min:10000', 'max:1000000'],
      'stock' => ['required', 'numeric', 'min:0'],
      'condition' => ['required', 'string'],
      'new_image_urls' => ['nullable', 'array', 'max:5'],
      'new_image_urls.*' => ['image', 'mimes:jpeg,png,jpg', 'max:5120'],
      'deleted_images' => ['nullable', 'array'],
      'deleted_images.*' => ['exists:product_images,id'],
    ]);

    $validation['condition'] = $validation['condition'] ?? '-';

    // For 'Service' category, stock is not applicable — set to null explicitly
    if ($validation['category'] === 'Service') {
      $validation['stock'] = null;
    }

    $product->update([
      'name' => $validation['name'],
      'description' => $validation['description'],
      'price' => $validation['price'],
      'category' => $validation['category'],
      'stock' => $validation['stock'],
      'condition' => $validation['condition'],
    ]);

    if ($request->has('deleted_images')) {
      foreach($request->deleted_images as $imageId) {
        $image = $product->images()->find($imageId);
        if ($image) {
          Storage::disk('public')->delete($image->image_url);
          $image->delete();
        }
      }
    }

    if ($request->hasFile('new_image_urls')) {
      foreach($request->file('new_image_urls') as $file) {
        $path = $file->store('products', 'public');
        $product->images()->create(['image_url' => $path]);
      }
    }

    $firstImage = $product->images()->orderBy('id')->first();
    if ($firstImage) {
      $product->update(['image_url' => $firstImage->image_url]);
    } else {
      $product->update(['image_url' => null]);
    }

    return redirect()
      ->route('users.my-products')
      ->with(
        'toast_success', 
        'Product updated successfully!'
      );
  }

  // Delete a product together with all its stored images
  public function destroy($id)
  {
    // Get the product with all its images
    $product = Product::with('images')->findOrFail($id);
    // Delete main image that is stored in the image_url column (if any)
    if ($product->image_url) {
      // image_url contains relative path on the public disk, for example: "products/abcd.jpg"
      Storage::disk('public')->delete($product->image_url);
    }

    // Delete all images that are stored in the product_images table
    foreach ($product->images as $image) {
        if ($image->image_url) {
            Storage::disk('public')->delete($image->image_url);
        }
        // delete record table product_images
        $image->delete();
    }
    // Delete the product itself
    $product->delete();
    // Redirect with success toast
    return redirect()
        ->route('users.my-products')
        ->with('toast_success', 'Product deleted successfully!');
  }

}
