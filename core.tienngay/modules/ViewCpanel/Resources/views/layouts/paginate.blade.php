<style type="text/css">
    .pagination {
      display: flex !important;
      justify-content: space-between !important;
      align-items: center !important;
      font-size: 14px !important;
      padding: 0px !important;
    }

    .pagination1 {
        width: 100%;
    }

    .pagination-stt,
    .pagination-icon {
      padding: 5px 12px !important;
      border-radius: 5px !important;
      margin: 2px !important;
    }

    .pagination-stt1 {
      background-color: #1d9752 !important;
      color: #ffffff !important;

    }

    .border-pagination {
      border-radius: 5px !important;
      border: 1px solid #f0f0f0 !important;
    }

    .pagination a {
        text-decoration: none !important;
        color: #000;
    }
    ul.pagination li:hover {
        cursor: pointer;
    }
    .pagination li:hover:not(.active) {
        background-color: lightgray;
    }
    ul.pagination {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        flex-wrap: wrap !important;
    }
    a.disabled {
        background-color: lightgray !important;
    }
</style>
<div class="pagination">
    <div class="pagination1">
@if ($paginator->hasPages())
<?php
    parse_str($_SERVER['QUERY_STRING'], $vars);
    unset($vars['page']);
?>
    <!-- Pagination -->
    <div class="pull-right">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <a class="disabled pagination-icon border-pagination">
                    <span><i class="fa fa-angle-double-left" aria-hidden="true"></i></span>
                </a>
                <a class="disabled pagination-icon border-pagination">
                    <span><i class="fa fa-angle-left" aria-hidden="true"></i></span>
                </a>
            @else
                
                <a href="{{ \Request::url().'?'.http_build_query($vars) }}">
                    <li class="pagination-icon border-pagination">
                    <span><i class="fa fa-angle-double-left" aria-hidden="true"></i></span>
                    </li>
                </a>
                <a href="{{ $paginator->previousPageUrl() }}">
                    <li class="pagination-icon border-pagination">
                    <span><i class="fa fa-angle-left" aria-hidden="true"></i></span>
                    </li>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <a class="active pagination-stt pagination-stt1"><span>{{ $page }}</span></a>
                        @elseif (($page > $paginator->currentPage() - 5 && $page < $paginator->currentPage() + 5) || $page == $paginator->lastPage())
                            <a href="{{ $url }}"><li class="border-pagination pagination-stt">{{ $page }}</li></a>
                        @elseif ($page == $paginator->lastPage() - 1)
                            <a class="disabled border-pagination pagination-stt"><span>...</span></a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}">
                    <li class="pagination-icon border-pagination">
                    <span><i class="fa fa-angle-right" aria-hidden="true" ></i></span>
                    </li>
                </a>
                <a href="{{ \Request::url().'?page='.$paginator->lastPage().'&'.http_build_query($vars) }}">
                    <li class="pagination-icon border-pagination">
                    <span><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                    </li>
                </a>
            @else
                <a class="disabled pagination-icon border-pagination">
                    <span><i class="fa fa-angle-right" aria-hidden="true" ></i></span>
                </a>
                <a class="disabled pagination-icon border-pagination">
                    <span><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                </a>
            @endif
        </ul>
    </div>
    <!-- Pagination -->
@endif
    </div>
</div>