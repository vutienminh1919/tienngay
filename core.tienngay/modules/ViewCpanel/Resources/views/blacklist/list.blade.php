@extends('viewcpanel::layouts.master')

@section('title', 'Blacklist')

@section('css')
    <link href="{{ asset('viewcpanel/css/reportsKsnb/index.css') }}" rel="stylesheet"/>
    <style type="text/css">
        .alert {
            z-index: 999 !important;
        }
        #fillter-content {
            width: 300px;
            right: 90px !important;
        }
    </style>
@endsection
@section('content')
<section class="main-content">
    <div id="loading" class="theloading" style="display: none;">
        <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    </div>
    <div id="top-view" class="container" style="max-width: 95% !important">
        <h3 class="tilte_top_tabs">
            Blacklist
        </h3>
        <div class="row" style="align-items: right;">
            <div class="col-xs-12 col-12">
                @include("viewcpanel::blacklist.filter")
            </div>
        </div>
        <div class="row" style="align-items: right;">
            <div class="col-xs-12 col-12">
            </div>
        </div>
        <div class="middle table_tabs">
            <p style="color: #047734"><strong>Total:</strong> <span id="total"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Page:</strong> <span id="page"></span></p>
            <div class="table-responsive" style="overflow-x: auto;">
                <table class="table" style="margin-bottom: 100px">
                    <thead>
                    <tr style="text-align: center">
                        <th scope="col" style="text-align: center;">
                            <input id="select-all" type="checkbox" data-attr='selected_all' name="selected_all">
                        </th>
                        <th scope="col" style="text-align: center;">STT</th>
                        <th scope="col" style="text-align: center; min-width: 200px;">CHỨC NĂNG</th>
                        <th scope="col" style="text-align: center; min-width: 200px;">HỌ VÀ TÊN</th>
                        <th scope="col" style="text-align: center; min-width: 200px;">SỐ ĐIỆN THOẠI</th>
                        <th scope="col" style="text-align: center; min-width: 200px;">SỐ CMND/CCCD</th>
                        <th scope="col" style="text-align: center; min-width: 200px;">SỐ HỘ CHIẾU</th>
                        <th scope="col" style="text-align: center; min-width: 200px;">NGÀY TẠO</th>
                        <th scope="col" style="text-align: center; min-width: 200px;">NGƯỜI TẠO</th>
                    </tr>
                    </thead>
                    <tbody align="center" id="listingTable"></tbody>
                </table>
            </div>
        </div>
        <nav aria-label="Page navigation" style="margin-top: 20px;">
            <ul class="pagination justify-content-end">
                <li id="btn_prev" class="page-item">
                    <a href="javascript:void(0);"  class="page-link">Previous</a>
                </li>
                <li id="btn_next" class="page-item">
                    <a href="javascript:void(0);"  class="page-link" >Next</a>
                </li>
            </ul>
        </nav>
    </div>
</section>

<!-- list object -->
<table id="clone-object" class="table table-striped" hidden >
    <thead>
    <tr style="text-align: center">
        <th style="text-align: center;"></th>
        <th style="text-align: center;">STT</th>
        <th scope="col" style="text-align: center; min-width: 150px;">Chức năng</th>
        <th scope="col" style="text-align: center; min-width: 150px;">Họ tên</th>
        <th scope="col" style="text-align: center; min-width: 150px;">Số điện thoại</th>
        <th scope="col" style="text-align: center; min-width: 150px;">Số CMT/CCCD</th>
        <th scope="col" style="text-align: center; min-width: 150px;">Số hộ chiếu</th>
        <th scope="col" style="text-align: center; min-width: 100px;">Ngày tạo</th>
        <th scope="col" style="text-align: center; min-width: 100px;">Người tạo</th>
    </tr>
    </thead>
    <tbody align="center" id="table-rows">
    <tr id="clone-item" data-id="">
        <td style="text-align: left;">
            <input id="selected_item" type="checkbox" class="selected_item" name="selected_item[]">
        </td>
        <td id="the_number"></td>
        <td class="print-none no-export" data-attr="_id" func="detailBlacklist"></td>
        <td data-attr='name'></td>
        <td data-attr='phone_number'></td>
        <td data-attr='identify'></td>
        <td data-attr='passport'></td>
        <td data-attr='created_at' timestamp='true'></td>
        <td data-attr='created_by'></td>
    </tr>
    </tbody>
