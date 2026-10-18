{{-- Comment & Rating Section --}}
<div class="fade-in-effect bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-slate-100 mb-12">
  <!-- Header Rating Summary -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-slate-100 gap-4">
    <div>
      <h2 class="text-xl md:text-2xl font-bold text-brand-main">User Rating & Comment</h2>
      <p class="text-sm text-brand-muted">Opinions and experiences of users on this product</p>
    </div>
    
    <div class="flex items-center gap-3 bg-brand-secondary px-4 py-2.5 rounded-xl">
      <div class="flex items-center text-amber-500 text-lg">
        <i class="fa-solid fa-star"></i>
      </div>
      <div>
        <span class="text-lg font-bold text-brand-main">{{ $product->average_rating > 0 ? $product->average_rating : '0.0' }}</span>
        <span class="text-xs text-brand-muted">/ 5.0 ({{ $product->total_comments }} comments)</span>
      </div>
    </div>
  </div>

  <!-- Form Add Review (For Logged In Users) -->
  @auth
    <div class="my-6 p-5 bg-slate-50/80 rounded-2xl border border-slate-200/80">
      <h3 class="mb-3 text-sm md:text-base font-semibold text-brand-main ">Write a Review & Give Rating</h3>
      <form action="{{ route('product.comments.store', $product->id) }}" method="POST" class="space-y-4" id="comment-form">
        @csrf
        <div>
          <label class="mb-2 block text-xs font-semibold text-brand-muted uppercase tracking-wider">Give Rating</label>
          <div class="flex items-center gap-2" id="star-rating-container">
            <input type="hidden" name="rating" id="rating-input" value="5">
            @for($i = 1; $i <= 5; $i++)
              <button type="button" class="star-btn text-2xl text-amber-400 hover:scale-110 transition-transform focus:outline-none cursor-pointer" data-value="{{ $i }}">
                <i class="fa-solid fa-star cursor-pointer"></i>
              </button>
            @endfor
            <span id="rating-label" class="ml-2 text-xs font-semibold text-brand-main ">5 / 5 (Very Good)</span>
          </div>

          @error('rating')
            <p class="mt-1 text-xs text-red-500 ">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="comment-text" class="mb-2 block text-xs font-semibold text-brand-muted uppercase tracking-wider">Comments</label>
          <textarea 
            id="comment-text" 
            name="comment" 
            rows="8"
            maxlength="50"
            placeholder="Tuliskan ulasan atau pertanyaan Anda mengenai produk ini..."
            class="w-full p-3 resize-none rounded-xl border border-slate-300 text-sm focus:border-brand-accent focus:ring-1 focus:ring-brand-accent outline-none bg-white transition"
            required></textarea>
          @error('comment')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div class="flex justify-end">
          <button type="submit" class="btn btn-primary py-2.5 px-6 text-sm  rounded-xl shadow-sm">
            <i class="mr-2 fa-solid fa-paper-plane "></i> Submit Comment
          </button>
        </div>
      </form>
    </div>
  @else
    <div class="my-6 p-4 rounded-xl bg-slate-50 border border-slate-200 text-center">
      <p class="text-sm text-brand-muted">
        Please <a href="{{ route('login') }}" class="font-bold text-brand-accent hover:underline">Sign In</a> to add a review and rating for this product.
      </p>
    </div>
  @endauth

  <!-- Comments List -->
  <div class="divide-y divide-slate-100 mt-6" id="comments-list">
    @forelse($product->comments as $comment)
      <div class="py-5 gap-4 flex flex-col sm:flex-row justify-between items-start">
        <div class="gap-3.5 flex items-start grow">
          <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ urlencode($comment->user->name) }}"
               alt="{{ $comment->user->name }}" class="w-10 h-10 rounded-full border border-slate-200 bg-white shrink-0 mt-0.5">
          <div class="space-y-1">
            <div class="gap-2 flex items-center flex-wrap">
              <span class="font-semibold text-sm text-brand-main">{{ $comment->user->name }}</span>
              @if($comment->user_id === $product->user_id)
                <span class="px-2 py-0.5 text-xs bg-brand-accent/10 text-brand-accent font-bold rounded-full border border-brand-accent/20">Seller</span>
              @else
                <span class="px-2 py-0.5 text-xs bg-slate-100 text-slate-600 font-medium rounded-full">Buyer</span>
              @endif
              <span class="text-xs text-slate-400">• {{ $comment->created_at->diffForHumans() }}</span>
            </div>
            
            <!-- Rating Stars -->
            <div class="gap-1 flex items-center text-xs text-amber-400">
              @for($s = 1; $s <= 5; $s++)
                @if($s <= $comment->rating)
                  <i class="fa-solid fa-star"></i>
                @else
                  <i class="fa-regular fa-star text-slate-300"></i>
                @endif
              @endfor
            </div>

            <!-- Comment Text -->
            <p class="pt-1 text-sm text-slate-700 leading-relaxed whitespace-pre-line">{{ $comment->comment }}</p>
          </div>
        </div>

        <!-- Delete Button (Conditional: Seller / Comment Owner) -->
        @auth
          @if(Auth::id() === $product->user_id && Auth::id() === $comment->user_id && (Auth::user()->role ?? null) === 'admin')
            <div class="shrink-0 self-end sm:self-start">
              <form action="{{ route('product.comments.destroy', $comment->id) }}" method="POST" class="delete-comment-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete-comment gap-1.5 flex items-center text-sm text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition cursor-pointer"
                        title="{{ Auth::id() === $product->user_id ? 'Delete this comment as product seller' : 'Delete your comment' }}">
                  <i class="fa-regular fa-trash-can"></i>
                  <span>Delete</span>
                </button>
              </form>
            </div>
          @endif
        @endauth
      </div>
    @empty
      <div class="py-12 text-center text-slate-400">
        <i class="fa-regular fa-comments text-4xl mb-3 block text-slate-300"></i>
        <p class="text-sm font-medium">No comments yet for this product.</p>
        <p class="text-xs text-slate-400">Be the first to give a review and rating!</p>
      </div>
    @endforelse
  </div>
</div>

@vite('resources/js/products/product_comment_js.js')
