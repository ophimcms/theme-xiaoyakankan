<div class="gm-page">
    <ul>
        @if ($paginator->hasPages())
            @if ($paginator->onFirstPage())
            @else
                <li class="first"><a href="{{ $paginator->previousPageUrl() }}">«</a></li>
            @endif
            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="pager on"><span>{{ $page }}</span></li>
                        @else
                            <li class="pager"><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="next"><a href="{{ $paginator->nextPageUrl() }}">»</a></li>
            @else
            @endif
        @endif


    </ul>
</div>