</table>

<!-- export object -->
<table id="export-object" class="table table-striped" hidden>
    <thead>
    <tr style="text-align: center">
        <th style="text-align: center;">STT</th>
        <th scope="col" style="text-align: center; min-width: 150px;">Họ tên</th>
        <th scope="col" style="text-align: center; min-width: 150px;">Số điện thoại</th>
        <th scope="col" style="text-align: center; min-width: 150px;">Số CMT/CCCD</th>
        <th scope="col" style="text-align: center; min-width: 150px;">Số hộ chiếu</th>
        <th scope="col" style="text-align: center; min-width: 150px;">Ngày tạo</th>
        <th scope="col" style="text-align: center; min-width: 150px;">Người tạo</th>
        <th scope="col" style="text-align: center; min-width: 150px;"></th>
    </tr>
    </thead>
    <tbody align="center" id="table-rows">
    <tr id="clone-item" data-id="" style="background: #037734; color: #fff">
        <td id='transaction_no'>
            <input id="selected_item" type="checkbox" class="selected_item" name="selected_item[]">
        </td>
        <td data-attr='name'></td>
        <td data-attr='phone_number' zero-before='true'></td>
        <td data-attr='identify' zero-before='true'></td>
        <td data-attr='passport' zero-before='true'></td>
        <td data-attr='created_at' timestamp='true'></td>
        <td data-attr='created_by'></td>

    </tr>
    </tbody>
</table>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div style="margin-bottom: 800px" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thông tin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body row">
                        <div class="col-6" style="margin-bottom: 20px;">
                            <span>Họ và tên: </span> <span style="font-size: 20px" class="name"></span><br><br>
                            <span>Số điện thoại: </span><span style="font-size: 20px" class="phone"></span><br><br>
                            <span>CCCD/CMND/Hộ chiếu : </span><span style="font-size: 20px"
                                                                    class="identify_passport"></span>
                            <input hidden type="text" id="id_property">
                            <input hidden type="text" id="id_hcns">
                            <input hidden type="text" id="id_exemtion">
                            <input hidden type="text" id="id_contract">
                            <input hidden type="text" id="blacklist">
                        </div>
                        <div class="col-6" style="display:flex;flex-direction: column;gap: 15%">
                            <a href="" class="btn btn-danger property" onclick="detailProperty(this)">Cảnh
                                báo liên quan đến giấy tờ giả</a>

                            <div class="btn-group exemtion_btn">
                                <button type="button" class="btn btn-danger contract"
                                        style="font-style: 14px; border-radius: 5px"
                                        data-bs-toggle="dropdown" aria-expanded="false" onclick="contractDetail(this)">
                                    Cảnh báo liên quan đến nợ xấu&nbsp;<i class="fa fa-bars" aria-hidden="true"
                                                                          style="font-style: 14px"></i>
                                </button>
                                <ul class="dropdown-menu btn-detail">
                                </ul>
                            </div>

                            <a href="" class="btn btn-danger hcns" onclick="detailStaffLayOff(this)">Cảnh báo liên quan đến nhân
                                sự đã nghỉ việc </a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>

<div class="modal fade" id="errorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Error</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="msg_error"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    let transactions = @json($results);
    console.log(transactions);
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
    $('body').on('click', function (e) {
        if (e.target.id == "fillter-content" || $(e.target).parents("#fillter-content").length) {
            //do nothing
        } else {
            $("#fillter-content").hide();
        }
    });
    var dp = $("#start-date, #end-date").datepicker({
        format: "yyyy-mm-dd",
        autoclose: true
    });

    function detailBlacklist(val, el) {

    }
