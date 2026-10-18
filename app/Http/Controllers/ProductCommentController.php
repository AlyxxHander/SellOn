<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductCommentController extends Controller
{
    /**
     * Menyimpan komentar & rating baru untuk produk.
     */
    public function store(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $validated = $request->validate([
            'rating'  => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'max:1000'],
        ]);

        $product->comments()->create([
            'user_id' => Auth::id(),
            'rating'  => $validated['rating'],
            'comment' => strip_tags(trim($validated['comment'])),
        ]);

        return back()->with('toast_success', 'Ulasan dan rating berhasil ditambahkan!');
    }

    /**
     * Menghapus komentar.
     * Hak akses:
     * 1. Penjual pemilik produk ($comment->product->user_id === Auth::id())
     * 2. Pembuat komentar itu sendiri ($comment->user_id === Auth::id())
     * 3. Admin (Auth::user()->role === 'admin')
     */
    public function destroy($id)
    {
        $comment = ProductComment::with('product')->findOrFail($id);
        $currentUserId = Auth::id();
        $isProductOwner = ($comment->product->user_id === $currentUserId);
        $isCommentOwner = ($comment->user_id === $currentUserId);
        $isAdmin = (Auth::user()->role ?? null) === 'admin';

        if (! $isProductOwner && ! $isCommentOwner && ! $isAdmin) {
            abort(403, 'Anda tidak memiliki hak izin untuk menghapus komentar ini.');
        }

        $comment->delete();

        return back()->with('toast_success', 'Komentar berhasil dihapus.');
    }
}
