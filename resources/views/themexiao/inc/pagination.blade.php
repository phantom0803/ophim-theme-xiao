@if ($paginator->hasPages())
    <nav>
        <ul class="myui-page text-center clearfix">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
            @else
                <li>
                    <a class="btn btn-default" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo; Trước</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li aria-current="page"><a class="btn btn-warm">{{ $page }}</a></li>
                        @else
                            <li class="hidden-xs"><a class="btn btn-default" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a class="btn btn-default" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">Sau &rsaquo;</a>
                </li>
            @else
            @endif
        </ul>
    </nav>
@endif
