<!-- page content -->
@extends('viewcpanel::layouts.master')
@section('title', 'Nhập liệu chi phí truyền thông')

@section('css')
<link href="{{ asset('viewcpanel/css/reportsKsnb/index.css') }}" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.14.0/css/selectize.bootstrap5.css" rel="stylesheet"/>
<style>
    td{
        white-space: nowrap !important;
    }
    th{
        white-space: nowrap !important;
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
        border-bottom-width: 0px;

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
        border-bottom-width: 0px !important;
    }

    /* mobile :*/
    @media only screen and (max-width :46.1875em) {
        .box1-title {
            display: flex;
            flex-direction: column;

        }
    }

    .box1-btn > a:hover {
        background-color: transparent;
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
        <div style="margin-top:10px;margin-left: 15px;" class="report-nav">
            <small>
                <a class="home" style="color:#676767; text-decoration:none;" href=""><i class="fa fa-home">&nbsp;</i>Home</a><span style="color:#323232"> > </span> <a class="report_link" style="color:#676767; text-decoration:none;" href="">Báo cáo chi phí truyền thông</a>
            </small>
            <a type="button" href='' class=" history" style="margin-bottom: 2%; background-color:#1D9752; color:#FFFFFF; padding: 6px 12px;border-radius: 3px ;text-decoration: none; " >Lịch sử nhập&nbsp; <img src="https://service.tienngay.vn/uploads/avatar/1667377383-4612565c619acce608328c0da11a06dd.png" alt=""></a>
        </div>
        <div class="box1">
            <div class="box1-title">
                <h3>BÁO CÁO</h3>
                <div class="box1-btn">
                    @if (!in_array($email, $emailKT))
                    <a style="width: 150px;height: 36px;text-align:center; color:#1D9752;" type="button" href='' class="btn btn-outline-success create">Nhập chi phí <img src="https://service.tienngay.vn/uploads/avatar/1667377208-c03ad235691d7f4280d85f3e33e343f7.png" alt=""></a>
                    @endif
                    <a style="width: 150px;height: 36px;text-align:center; color:#1D9752;" onclick="export_macom('xlsx', 'Bao_cao_macom')" type="button" class="btn btn-outline-success">Xuất excel <img src="https://service.tienngay.vn/uploads/avatar/1667377271-115c1a99626e9cdc5e7369aa6a1cbcae.png" alt=""></a>
                    <!-- <a type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#exampleModal" style="background-color: #D2EADC !important;">Tìm kiếm <img src="https://service.tienngay.vn/uploads/avatar/1667377322-28321587346dc76b54b62085f6a9bace.png" alt=""></a> -->
                    @include("viewcpanel::macom.cost.filterIndex")
                    <!-- Modal -->
                </div>
            </div>
            <div class="box1-table">
                <form action="">
                <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}">
                    <div class="table">
                        <table id="total_table" class="table">
                            <thead class="table-oder">
                                <tr>
                                    <th scope="col" style="width:350px">VÙNG MIỀN</th>
                                    <th scope="col" style="width:250px">SOCIAL MEDIA</th>
                                    <th scope="col" style="width:250px">PR, BÁO CHÍ, TV</th>
                                    <th scope="col" style="width:250px">CHI PHÍ KOL/KOC</th>
                                    <th scope="col" style="width:250px">OOH</th>
                                    <th scope="col" style="width:250px">KHÁC</th>
                                    <th scope="col" style="width:250px">TỔNG</th>
                                    <th scope="col" style="width:250px">CHI PHÍ KHU VỰC(%)</th>
                                </tr>
                            </thead>
                            <tbody style="color:#3B3B3B">
                                <tr>
                                    <th style="text-align:center" scope="row">Miền Bắc</php>
                                    </th>
                                    <td>{{number_format($mien_bac['all_social'])}}</td>
                                    <td>{{number_format($mien_bac['all_pr'])}}</td>
                                    <td>{{number_format($mien_bac['all_kol'])}}</td>
                                    <td>{{number_format($mien_bac['all_ooh'])}}</td>
                                    <td>{{number_format($mien_bac['all_other'])}}</td>
                                    <td>{{number_format($all_mien_bac)}}</td>
                                    @if ($all_total != 0)
                                    <td>{{number_format(round(($all_mien_bac/$all_total)*100, 2),2)}}</td>
                                    @else
                                    <td>{{(int)0}}</td>
                                    @endif
                                </tr>
                                <tr>
                                    <th style="text-align:center" scope="row">Miền Nam</php>
                                    </th>
                                    <td>{{number_format($mien_nam['all_social'])}}</td>
                                    <td>{{number_format($mien_nam['all_pr'])}}</td>
                                    <td>{{number_format($mien_nam['all_kol'])}}</td>
                                    <td>{{number_format($mien_nam['all_ooh'])}}</td>
                                    <td>{{number_format($mien_nam['all_other'])}}</td>
                                    <td>{{number_format($all_mien_nam)}}</td>
                                    @if ($all_total != 0)
                                    <td>{{number_format(round($all_mien_nam/$all_total*100, 2),2)}}</td>
                                    @else
                                    <td>{{(int)0}}</td>
                                    @endif
                                </tr>
                                <tr>
                                    <th style="text-align:center" scope="row">Đông Bắc</php>
                                    </th>
                                    <td>{{number_format($dong_bac['all_social'])}}</td>
                                    <td>{{number_format($dong_bac['all_pr'])}}</td>
                                    <td>{{number_format($dong_bac['all_kol'])}}</td>
                                    <td>{{number_format($dong_bac['all_ooh'])}}</td>
                                    <td>{{number_format($dong_bac['all_other'])}}</td>
                                    <td>{{number_format($all_dong_bac)}}</td>
                                    @if ($all_total != 0)
                                    <td>{{number_format(round($all_dong_bac/$all_total*100, 2),2)}}</td>
                                    @else
                                    <td>{{(int)0}}</td>
                                    @endif
                                </tr>
                                <tr>
                                    <th style="text-align:center" scope="row">Tổng Toàn Hệ Thống</php>
                                    </th>
                                    <td>{{number_format($total['all_social'])}}</td>
                                    <td>{{number_format($total['all_pr'])}}</td>
                                    <td>{{number_format($total['all_kol'])}}</td>
                                    <td>{{number_format($total['all_ooh'])}}</td>
                                    <td>{{number_format($total['all_other'])}}</td>
                                    <td>{{number_format($all_total)}}</td>
                                    <td>
                                    @if ($all_dong_bac + $all_mien_bac + $all_mien_nam != 0)
                                        {{(float)100}}
                                    @else
                                        {{(int)0}}
                                    @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
                <form>
                    <div class="card-body">
                        <div class="outer">
                            <table id="table_tiny" class="table table-hover bg-light">
                                <thead>
                                    <tr>
                                        <th rowspan="1" scope="col" style="max-width:150px">Khu vực</th>
                                        <th rowspan="1" scope="col" style="max-width:150px">Phòng giao dịch</th>
                                        <th rowspan="1" scope="col" style="max-width:150px">Social Media</th>
                                        <th rowspan="1" scope="col" style="max-width:150px">Pr, báo chí, TV</th>
                                        <th rowspan="1" scope="col" style="max-width:150px">Chi phí KOL/KOC</th>
                                        <th rowspan="1" scope="col" style="max-width:150px">OOH</th>
                                        <th rowspan="1" scope="col" style="max-width:150px">Khác</th>
                                        <th rowspan="1" scope="col" style="max-width:150px">Tổng</th>
                                        <th rowspan="1" scope="col" style="max-width:250px">Tỉ trọng chi phí /phòng(%)</th>
                                    </tr>
                                </thead>

                                <tbody class="table table-hover bg-light">
                                    <tr>
                                    @if (empty($history))
                                        @foreach($arrStores as $key => $code)
                                            <td style="vertical-align: middle;" rowspan="{{@count($code)}}">{{$key}}</td>
                                            @unset($code['count'])
                                            @foreach ($code as $item)
                                                @if (in_array($item['_id'], $arrId))
                                                    @foreach ($groupById as $i)
                                                        @if ($i['_id'] == $item['_id'])
                                                        <tr>
                                                            <td>{{$item['name']}}</td>
                                                            <td>
                                                                @if($i['social_media'])
                                                                {{number_format($i['social_media'], 2)}}
                                                                @else
                                                                {{(int)0}}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($i['pr_tv'])                                             
                                                                {{number_format($i['pr_tv'], 2)}}
                                                                @else
                                                                {{(int)0}}
                                                                @endif
                                                            </td>
                                                            <td>                                               
                                                                @if($i['kol_koc'])                                             
                                                                {{number_format($i['kol_koc'], 2)}}
                                                                @else
                                                                {{(int)0}}
                                                                @endif
                                                            </td>
                                                            <td>                                                    
                                                                @if($i['ooh'])                                             
                                                                {{number_format($i['ooh'], 2)}}
                                                                @else
                                                                {{(int)0}}
                                                                @endif
                                                            </td>
                                                            <td>                                           
                                                                @if($i['other'])                                             
                                                                {{number_format($i['other'], 2)}}
                                                                @else
                                                                {{(int)0}}
                                                                @endif
                                                            </td>
                                                            @php
                                                                $total_store = $i['social_media'] + $i['pr_tv'] + $i['kol_koc'] + $i['ooh'] + $i['other'];
                                                            @endphp
                                                            <td>{{number_format(round($total_store, 2), 2)}}</td>
                                                            <td>
                                                                @if ($all_total != 0)
                                                                {{number_format(round($total_store/$all_total*100, 2), 2)}}
                                                                @else
                                                                {{(int)0}}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @endif
                                                    @endforeach
                                                @else
                                                <tr>
                                                    <td>{{$item['name']}}</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                </tr>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @else
                                        @foreach ($dataFilter as $k => $item)
                                        <td style="vertical-align: middle;" rowspan="{{count($item) + 1}}">{{$k}}</td>
                                            @foreach ($item as $i) 
                                                @if (!empty($_GET['store_id']) && $i['id'] != $_GET['store_id'])
                                                    @continue
                                                @else
                                                <tr>
                                                    <td>
                                                        {{$i['store']}}
                                                    </td>
                                                    <td>
                                                        @if($i['social_media'])
                                                            {{number_format($i['social_media'], 2)}}
                                                        @else
                                                            {{(int)0}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($i['pr_tv'])
                                                            {{number_format($i['pr_tv'], 2)}}
                                                        @else
                                                            {{(int)0}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($i['kol_koc'])
                                                            {{number_format($i['kol_koc'], 2)}}
                                                        @else
                                                            {{(int)0}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($i['ooh'])
                                                            {{number_format($i['ooh'], 2)}}
                                                        @else
                                                            {{(int)0}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($i['other'])
                                                            {{number_format($i['other'], 2)}}
                                                        @else
                                                            {{(int)0}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{number_format($i['social_media'] + $i['pr_tv'] + $i['kol_koc'] + $i['ooh'] + $i['other'])}}
                                                    </td>
                                                    @if ($all_total != 0)
                                                        <td>{{number_format(round($i['social_media'] + $i['pr_tv'] + $i['kol_koc'] + $i['ooh'] + $i['other'])/$all_total*100 , 2)}}</td>
                                                    @else 
                                                        <td>{{(int)0}}</td>
                                                    @endif
                                                </tr>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @endif
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.14.0/js/selectize.min.js"></script>
<script type="text/javascript" src="{{ asset('viewcpanel/js/xlsx.js') }}"></script>
<script type="text/javascript">
    $(".create").on('click', function (e) {
        e.preventDefault();
        window.parent.postMessage({targetLink: "{{$cpanelCreate}}"}, "{{$cpanelPath}}");
    });
    $(".history").on('click', function (e) {
        e.preventDefault();
        window.parent.postMessage({targetLink: "{{$cpanelHistory}}"}, "{{$cpanelPath}}");
    })
    $(".report_link").on('click', function (e) {
        e.preventDefault();
        window.parent.postMessage({targetLink: "{{$cpanelUrl}}"}, "{{$cpanelPath}}");
    })
    $(".home").on('click', function (e) {
        e.preventDefault();
        window.parent.postMessage({targetLink: "{{$cpanelUrl}}"}, "{{$cpanelPath}}");
    })
    function export_macom(fileExtension, fileName){
        let el = document.getElementById("total_table");
        let el_tiny = document.getElementById("table_tiny");
        let wb = XLSX.utils.table_to_sheet(el, {sheet: 'Tổng hợp hệ thống'});
        let wc = XLSX.utils.table_to_sheet(el_tiny, {sheet: 'Chi phí theo tháng'});
        const ne = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(ne, wb,"Tổng hợp hệ thống");
        XLSX.utils.book_append_sheet(ne, wc,"Chi phí theo tháng");
        return XLSX.writeFile(ne, fileName+"."+fileExtension || ('MySheetName.' + (fileExtension || 'xlsx')));
    }
    //
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
    var dp = $("#start-date, #end-date").datepicker( {
        format: "yyyy-mm-dd",
        autoclose: true
    });
    var month = $('#start_month').datepicker({
        format: "yyyy-mm",
        autoclose: true,
        changeMonth: true,
        changeYear: true,
        changeDate: false,
        startView: "months", 
        minViewMode: "months",
        endDate: '+0m',
    })
    var month = $('#end_month').datepicker({
        format: "yyyy-mm",
        autoclose: true,
        changeMonth: true,
        changeYear: true,
        changeDate: false,
        startView: "months", 
        minViewMode: "months",
        endDate: '+0m',
    })
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
            format: "yyyy-mm",
            autoclose: true,
            changeMonth: true,
            changeYear: true,
            changeDate: false,
            startView: "months", 
            minViewMode: "months",
            endDate: '+0m',
        });

        $('#date2').datepicker({
            format: "yyyy-mm",
            autoclose: true,
            changeMonth: true,
            changeYear: true,
            changeDate: false,
            startView: "months", 
            minViewMode: "months",
            endDate: '+0m',
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