</script>
<script type="text/javascript">
    // Chi tiết thông tin all blacklist
    function detailBlacklistFeature(thiz) {
        let id = $(thiz).attr('data-id');
        let id_property = $(thiz).attr('data-id-property');
        let id_hcns = $(thiz).attr('data-id-hcns');
        let id_exemtion = $(thiz).attr('data-id-exemtion');
        let id_contract = $(thiz).attr('data-id-contract');
        let id_blacklist = $(thiz).attr('data-id-blacklist');
        let name = $(thiz).attr('data-name');
        let phone = $(thiz).attr('data-phone');
        let identify = $(thiz).attr('data-identify');
        let passport = $(thiz).attr('data-passport');

        $('.name').text(name);
        $('.phone').text(phone);
        $('#id_property').val(id_property);
        $('#id_exemtion').val(id_exemtion);
        $('#id_hcns').val(id_hcns);
        $('#id_contract').val(id_contract);
        $('#blacklist').val(id_blacklist);
        $('.property').attr('target', '_blank');
        console.log('property: ' + id_property)
        console.log('hcns: ' + id_hcns)
        console.log('exemtion: ' + id_exemtion)
        console.log('contract: ' + id_contract)
        console.log('blacklist: ' + id_blacklist)

        if (identify == "") {
            $('.identify_passport').text(passport);
        } else {
            $('.identify_passport').text(identify);
        }
        if (id_property != "" && id_hcns == "" && id_exemtion == "") {
            $('.hcns').attr('hidden', true);
            $('.exemtion').attr('hidden', true);
            $('.exemtion_btn').attr('hidden', true);
            $('.property').removeAttr('hidden');

        }
        if (id_hcns != "" && id_property == "" && id_exemtion == "") {
            $('.property').attr('hidden', true);
            $('.exemtion').attr('hidden', true);
            $('.exemtion_btn').attr('hidden', true);
            $('.hcns').removeAttr('hidden');

        }
        if (id_exemtion != "" && id_property == "" && id_hcns == "") {
            $('.property').attr('hidden', true);
            $('.hcns').attr('hidden', true);
            $('.exemtion').removeAttr('hidden');
            $('.exemtion_btn').removeAttr('hidden');

        }
        if (id_property != "" && id_hcns != "" && id_exemtion == "") {
            $('.exemtion').attr('hidden', true);
            $('.exemtion_btn').attr('hidden', true);
            $('.property').removeAttr('hidden');
            $('.hcns').removeAttr('hidden');
        }
        if (id_property != "" && id_exemtion != "" && id_hcns == "") {
            $('.hcns').attr('hidden', true);
            $('.property').removeAttr('hidden');
            $('.exemtion').removeAttr('hidden');
            $('.exemtion_btn').removeAttr('hidden');
        }
        if (id_hcns != "" && id_exemtion != "" && id_property == "") {
            $('.property').attr('hidden', true);
            $('.exemtion').removeAttr('hidden');
            $('.exemtion_btn').removeAttr('hidden');
            $('.hcns').removeAttr('hidden');
        }
        if (id_hcns != "" && id_exemtion != "" && id_property != "") {
            $('.exemtion').removeAttr('hidden');
            $('.exemtion_btn').removeAttr('hidden');
            $('.hcns').removeAttr('hidden');
            $('.property').removeAttr('hidden');
        }
    }

    // Chi tiết hợp đồng blacklist
    function contractDetail(thiz) {
        let contract_id = $('#id_contract').val()
        contract_id = contract_id.split(',');
        $(".btn-detail li").remove();
        $.each(contract_id, function (key, value) {
            key += 1
            let path = '{{$cpanelExemtion}}' + '/pawn/detail?id=' + value
            $(".btn-detail").append('<li><a class="dropdown-item" target="_blank" href="'+path+'">Chi tiết hợp đồng '+ key +' </a></li>');
        });
    }

    // Chi tiết tài sản blacklist
    function detailProperty() {
        let id = $('#id_property').val();
        window.open('{{$cpanelURL}}' + window.location.origin + '/cpanel/blacklist/detailProperty/' + id);
    }

    // Chi tiết nhân sự nghỉ việc blacklist
    function detailStaffLayOff() {
        let id = $('#id_hcns').val();
        window.open('{{$cpanelURL}}' + window.location.origin + '/cpanel/blacklist/detailHcns/' + id);
    }

</script>
<script type="text/javascript" src="{{ asset('viewcpanel/js/xlsx.js?v=') . time() }}"></script>
<script type="text/javascript" src="{{ asset('viewcpanel/js/blacklist/index.js?v=') . time() }}"></script>
@endsection


