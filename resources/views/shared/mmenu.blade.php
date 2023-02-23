<nav class="flex flex-col mt-8">
    @foreach ($mmenu as $item)
        <a href="{{ $item->link() }}"
           class="self-start py-1 text-dark hover:text-pink text-md @if ($item->isActive()) font-bold @endif"
        >
            {{ $item->label() }}
        </a>
    @endforeach
</nav>
