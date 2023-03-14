@extends('viewcpanel::layouts.master')

@section('title', 'Phiếu ghi nhận sự việc')

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
            Phiếu ghi nhận sự việc
        </h5>
        @if(session('status'))
            <div class="alert alert-success">
                {{session('status')}}
            </div>
        @endif
        @if(session('success'))
        <div class="alert alert-success">
          {{session('success')}}
        </div>
        @endif
        @if(session('errors'))
        <div class="alert alert-danger">
          {{session('errors')}}
        </div>
        @endif
        <div class="row" style="align-items: right;">
            <div class="col-xs-12 col-12">
                @include("viewcpanel::noteKsnb.filter")
            </div>
        </div>
        <div class="middle table_tabs">
            <p style="color: #047734"><strong>Tổng bản ghi:</strong><span id="total">&nbsp;{{$listRecords->total()}}</span></p>
            <div class="table-responsive" style="overflow-x: auto;">
                <table class="table" style="margin-bottom: 100px">
                    <thead>
                        <tr style="text-align: center">
                            <th scope="col" style="text-align: center;">STT</th>
                            <th scope="col" style="text-align: center; min-width: 150px;">CHỨC NĂNG</th>
                            <th scope="col" style="text-align: center; min-width: 300px;">TÊN</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">EMAIL</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">TÊN NGƯỜI VI PHẠM LIÊN QUAN</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">EMAIL NGƯỜI VI PHẠM LIÊN QUAN</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">NGÀY TẠO</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">TIẾN TRÌNH</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">NGƯỜI TẠO</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(isset($listRecords))
                    @foreach($listRecords as $key => $list)
                        <tr>
                            <td  style="text-align: center" scope="row">{{$key + 1}}</td>
                            <td class="more" style="text-align: center">
                                <div  class="btn-group"  style="text-align: center">
                                    <button type="button" class="btn btn-success" style="font-style: 14px; border-radius: 5px"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        Chức năng&nbsp;<i class="fa fa-bars" aria-hidden="true" style="font-style: 14px"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href='{{url("/cpanel/reportsKsnb/detailNote/$list->_id")}}'>Chi tiết phiếu ghi</a></li>
                                        @if ($list->process == 4 ||  $list->process == 8)
                                        <li><a class="dropdown-item" href='{{url("/cpanel/reportsKsnb/editNote/$list->_id")}}'>Cập nhật phiếu ghi</a></li>
                                        @endif
                                        @if ($list->process == 2 || $list->process == 9)
                                        <li><a class="dropdown-item" href='{{url("/cpanel/reportsKsnb/feedback/$list->_id")}}'>Phản hồi biên bản</a></li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                            <td  style="text-align: center">
                            @if(is_array($list->name_note))
                                {{implode(", " , $list->name_note)}}
                            @else
                                {{$list->name_note}}
                            @endif
                            </td>
                            <td  style="text-align: center">
                            @if(is_array($list->email_note))
                                {{implode(", " , $list->email_note)}}
                            @else
                                {{$list->email_note}}
                            @endif
                            </td>
                            <td  style="text-align: center">{{$list->user_name}}</td>
                            <td  style="text-align: center">{{$list->user_email}}</td>
                            <td class="more1" style="text-align: center">{{date("d-m-Y", strtotime($list->created_at))}}</td>
                            <td class="more1" style="text-align: center">
                                @if($list['process'] == 1)
                                    <span class="text-info">Chờ xác nhận</span>
                                @endif
                                @if($list['process'] == 2)
                                    <span class="text-success">Đã duyệt, chờ phản hồi</span>
                                @endif

                                @if($list['process'] == 3)
                                    <span class="text-success">Đã kết luận</span>
                                @endif
                                @if($list['process'] == 4)
                                    <span class="text-danger">Kiểm tra lại</span>
                                @endif
                                @if($list['process'] == 5)
                                    <span class="text-warning">Đã phản hồi/chờ kết luận</span>
                                @endif
                                @if($list['process'] == 6)
                                    <span class="text-success">Quá thời gian phản hồi</span>
                                @endif
                                @if($list['process'] == 7)
                                    <span class="text-primary">Chờ duyệt lại</span>
                                @endif
                                @if($list['process'] == 8)
                                    <span class="text-primary">Chờ gửi duyệt</span>
                                @endif
                                @if($list['process'] == 9)
                                    <span class="text-warning">Chờ phản hồi</span>
                                @endif
                                @if($list['process'] == 10)
                                    <span class="text-success">Chờ TBP kết luận</span>
                                @endif
                                @if($list['process'] == 11)
                                    <span class="text-success">Đã gửi cho CEO</span>
                                @endif
                                @if($list['process'] == 12)
                                    <span class="text-success">CEO đồng ý</span>
                                @endif
                                @if($list['process'] == 13)
                                    <span class="text-success">CEO chưa đồng ý</span>
                                @endif
                            </td>
                            <td class="more1" style="text-align: center">{{$list->created_by}}</td>
                        </tr>
                    @endforeach
                    @endif    
                </tbody>
                </table>
            </div>
        </div>
        @if(!empty($listRecords))
        <nav aria-label="Page navigation" style="margin-top: 20px;">
          {{$listRecords->withQueryString()->links()}}
        </nav>
        @endif
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
