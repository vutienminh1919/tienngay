<!-- page content -->
@extends('viewcpanel::layouts.master')
@section('title', 'Nhập liệu chi phí truyền thông')

@section('css')
<link href="{{ asset('viewcpanel/css/reportsKsnb/index.css') }}" rel="stylesheet"/>
<style>
    th{
        white-space: nowrap;
    }
    td{
        white-space: nowrap;
    }

    .theloading {
        position: fixed;
        z-index: 999;
        display: block;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, .7);
        top: 0;
        right: 0;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center
    }
    .report h1 {
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        line-height: 24px;
        color: #3B3B3B;
    }

    .report-nav {
        display: flex;
        justify-content: space-between;
    }

    .box1-title {
        display: flex;
        justify-content: space-between;
    }

    td {
        word-wrap: break-word;
        text-align: center;
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #676767;
    }

    .form-ip {
        display: flex;
        flex-direction: column;
    }

    .form-ip input {
        width: 100%;
        height: 40px;
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        padding-left: 10px;
    }

    .form-ip select {
        width: 100%;
        height: 40px;
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        padding-left: 10px;
    }

    .form-modal {
        display: flex;
        flex-direction: column;
        gap: 18px;

    }

    .modal-body {
        background-color: #FFFFFF !important;
        border-radius: 16px !important;
    }

    .box1 {
        background: #FFFFFF;
        /* Elevation 1 */
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
        border-radius: 8px;
    }

    .table-oder th {
        background-color: #E8F4ED;
        color: #262626;
        text-align: center;
    }

    .box1-title h3 {
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        line-height: 24px;
        color: #3B3B3B;
        padding: 16px;
    }

    .box1-btn {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .outer {
        overflow-y: auto;
        height: 600px;
    }

    .outer {
        width: 100%;
        -layout: fixed;
    }

    .outer thead {
        text-align: left;
        top: 0;
        position: sticky;
    }

    .outer th {
        background-color: #E8F4ED;
        text-align: center;
        padding: 10px 15px !important;
    }

    /* mobile :*/
    @media only screen and (max-width :46.1875em) {
        .box1-title {
            display: flex;
            flex-direction: column;

        }
    }

    #date {
  width: 150px;
  outline: none;
  border: 1px solid #aaa;
  padding: 6px 28px;
  color: #aaa;
}

.date-container {
  position: relative;
  float: left;
}
  .date-text {
    position: absolute;
    top: 6px;
    left: 12px;
    color: #aaa;
  }
  
  .date-icon {
    position: absolute;
    top: 10px;
    right: 10px;
    /* pointer-events: none; */
    cursor: pointer;
    color: #aaa;
  }

  #date2 {
  width: 150px;
  outline: none;
  border: 1px solid #aaa;
  padding: 6px 28px;
  color: #aaa;
}

.date-container2 {
  position: relative;
  float: left;
}
  .date-text2 {
    position: absolute;
    top: 6px;
    left: 12px;
    color: #aaa;
  }
  
  .date-icon2 {
    position: absolute;
    top: 10px;
    right: 10px;
    /* pointer-events: none; */
    cursor: pointer;
    color: #aaa;
  }

