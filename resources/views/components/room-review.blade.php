<div class="mt-8">
    {{-- Hiển thị điểm trung bình --}}
    <div class="flex items-center">
        <span class="text-xl font-semibold mr-2">{{ $averageRating ?? 0 }}</span>
        <div class="flex">
            @for ($i = 1; $i <= 5; $i++)
                <svg class="w-5 h-5 {{ $i <= round($averageRating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921..."/>
                </svg>
            @endfor
        </div>
        <span class="ml-2 text-sm text-gray-600">({{ $reviews->count() }} đánh giá)</span>
    </div>

    {{-- Form đánh giá (chỉ cho user đăng nhập) --}}
    @auth
        <form wire:submit.prevent="submit" class="mt-4 space-y-3">
            <div>
                <label class="block text-sm font-medium">Chọn số sao:</label>
                <div class="flex mt-1">
                    @for ($i = 1; $i <= 5; $i++)
                        <button type="button" wire:click="$set('rating', {{ $i }})" class="focus:outline-none">
                            <svg class="w-8 h-8 {{ $i <= $rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921..."/>
                            </svg>
                        </button>
                    @endfor
                </div>
                @error('rating') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Bình luận:</label>
                <textarea wire:model.defer="comment" rows="3" class="mt-1 block w-full border rounded p-2"></textarea>
                @error('comment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Gửi đánh giá
            </button>
        </form>
    @else
        <p class="mt-4 text-sm text-gray-500">Vui lòng <a href="{{ route('login') }}" class="text-blue-600">đăng nhập</a> để đánh giá.</p>
    @endauth

    {{-- Danh sách review --}}
    <div class="mt-6 border-t pt-4 space-y-4">
        @forelse ($reviews as $rev)
            <div class="border rounded p-3">
                <div class="flex items-center mb-1">
                    <span class="font-medium">{{ $rev->user->name }}</span>
                    <span class="ml-2 text-yellow-400">
                        @for($i=1; $i<=5; $i++)
                            <svg class="w-4 h-4 {{ $i <= $rev->rating ? '' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921..."/></svg>
                        @endfor
                    </span>
                    <span class="ml-auto text-xs text-gray-400">{{ $rev->created_at->format('d/m/Y') }}</span>
                </div>
                @if($rev->comment)
                    <p class="text-sm text-gray-700">{{ $rev->comment }}</p>
                @endif
            </div>
        @empty
            <p class="text-gray-500">Chưa có đánh giá nào.</p>
        @endforelse
    </div>
</div>
