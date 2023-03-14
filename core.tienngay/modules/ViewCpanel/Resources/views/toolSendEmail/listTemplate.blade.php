@extends('viewcpanel::layouts.master')

@section('title', 'Template Email')

@section('css')
<link href="{{ asset('viewcpanel/css/reportsKsnb/index.css') }}" rel="stylesheet"/>
<style type="text/css">
    .alert {
        z-index: 999 !important;
    }
</style>
@endsection

@section('content')
<section class="main-content">
    <div id="loading" class="theloading" style="display: none;">
        <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    </div>
    <div id="top-view" class="container" style="max-width: 95% !important">
        <h5 class="tilte_top_tabs">
           Danh Sách Template Email
        </h5>
        <hr>
        <div class="row" style="align-items: right;">
            <div class="col-xs-12 col-12">
                @include("viewcpanel::toolSendEmail.filter")
            </div>
        </div>
        <div class="middle table_tabs">
            <p style="color: #047734"><strong>Tổng bản ghi:</strong> <span id="total">{{$lists->total()}}</span></p>

            <div class="table-responsive" style="overflow-x: auto;">
                <table class="table" style="margin-bottom: 100px">
                    <thead>
                        <tr style="text-align: center">
                            <th scope="col" style="text-align: center;">STT</th>
                            <th scope="col" style="text-align: center; min-width: 150px;">CHỨC NĂNG</th>
                            <th scope="col" style="text-align: center; min-width: 150px;">MÃ CODE</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">TIÊU ĐỀ</th>
                            <th scope="col" style="text-align: center; min-width: 150px;">PHÒNG</th>
                            <th scope="col" style="text-align: center; min-width: 150px;">NGƯỜI TẠO</th>
                            <th scope="col" style="text-align: center; min-width: 150px;">NGÀY TẠO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @if(isset($lists))
                            @foreach ($lists as $key => $list)
                            <td  style="text-align: center" scope="row">{{$key + 1}}</td>
                            <td class="more" style="text-align: center">
                                <div  class="btn-group"  style="text-align: center">
                                    <button type="button" class="btn btn-success" style="font-style: 14px; border-radius: 5px"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        Chức năng&nbsp;<i class="fa fa-bars" aria-hidden="true" style="font-style: 14px"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" target='_blank' href='{{$cpanelURL.route("viewcpanel::toolSendEmail.editTemplate" , ["id" => "$list->_id"])}}'>Cập nhật template</a></li>
                                    </ul>
                                </div>
                            </td>
                            <td style="text-align: center">{{$list->code}}</td>
                            <td style="text-align: center">{{$list->subject}}</td>
                            <td style="text-align: center">{{$list->store_name}}</td>
                            <td style="min-width: 130px;text-align: center">{{$list->created_by}}</td>
                            <td style="min-width: 130px;text-align: center">{{date("d-m-Y", $list->created_at)}}</td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        
        <nav aria-label="Page navigation" style="margin-top: 20px;">

        </nav>
        
    </div>
</section>
@endsection

@section('script')
<script type="text/javascript">
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
    const element = document.getElementById("top-view");
    element.scrollIntoView();
    $("#fillter-button").on("click", function (event) {
        event.stopPropagation();
        $("#fillter-content").toggle();
    })
    $("#clear-search-form").on("click", function (event) {
        event.preventDefault();
        document.getElementById("search-form").reset();
    });
    $("#close-search-form").on("click", function (event) {
        event.preventDefault();
        $("#fillter-content").hide();
    });
    $('body').on('click', function(e){
        if (e.target.id == "fillter-content" || $(e.target).parents("#fillter-content").length) {
            //do nothing
        } else {
            $("#fillter-content").hide();
        }
    });
    var dp = $("#start-date, #end-date").datepicker( {
        format: "yyyy-mm-dd",
        autoclose: true
    });
</script>
<script type="text/javascript">
    var dataSearch = JSON.parse('{!! json_encode($dataSearch) !!}');
    console.log(dataSearch);
    for (const property in dataSearch) {
      if (dataSearch[property] == null) {
        continue;
      }
      console.log(property, ' ', dataSearch[property]);
      $('#search-form').find("[name='" + property + "']").val(dataSearch[property]);
    }
</script>
@endsection
