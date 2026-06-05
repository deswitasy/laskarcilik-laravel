@if ($paginator->hasPages())
<nav class="flex items-center justify-center mt-4">
    <ul class="flex items-center gap-1">
        {{-- Prev --}}
        @if ($paginator->onFirstPage())
            <li>
                <span class="px-3 py-2 text-gray-400 bg-gray-100 rounded cursor-not-allowed">« Prev</span>
            </li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 text-blue-600 bg-white border border-gray-300 rounded hover:bg-blue-50">« Prev</a>
            </li>
        @endif

        {{-- Nomor Halaman --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li><span class="px-3 py-2 text-gray-400">{{ $element }}</span></li>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li>
                            <span class="px-3 py-2 text-white bg-blue-600 rounded font-semibold">{{ $page }}</span>
                        </li>
                    @else
                        <li>
                            <a href="{{ $url }}" class="px-3 py-2 text-blue-600 bg-white border border-gray-300 rounded hover:bg-blue-50">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 text-blue-600 bg-white border border-gray-300 rounded hover:bg-blue-50">Next »</a>
            </li>
        @else
            <li>
                <span class="px-3 py-2 text-gray-400 bg-gray-100 rounded cursor-not-allowed">Next »</span>
            </li>
        @endif
    </ul>
</nav>
@endif