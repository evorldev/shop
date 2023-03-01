<a href="{{ route('catalog', $item) }}" class="p-3 sm:p-4 2xl:p-6 rounded-xl @if($item->id == $current?->id) bg-pink @else bg-card @endif hover:bg-pink text-xxs sm:text-xs lg:text-sm text-white font-semibold">
    {{ $item->title }}
</a>
