@if ($paginator->hasPages())

{{-- <ul class="wn__pagination">
    <li class="active"><a href="#">1</a></li>
    <li><a href="#">2</a></li>
    <li><a href="#">3</a></li>
    <li><a href="#">4</a></li>
    <li><a href="#"><i class="zmdi zmdi-chevron-right"></i></a></li>
</ul> --}}

<ul class="wn__pagination">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
    <li aria-disabled="true" aria-label="@lang('pagination.previous')">
        <span aria-hidden="true">&lsaquo;</span>
    </li>
    @else
    <li >
        <a  href="{{ $paginator->previousPageUrl() }}" rel="prev"
            aria-label="@lang('pagination.previous')">&lsaquo;</a>
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
    <li class="active" aria-current="page"><span >{{ $page }}</span></li>
    @else
    <li ><a href="{{ $url }}">{{ $page }}</a></li>
    @endif
    @endforeach
    @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
    <li class="">
        <a  href="{{ $paginator->nextPageUrl() }}" rel="next"
            aria-label="@lang('pagination.next')">&rsaquo;</a>
    </li>
    @else
    <li class=" disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
        <span aria-hidden="true">&rsaquo;</span>
    </li>
    @endif
</ul>

@endif