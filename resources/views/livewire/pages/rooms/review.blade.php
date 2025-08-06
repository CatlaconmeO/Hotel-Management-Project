<div class="mt-8">
    @if(session()->has('message'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-green-700">{{ session('message') }}</p>
        </div>
    @endif

    {{-- Average Rating --}}
    <div class="flex items-center mb-6">
        <span class="text-2xl font-bold mr-3">{{ number_format($averageRating, 1) }}</span>
        <div class="flex">
            @for ($i = 1; $i <= 5; $i++)
                <svg class="w-6 h-6 {{ $i <= round($averageRating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            @endfor
        </div>
        <span class="ml-3 text-gray-600">({{ $reviews->count() }} ratings)</span>
    </div>

    {{-- Rating Form --}}
    @auth
        <div class="bg-gray-50 p-6 rounded-lg mb-6">
            <h3 class="text-lg font-semibold mb-4">Rate this room</h3>

            @if($existingReview)
                <p class="text-sm text-blue-600 mb-3">You rated this room. You can only update the rating.</p>
            @endif

            <form wire:submit.prevent="submit" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Choose rating:</label>
                    <div class="flex space-x-1">
                        @for ($i = 1; $i <= 5; $i++)
                            <button type="button" wire:click="setRating({{ $i }})" class="focus:outline-none hover:scale-110 transition-transform">
                                <svg class="w-8 h-8 {{ $i <= $rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </button>
                        @endfor
                    </div>
                    @error('rating') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Your comment:</label>
                    <textarea wire:model.defer="comment" rows="4"
                              class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Share your experience about this room..."></textarea>
                    @error('comment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    {{ $existingReview ? 'Update rating' : 'Send' }}
                </button>
            </form>
        </div>
    @else
        <div class="bg-gray-50 p-6 rounded-lg mb-6 text-center">
            <p class="text-gray-600">Vui lòng <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Please login</a> to rating.</p>
        </div>
    @endauth

    {{-- Danh sách đánh giá --}}
    <div class="space-y-4">
        <h3 class="text-lg font-semibold">Customer Reviews</h3>

        @forelse ($reviews as $review)
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center">
                        <span class="font-medium text-gray-900">{{ $review->customer->name }}</span>
                        <div class="flex ml-3">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                    </div>
                    <span class="text-sm text-gray-500">{{ $review->updated_at->format('d/m/Y') }}</span>
                </div>

                @if($review->comment)
                    <p class="text-gray-700">{{ $review->comment }}</p>
                @endif
            </div>
        @empty
            <div class="text-center py-8 text-gray-500">
                <p>No reviews for this room yet.</p>
                <p class="text-sm">Be the first to review!</p>
            </div>
        @endforelse
    </div>
</div>
