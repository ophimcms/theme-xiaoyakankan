<div class="pagination-wrapper">
    <ul class="pagination pagination-no-border">
        <ul class="pagination">
            @if ($paginator->hasPages())
                @if ($paginator->onFirstPage())
                @else
                    <li><a class="" href="{{ $paginator->previousPageUrl() }}">←</a></li>
                @endif
                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="active"><a>{{ $page }}</a></li>
                            @else
                                <li><a href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach
                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li><a class="next page-numbers" href="{{ $paginator->nextPageUrl() }}">→</a></li>
                @else
                @endif
            @endif
        </ul>
    </ul>
</div>