</style>
@endsection
@section("content")
<!-- page content -->
<div class="right_col" role="main">
    <div class="report">
        <h1 style="margin-top:10px;margin-left: 15px;">BÁO CÁO CHI PHÍ TRUYỀN THÔNG</h1>
        <div class="create_record">
            <div id="loading" class="theloading" style="display: none;">
                <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
            </div>
        </div>
        <div style="margin-top:10px;margin-left: 15px; class="report-nav">
            <small>
                <a class="home" style="color:#676767; text-decoration:none;" href="https://lms.tienngay.vn/"><i class="fa fa-home">&nbsp;</i>Home</a> <span style="color:#323232"> > </span> <a style="color:#676767; text-decoration:none;" href="{{route('viewcpanel::macom.cost.history')}}">Lịch sử</a>
            </small>
        </div>
        <div class="box1">
            <div class="box1-title">
                <h3>Lịch Sử Nhập</h3>
                <div class="box1-btn" style="margin-right: 15px;">
                    <!-- <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#exampleModal" style="background-color: #D2EADC !important;">Tìm kiếm <img src="https://service.tienngay.vn/uploads/avatar/1667377322-28321587346dc76b54b62085f6a9bace.png" alt=""></button> -->
                    @include("viewcpanel::macom.cost.filterHistory")
                </div>
            </div>
            <div class="box1-table">
                <form>
                <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}">
                    <div class="card-body">
                        <div class="outer" style="height: max-content;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" style="max-width:100px">STT</th>
                                        <th scope="col" style="max-width:150px">Người nhập</th>
                                        <th scope="col" style="max-width:150px">Ngày nhập</th>
                                        <th scope="col" style="max-width:150px">Tên chiến dịch</th>
                                        <th scope="col" style="max-width:150px">Khu vực</th>
                                        <th scope="col" style="max-width:150px">Phòng giao dịch</th>
                                        <th scope="col" style="max-width:150px">Social Media</th>
                                        <th scope="col" style="max-width:150px">Pr, báo chí, TV</th>
                                        <th scope="col" style="max-width:150px">Chi phí KOL/KOC</th>
                                        <th scope="col" style="max-width:150px">OOH</th>
                                        <th scope="col" style="max-width:150px">Khác</th>
                                        <th scope="col" style="max-width:150px">Tổng</th>
                                        <th scope="col" style="max-width:150px">Số lượt tiếp cận</th>
                                        <th scope="col" style="max-width:150px">Chi phí/Lượt tiếp cận</th>
                                        <th scope="col" style="max-width:150px">Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if(isset($history))
                                    @foreach ($history as $key => $item)
                                        @php
                                          $total = $item['social_media'] + $item['pr_tv'] + $item['kol_koc'] + $item['ooh'] + $item['other']
                                        @endphp
                                        <tr>
                                            <td>{{$perPage + ++$key}}</td>
                                            <td>{{$item['created_by']}}</td>
                                            <td>{{date('d/m/Y', $item['created_at'])}}</td>
                                            <td style="text-align:left;">{{$item['campaign_name']}}</td>
                                            <td style="text-align:left;">{{$item['area_name']}}</td>
                                            <td>
                                                <a type="button" style="color:#1D9752; text-decoration:none; border:none;" 
                                                data-store="{{json_encode($item['stores'])}}" data-bs-toggle="modal" 
                                                data-bs-target="#staticBackdrop" class="pgd">{{count($item['stores'])." "."Phòng giao dịch"}}
                                                </a>
                                            </td>
                                            <td>{{number_format((int)$item['social_media'])}}</td>
                                            <td>{{number_format((int)$item['pr_tv'])}}</td>
                                            <td>{{number_format((int)$item['kol_koc'])}}</td>
                                            <td>{{number_format((int)$item['ooh'])}}</td>
                                            <td>{{number_format((int)$item['other'])}}</td>
                                            <td>{{number_format((int)$total)}}</td>
                                            <td>{{number_format((int)$item['hits'])}}</td>
                                            <td>
                                                @if($item['hits'] != 0)
                                                    {{number_format($total/$item['hits'])}}
                                                @else
                                                    {{(int)0}}
                                                @endif
                                            </td>
                                            <td>
                                                <a type="button" class="btn-outline-success" style="font-style: 14px; border-radius: 5px"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-bars" aria-hidden="true"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item detail" href='{{$cpanelDetail.$item->_id}}'>Chi tiết</a></li>
                                                    @if (!in_array($email, $emailKT))
                                                    <li><a class="dropdown-item update" href='{{$cpanelUpdate.$item->_id}}'>Chỉnh sửa</a></li>
                                                    @endif
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            @if(!empty($history))
                            <div>
                                <nav aria-label="Page navigation" style="margin-top: 20px;">
                                {{$history->withQueryString()->links()}}
                                </nav>
                            </div>
                            @endif
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Phòng giao dịch</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body show_pgd">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $(".detail").on('click', function(e) {
        e.preventDefault();
        let targetLink = $(e.target).attr('href');
        window.parent.postMessage({targetLink: targetLink}, "{{$cpanelPath}}");
    });
    $(".update").on('click', function(e) {
        e.preventDefault();
        let targetLink = $(e.target).attr('href');
        window.parent.postMessage({targetLink: targetLink}, "{{$cpanelPath}}");
    });
    $(".home").on('click', function(e) {
        e.preventDefault();
        let targetLink = $(e.target).attr('href');
        window.parent.postMessage({targetLink: "{{$cpanelUrl}}"}, "{{$cpanelPath}}");
    });
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
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
    // var dp = $("#start-date, #end-date").datepicker( {
    //     format: "yyyy-mm-dd",
    //     autoclose: true
    // });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#code_area").on('change', function() {
        let code_area = $(this).val();
        let form = new FormData();
        form.append('code_area', code_area);
        form.append('_token', $('input[name="_token"]').val());
        $.ajax({
            dataType: 'json',
            enctype: 'multipart/form-data',
            url: '{{route("viewcpanel::macom.cost.getStoreByCodeArea")}}',
            type: 'POST',
            data: form,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data['status'] == 200) {
                    console.log(data);
                var select = $("#store_id");
                select.html('');
                $('#store_id').append('<option value="">' + "--Chọn PGD--" + '</option>');
                if (code_area == "") {
                    var stores = JSON.parse('{!! json_encode($stores) !!}');
                    $.each(stores, function(key, value){
                        $('#store_id').append('<option value="'+ value['_id']+'">' + value['name'] + '</option>');
                    });
                }
                $.each(data.data, function(key, value){
                    $('#store_id').append('<option value="' + value['_id'] + '">' + value['name'] + '</option>');
                });
                } else if (typeof(data) == "string") {
                $("#errorModal").find(".msg_error").text(data);
                $("#errorModal").modal('show');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
            $("#errorModal").find(".msg_error").text("Có lỗi xảy ra, vui lòng thử lại sau!");
            $("#errorModal").modal('show');
            }
        });
    });

    $('.pgd').click(function() {
        $("#staticBackdrop").modal('show');
        let store = $(this).attr('data-store');
        console.log(store);
        let arr = JSON.parse(store);
        $('.show_pgd').html('');
        $.each(arr, function(key, value) {
            $('.show_pgd').append('<p class="text-success" style="text-align:center;">'+ value.store +'</p>');
        });
    });
})
</script>
<script type="text/javascript">
    $(document).ajaxStart(function() {
        $("#loading").show();
        var loadingHeight = window.screen.height;
        $("#loading, .right-col iframe").css('height', loadingHeight);
    }).ajaxStop(function() {
        $("#loading").hide();
    });
    $(document).ajaxStart(function() {
        $("#loading").show();
        var loadingHeight = window.screen.height;
        $("#loading, .right-col iframe").css('height', loadingHeight);
    }).ajaxStop(function() {
        $("#loading").hide();
    });
    var dataSearch = JSON.parse('{!! json_encode($dataSearch) !!}');
    console.log(dataSearch);
    for (const property in dataSearch) {
        if (dataSearch[property] == null) {
            continue;
        }
        console.log(property, ' ', dataSearch[property]);
        $('#search-form').find("[name='" + property + "']").val(dataSearch[property]);
    }
    $(function() {
        $('#date').datepicker({
            format: "yyyy-mm-dd",
            minDate: 1
        });

        $('#date2').datepicker({
            format: "yyyy-mm-dd",
            minDate: 1
        });
        
        $('#date').on('click', function() {
            $('#date').css('color', 'black');
        })

        $('.date-icon').on('click', function() {
            $('#date').css('color', 'black');
            $('#date').focus();
        })

        $('#date2').on('click', function() {
            $('#date2').css('color', 'black');
        })

        $('.date-icon2').on('click', function() {
            $('#date2').css('color', 'black');
            $('#date2').focus();
        })
    });
  </script>
@endsection
