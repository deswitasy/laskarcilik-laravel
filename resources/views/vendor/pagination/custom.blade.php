@if ($paginator->hasPages())
<nav>
    <ul class="pagination">
        {{-- Prev --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><span>« Prev</span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}">« Prev</a></li>
        @endif

        {{-- Nomor Halaman --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}">Next »</a></li>
        @else
            <li class="disabled"><span>Next »</span></li>
        @endif
    </ul>
</nav>
@endif