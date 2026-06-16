@if ($paginator->hasPages())
<nav class="custom-pagination">
    <ul>
        {{-- Prev --}}
        @if ($paginator->onFirstPage())
            <li class="disabled">
                <span><i class="fa-solid fa-chevron-left" style="font-size:11px;"></i> Prev</span>
            </li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}">
                    <i class="fa-solid fa-chevron-left" style="font-size:11px;"></i> Prev
                </a>
            </li>
        @endif

        {{-- Page Numbers --}}
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
            <li>
                <a href="{{ $paginator->nextPageUrl() }}">
                    Next <i class="fa-solid fa-chevron-right" style="font-size:11px;"></i>
                </a>
            </li>
        @else
            <li class="disabled">
                <span>Next <i class="fa-solid fa-chevron-right" style="font-size:11px;"></i></span>
            </li>
        @endif
    </ul>
</nav>
@endif