<style type="text/css">
    .pagination {
      display: flex !important;
      justify-content: space-between !important;
      align-items: center !important;
      font-size: 14px !important;
      padding: 0px 8px 0px 0px  !important;
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
        color: #000 !important;
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
    li.disabled {
        background-color: lightgray !important;
    }
</style>
<div class="pagination">
    <div class="pagination1">
@if ($paginator->hasPages())
<?php
    $vars = [];
    if (isset($_SERVER['QUERY_STRING'])) {
        parse_str($_SERVER['QUERY_STRING'], $vars);
    }
    unset($vars['page']);
?>
    <!-- Pagination -->
    <?php $numberItem = $paginator->perPage() * ($paginator->currentPage() -1 ) + $paginator->count() ; ?>
    <div style="float: left; margin-left: 20px; margin-top: 10px;"><span><strong>Tổng:</strong> {{$numberItem . '/' . $paginator->total()}}</span></div>
    
    <div class="pull-right">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled pagination-icon border-pagination">
                    <span><i class="fa fa-angle-double-left" aria-hidden="true"></i></span>
                </li>
                <li class="disabled pagination-icon border-pagination">
                    <span><i class="fa fa-angle-left" aria-hidden="true"></i></span>
                </li>
            @else
                <li class="pagination-icon border-pagination">
                    <a href="{{ \Request::url().'?'.http_build_query($vars) }}">
                        <span><i class="fa fa-angle-double-left" aria-hidden="true"></i></span>
                    </a>
                </li>
                <li class="pagination-icon border-pagination">
                    <a href="{{ $paginator->previousPageUrl() }}">
                        <span><i class="fa fa-angle-left" aria-hidden="true"></i></span>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active pagination-stt pagination-stt1"><span>{{ $page }}</span></li>
                        @elseif (($page > $paginator->currentPage() - 5 && $page < $paginator->currentPage() + 5) || $page == $paginator->lastPage())
                            <li class="border-pagination pagination-stt"><a href="{{ $url }}">{{ $page }}</a></li>
                        @elseif ($page == $paginator->lastPage() - 1)
                            <li class="disabled border-pagination pagination-stt"><span>...</span></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="pagination-icon border-pagination">
                    <a href="{{ $paginator->nextPageUrl() }}">
                        <span><i class="fa fa-angle-right" aria-hidden="true" ></i></span>
                    </a>
                </li>
                <li class="pagination-icon border-pagination">
                    <a href="{{ \Request::url().'?page='.$paginator->lastPage().'&'.http_build_query($vars) }}">
                        <span><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                    </a>
                </li>
            @else
                <li class="disabled pagination-icon border-pagination">
                    <span><i class="fa fa-angle-right" aria-hidden="true" ></i></span>
                </li>
                <li class="disabled pagination-icon border-pagination">
                    <span><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                </li>
            @endif
        </ul>
    </div>
    <!-- Pagination -->
@endif
    </div>
</div>
