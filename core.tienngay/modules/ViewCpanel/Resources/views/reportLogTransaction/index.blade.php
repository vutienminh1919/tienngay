@extends('viewcpanel::layouts.master')

@section('title', 'Báo Cáo Thời Gian Duyệt Phiếu Thu')

@section('css')
<link href="{{ asset('viewcpanel/css/reportLogTransaction/report.css') }}" rel="stylesheet"/>
<style type="text/css">
    .modal-backdrop {
        display: none !important;
    }
    .table>:not(caption)>*>* {
        border-width: 1px;
        white-space: nowrap;
        vertical-align: middle;
        text-align: center;
    }

    .table-responsive table th {
        color: #047734;
        border-color: #ccc!important;
        background-color: #047734;
        color: white;
    }
</style>
@endsection

@section('content')
<section class="main-content">
    <div id="loading" class="theloading" style="display: none;">
        <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    </div>
    <div class="container" style="max-width: 95% !important">
        <h5 class="tilte_top_tabs">
            Báo Cáo Thời Gian Duyệt Phiếu Thu
        </h5>

        <div class="row" style="align-items: right;">
            <div class="col-xs-12 col-12">
                @include("viewcpanel::reportLogTransaction.filter")
            </div>
        </div>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="active-main-tab" data-bs-toggle="tab" data-bs-target="#main-tab" type="button" role="tab" aria-controls="home" aria-selected="true">Form Thông Tin</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="active-tab-1" data-bs-toggle="tab" data-bs-target="#tab-1" type="button" role="tab" aria-controls="profile" aria-selected="false">Tổng Hợp 1</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="active-tab-2" data-bs-toggle="tab" data-bs-target="#tab-2" type="button" role="tab" aria-controls="contact" aria-selected="false">Tổng Hợp 2</button>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
        <!-- main tab -->
          <div class="tab-pane fade show active" id="main-tab" role="tabpanel" aria-labelledby="active-main-tab">
            <div class="middle table_tabs">
                <p style="color: #047734"><strong>Total:</strong> <span id="total"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Page:</strong> <span id="page"></span></p>
                <div class="table-responsive" style="overflow-x: auto;">
                    <table class="table">
                        <thead>
                            <tr style="text-align: center">
                                <th scope="col" style="min-width: 10px;" rowspan="2">STT</th>
                                <th scope="col" style="min-width: 100px;" rowspan="2">Tiến trình</th>
                                <th scope="col" style="min-width: 100px;" rowspan="2">Người thực hiện</th>
                                <th scope="col" style="min-width: 100px;" rowspan="2">Mã phiếu thu</th>
                                <th scope="col" style="min-width: 300px;" rowspan="2">Mã HĐ</th>
                                <th scope="col" style="min-width: 200px;" rowspan="2">Tên khách hàng</th>
                                <th scope="col" style="min-width: 150px;" rowspan="2">Phòng giao dịch</th>
                                <th scope="col" style="min-width: 100px;" rowspan="2">Số tiền thanh toán</th>
                                <th scope="col" style="min-width: 100px;" rowspan="2">Ngày thanh toán</th>
                                <th scope="col" style="min-width: 100px;" rowspan="2">Ngày bank nhận</th>
                                <th scope="col" style="min-width: 100px;" rowspan="2">PGD chậm trễ tạo phiếu thu (ngày)</th>
                                <th scope="col" style="min-width: 100px;" rowspan="2">Có miễn giảm</th>
                                <th scope="col" style="min-width: 100px;" rowspan="2">Loại thanh toán</th>
                                <th scope="col" style="min-width: 100px;" rowspan="2">Thời gian PGD gửi duyệt</th>
                                <th scope="col" style="min-width: 100px;" colspan="4">Thời gian phản hồi <br>của Kế Toán</th>
                                <th scope="col" style="min-width: 100px;" rowspan="2">Thời gian Kế Toán <br>xử lý (phút)</th>
                                <th scope="col" style="min-width: 100px;" rowspan="2">Thời gian chờ <br>xử lý (giờ)</th>
                                <th scope="col" style="min-width: 100px;" rowspan="2">Thời gian Kế Toán duyệt quá <br>khung giờ xử lý (phút)</th>
                                <th scope="col" style="min-width: 100px;" rowspan="2">Thời gian PGD xử lý sau khi <br>Kế Toán trả về (giờ)</th>
                                <th scope="col" style="min-width: 300px; max-width: 400px;" rowspan="2">Lý do</th>
                                <th scope="col" style="min-width: 100px;" rowspan="2">Ghi chú</th>
                                <th scope="col" style="min-width: 150px;" rowspan="2">Số lần Kế Toán phản hồi</th>
                            </tr>
                            <tr style="text-align: center">
                                <th scope="col" style="min-width: 100px;">Kế toán click xử lý</th>
                                <th scope="col" style="min-width: 100px;">Trả về</th>
                                <th scope="col" style="min-width: 100px;">Huỷ</th>
                                <th scope="col" style="min-width: 100px;">Duyệt</th>
                            </tr>
                        </thead>
                        <tbody align="center" id="listingTable">

                        </tbody>
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
        <!-- main tab end -->

        <!-- tab 1 -->
          <div class="tab-pane fade" id="tab-1" role="tabpanel" aria-labelledby="active-tab-1">
              <!-- export object -->
              <div class="table-responsive" style="overflow-x: auto;">
                <table id="report-object2" class="table table-striped caption-top" >
                    <caption style="text-align:left">TỔNG HỢP LỆNH PGD GỬI DUYỆT</caption>
                    <thead>
                        <tr style="text-align: center">
                            <th scope="col" style="min-width: 10px;">STT</th>
                            <th scope="col" style="min-width: 100px;">Phòng giao dịch</th>
                            <th scope="col" style="min-width: 100px;">Tổng số lần kế toán xử lý</th>
                            <th scope="col" style="min-width: 300px;">Số lần xử lý trả về</th>
                            <th scope="col" style="min-width: 300px;">Số lần xử lý huỷ</th>
                            <th scope="col" style="min-width: 200px;">Khoảng thời gian từ ngày khách hàng thanh toán đến thời điểm PGD gửi duyệt lệnh trung bình (ngày)</th>
                            <th scope="col" style="min-width: 150px;">Thời gian PGD xử lý phiếu thu trung bình (giờ)</th>
                            <th scope="col" style="min-width: 150px;">Thời gian PGD xử lý phiếu thu tất toán trung bình (giờ)</th>
                            <th scope="col" style="min-width: 150px;">Tổng thời gian PGD xử lý phiếu thu tất toán có miễn giảm (giờ)</th>
                            <th scope="col" style="min-width: 150px;">Tổng thời gian PGD xử lý phiếu thu gia hạn, cơ cấu (giờ)</th>
                            <th scope="col" style="min-width: 150px;">Tổng số lần gửi duyệt trong giờ hành chính</th>
                            <th scope="col" style="min-width: 150px;">Tổng số lần gửi duyệt sau giờ hành chính</th>
                        </tr>
                    </thead>
                    <tbody align="center" id="table-rows">

                    </tbody>
                    <tbody align="center" hidden>
                        <tr id="clone-item" data-id="" style="background: #037734, color: #fff">
                            <td id="transaction_no" style="text-align: left;">
                                <input id="selected_item" type="checkbox" class="selected_item" name="selected_item[]">
                            </td>
                            <td data-attr='store_name'></td>
                            <td data-attr='total_approved' total-column=true></td>
                            <td data-attr='total_tra_ve' total-column=true></td>
                            <td data-attr='total_huy' total-column=true></td>
                            <td data-attr='avg_request_delay_time' total-column=true func="customeDay"></td>
                            <td data-attr='avg_resend_request_time' total-column=true func="processHourTime"></td>
                            <td data-attr='avg_request_delay_time_tat_toan' total-column=true func="processHourTime"></td>
                            <td data-attr='avg_request_delay_time_mien_giam' total-column=true func="processHourTime"></td>
                            <td data-attr='avg_request_delay_time_gia_han_co_cau' total-column=true func="processHourTime"></td>
                            <td data-attr='total_request_in_office_hour' total-column=true></td>
                            <td data-attr='total_request_out_office_hour' total-column=true></td>
                        </tr>
                    </tbody>
                    
                </table>

                <!-- export object -->
                <table id="report-object3" class="table table-striped caption-top" >
                    <caption style="text-align:left">CHI TIẾT LỖI PGD THƯỜNG GẶP</caption>
                    <thead>
                        <tr style="text-align: center">
                            <th scope="col" style="min-width: 10px;">STT</th>
                            <th scope="col" style="min-width: 100px;">Phòng giao dịch</th>
                            <th scope="col" style="min-width: 100px;">Huỷ Trùng lệnh</th>
                            <th scope="col" style="min-width: 100px;">Huỷ Sai số tiền</th>
                            <th scope="col" style="min-width: 300px;">Huỷ Sai phương thức thanh toán</th>
                            <th scope="col" style="min-width: 300px;">Huỷ Sai loại thanh toán</th>
                            <th scope="col" style="min-width: 200px;">Huỷ Sai thông tin miễn giảm</th>
                            <th scope="col" style="min-width: 150px;">Huỷ Lỗi GD duyệt định danh</th>
                            <th scope="col" style="min-width: 150px;">Huỷ Lỗi gộp GD ngân hàng</th>
                            <th scope="col" style="min-width: 150px;">Huỷ Sai ngày thanh toán</th>
                            <th scope="col" style="min-width: 150px;">Huỷ PT HeyU</th>
                            <th scope="col" style="min-width: 150px;">Trả về Thiếu chứng từ</th>
                            <th scope="col" style="min-width: 150px;">Trả về Sai thông tin miễn giảm</th>
                            <th scope="col" style="min-width: 150px;">Trả về Sai thông tin liên quan tới gia hạn</th>
                            <th scope="col" style="min-width: 150px;">Trả về Sai thông tin liên quan tới cơ cấu</th>
                            <th scope="col" style="min-width: 150px;">Trả về Sai thông tin PT HeyU</th>
                            <th scope="col" style="min-width: 150px;">Trả về Bổ sung xác nhận huỷ PT tiền mặt của quản lý</th>
                            <th scope="col" style="min-width: 150px;">Tổng số lỗi</th>
                        </tr>
                    </thead>
                    <tbody align="center" id="table-rows">

                    </tbody>
                    <tbody align="center" hidden>
                        <tr id="clone-item" data-id="" style="background: #037734, color: #fff">
                            <td id="transaction_no" style="text-align: left;">
                                <input id="selected_item" type="checkbox" class="selected_item" name="selected_item[]">
                            </td>
                            <td data-attr='store_name'></td>
                            <td data-attr='cancel_trung_lenh' total-column=true></td>
                            <td data-attr='cancel_sai_tien' total-column=true></td>
                            <td data-attr='cancel_sai_pttt' total-column=true></td>
                            <td data-attr='cancel_sai_loai_tt' total-column=true></td>
                            <td data-attr='cancel_sai_tt_mg' total-column=true></td>
                            <td data-attr='cancel_loi_gd_duyet_dd' total-column=true></td>
                            <td data-attr='cancel_loi_gop_gd_bank' total-column=true></td>
                            <td data-attr='cancel_sai_ngay_tt' total-column=true></td>
                            <td data-attr='cancel_huy_pt_heyu' total-column=true></td>
                            <td data-attr='return_thieu_chung_tu' total-column=true></td>
                            <td data-attr='return_sai_tt_mg' total-column=true></td>
                            <td data-attr='return_sai_tt_gh' total-column=true></td>
                            <td data-attr='return_sai_tt_cc' total-column=true></td>
                            <td data-attr='return_sai_tt_heyu' total-column=true></td>
                            <td data-attr='return_bo_sung_xac_nhan_huy_ty_ql' total-column=true></td>
                            <td data-attr='sum' total-column=true ></td>
                        </tr>
                    </tbody>
                </table>
            </div>
          </div>
        <!-- tab 1 end -->

        <!-- tab 2 -->
          <div class="tab-pane fade" id="tab-2" role="tabpanel" aria-labelledby="active-tab-2">
              <!-- export object -->
            <div class="table-responsive" style="overflow-x: auto;">
                <table id="report-object1" class="table table-striped caption-top" >
                    <caption style="text-align:left">BÁO CÁO THEO DÕI TIẾN ĐỘ XỬ LÝ PHIẾU THU</caption>
                    <thead>
                        <tr style="text-align: center">
                            <th scope="col" style="min-width: 10px;">STT</th>
                            <th scope="col" style="min-width: 100px;">Người thực hiện</th>
                            <th scope="col" style="min-width: 100px;">Tổng số lần xử lý phiểu thu</th>
                            <th scope="col" style="min-width: 300px;">Tổng số lệnh xử lý trong giờ hành chính</th>
                            <th scope="col" style="min-width: 300px;">Số lệnh xử lý trong khung 10-11 giờ</th>
                            <th scope="col" style="min-width: 200px;">Số lệnh xử lý trong khung 14-15h</th>
                            <th scope="col" style="min-width: 150px;">Số lệnh xử lý trong khung 16h30-17h30</th>
                            <th scope="col" style="min-width: 150px;">Tổng số lệnh xử lý ngoài giờ hành chính</th>
                            <th scope="col" style="min-width: 150px;">Số lệnh tất toán xử lý ngoài giờ hành chính</th>
                            <th scope="col" style="min-width: 150px;">Tổng thời gian xử lý lệnh tất toán ngoài giờ hành chính (phút)</th>
                            <th scope="col" style="min-width: 150px;">Thời gian bộ phận kế toán xử lý trung bình (phút)</th>
                            <th scope="col" style="min-width: 150px;">Thời gian chờ xử lý  trung bình (giờ)</th>
                            <th scope="col" style="min-width: 150px;">Số lệnh xử lý vượt quá khung thời gian quy định</th>
                        </tr>
                    </thead>
                    <tbody align="center" id="table-rows">

                    </tbody>
                    <tbody align="center" hidden>
                        <tr id="clone-item" data-id="" style="background: #037734, color: #fff">
                            <td id="transaction_no" style="text-align: left;">
                                <input id="selected_item" type="checkbox" class="selected_item" name="selected_item[]">
                            </td>
                            <td data-attr='approve_by'></td>
                            <td data-attr='total_approved' total-column=true></td>
                            <td data-attr='total_approved_office_hour' total-column=true></td>
                            <td data-attr='total_approved_10_11h' total-column=true></td>
                            <td data-attr='total_approved_14_15h' total-column=true></td>
                            <td data-attr='total_approved_16h30_17h30' total-column=true></td>
                            <td data-attr='total_approved_out_office_hour' total-column=true></td>
                            <td data-attr='total_approved_out_office_hour_type_tat_toan' total-column=true></td>
                            <td data-attr='total_time_approved_out_office_hour_type_tat_toan' total-column=true func="minutesTime"></td>
                            <td data-attr='avg_process_minutes_time' total-column=true func="minutesTime"></td>
                            <td data-attr='avg_process_hour_time' total-column=true func="processHourTime"></td>
                            <td data-attr='total_approved_over_time' total-column=true></td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
        <!-- tab 2 end -->
        </div>
        
    </div>
</section>
<!-- clone object -->
<table id="clone-object" class="table table-striped" hidden >
    <thead>
        <tr style="text-align: center">
            <th scope="col" style="min-width: 10px;" rowspan="2">STT</th>
            <th scope="col" style="min-width: 100px;" rowspan="2">Tiến trình</th>
            <th scope="col" style="min-width: 100px;" rowspan="2">Người thực hiện</th>
            <th scope="col" style="min-width: 100px;" rowspan="2">Mã phiếu thu</th>
            <th scope="col" style="min-width: 300px;" rowspan="2">Mã HĐ</th>
            <th scope="col" style="min-width: 200px;" rowspan="2">Tên khách hàng</th>
            <th scope="col" style="min-width: 150px;" rowspan="2">Phòng giao dịch</th>
            <th scope="col" style="min-width: 100px;" rowspan="2">Số tiền thanh toán</th>
            <th scope="col" style="min-width: 100px;" rowspan="2">Ngày thanh toán</th>
            <th scope="col" style="min-width: 100px;" rowspan="2">Ngày bank nhận</th>
            <th scope="col" style="min-width: 100px;" rowspan="2">PGD chậm trễ tạo phiếu thu (ngày)</th>
            <th scope="col" style="min-width: 100px;" rowspan="2">Có miễn giảm</th>
            <th scope="col" style="min-width: 100px;" rowspan="2">Loại thanh toán</th>
            <th scope="col" style="min-width: 100px;" rowspan="2">Thời gian PGD gửi duyệt</th>
            <th scope="col" style="min-width: 100px;" colspan="4">Thời gian phản hồi của Kế Toán</th>
            <th scope="col" style="min-width: 100px;" rowspan="2">Thời gian Kế Toán xử lý (phút)</th>
            <th scope="col" style="min-width: 100px;" rowspan="2">Thời gian chờ xử lý (giờ)</th>
            <th scope="col" style="min-width: 100px;" rowspan="2">Thời gian Kế Toán duyệt quá khung giờ xử lý (phút)</th>
            <th scope="col" style="min-width: 100px;" rowspan="2">Thời gian PGD xử lý sau khi Kế Toán trả về (giờ)</th>
            <th scope="col" style="min-width: 300px; max-width: 400px;" rowspan="2">Lý do</th>
            <th scope="col" style="min-width: 100px;" rowspan="2">Ghi chú</th>
            <th scope="col" style="min-width: 150px;" rowspan="2">Số lần Kế Toán phản hồi</th>
        </tr>
        <tr style="text-align: center">
            <th scope="col" style="min-width: 100px;">Kế toán click xử lý</th>
            <th scope="col" style="min-width: 100px;">Trả về</th>
            <th scope="col" style="min-width: 100px;">Huỷ</th>
            <th scope="col" style="min-width: 100px;">Duyệt</th>
        </tr>
    </thead>
    <tbody align="center" id="table-rows">
        <tr id="clone-item" data-id="">
            <td id="transaction_no" style="text-align: center;">
                <input id="selected_item" type="checkbox" class="selected_item" name="selected_item[]">
            </td>
            <td data-attr='progress_text'></td>
            <td data-attr='approve_by'></td>
            <td data-attr='trancode'></td>
            <td data-attr='code_contract_disbursement'></td>
            <td data-attr='customer_name'></td>
            <td data-attr='store_name'></td>
            <td data-attr='amount' format-number='true'></td>
            <td data-attr='date_paid' func='customeTime'></td>
            <td data-attr='bank_date' func='customeTime'></td>
            <td data-attr='request_delay_time' func='customeDay'></td>
            <td data-attr='total_deductible' func='totalDeductible' style="font-size: 20px;"></td>
            <td data-attr='transaction_type'></td>
            <td data-attr='request_time' func='customeTime'></td>
            <td data-attr='first_click_time' func='customeTime'></td>
            <td data-attr='action_tra_ve_time' func='customeTime'></td>
            <td data-attr='action_huy_time' func='customeTime'></td>
            <td data-attr='action_duyet_time' func='customeTime'></td>
            <td data-attr='process_minutes_time' func='minutesTime'></td>
            <td data-attr='process_hour_time' func='processHourTime'></td>
            <td data-attr='approve_over_time' func='minutesTime'></td>
            <td data-attr='resend_request_time' func='processHourTime'></td>
            <td data-attr='approve_require_note' style="white-space: break-spaces;" func='requireNote'></td>
            <td data-attr='approve_note' style="white-space: break-spaces;"></td>
            <td data-attr='approve_count'></td>
        </tr>
    </tbody>
</table>

<!-- export object -->
<table id="export-object" class="table table-striped" hidden >
    <thead>
        <tr style="text-align: center">
            <th scope="col" style="min-width: 10px;" rowspan="2">STT</th>
            <th scope="col" style="min-width: 100px;" rowspan="2">Người thực hiện</th>
            <th scope="col" style="min-width: 100px;" rowspan="2">Mã phiếu thu</th>
            <th scope="col" style="min-width: 300px;" rowspan="2">Mã HĐ</th>
            <th scope="col" style="min-width: 200px;" rowspan="2">Tên khách hàng</th>
            <th scope="col" style="min-width: 150px;" rowspan="2">Phòng giao dịch</th>
            <th scope="col" style="min-width: 100px;" rowspan="2">Số tiền thanh toán</th>
            <th scope="col" style="min-width: 100px;" rowspan="2">Ngày thanh toán</th>
            <th scope="col" style="min-width: 100px;" rowspan="2">Ngày bank nhận</th>
            <th scope="col" style="min-width: 100px;" rowspan="2">PGD chậm trễ tạo phiếu thu (ngày)</th>
            <th scope="col" style="min-width: 100px;" rowspan="2">Có miễn giảm</th>
            <th scope="col" style="min-width: 100px;" rowspan="2">Loại thanh toán</th>
            <th scope="col" style="min-width: 100px;" rowspan="2">Thời gian PGD gửi duyệt</th>
            <th scope="col" style="min-width: 100px;" colspan="4">Thời gian phản hồi của Kế Toán</th>
            <th scope="col" style="min-width: 100px;" rowspan="2">Thời gian Kế Toán xử lý (phút)</th>
            <th scope="col" style="min-width: 100px;" rowspan="2">Thời gian chờ xử lý (giờ)</th>
            <th scope="col" style="min-width: 100px;" rowspan="2">Thời gian Kế Toán duyệt quá khung giờ xử lý (phút)</th>
            <th scope="col" style="min-width: 100px;" rowspan="2">Thời gian PGD xử lý sau khi Kế Toán trả về (giờ)</th>
            <th scope="col" style="min-width: 300px; max-width: 400px;" rowspan="2">Lý do</th>
            <th scope="col" style="min-width: 100px;" rowspan="2">Ghi chú</th>
            <th scope="col" style="min-width: 150px;" rowspan="2">Số lần Kế Toán phản hồi</th>
        </tr>
        <tr style="text-align: center">
            <th scope="col" style="min-width: 100px;">Kế toán click xử lý</th>
            <th scope="col" style="min-width: 100px;">Trả về</th>
            <th scope="col" style="min-width: 100px;">Huỷ</th>
            <th scope="col" style="min-width: 100px;">Duyệt</th>
        </tr>
    </thead>
    <tbody align="center" id="table-rows">
        <tr id="clone-item" data-id="" style="background: #037734, color: #fff">
            <td id="transaction_no" style="text-align: center;">
                <input id="selected_item" type="checkbox" class="selected_item" name="selected_item[]">
            </td>
            <td data-attr='approve_by'></td>
            <td data-attr='trancode'></td>
            <td data-attr='code_contract_disbursement'></td>
            <td data-attr='customer_name'></td>
            <td data-attr='store_name'></td>
            <td data-attr='amount' format-number='true'></td>
            <td data-attr='date_paid' func='customeTime'></td>
            <td data-attr='bank_date' func='customeTime'></td>
            <td data-attr='request_delay_time' func='customeDay'></td>
            <td data-attr='total_deductible' func='totalDeductible' style="font-size: 20px;"></td>
            <td data-attr='transaction_type'></td>
            <td data-attr='request_time' func='customeTime'></td>
            <td data-attr='first_click_time' func='customeTime'></td>
            <td data-attr='action_tra_ve_time' func='customeTime'></td>
            <td data-attr='action_huy_time' func='customeTime'></td>
            <td data-attr='action_duyet_time' func='customeTime'></td>
            <td data-attr='process_minutes_time' func='minutesTime'></td>
            <td data-attr='process_hour_time' func='processHourTime'></td>
            <td data-attr='approve_over_time' func='minutesTime'></td>
            <td data-attr='resend_request_time' func='processHourTime'></td>
            <td data-attr='approve_require_note' style="white-space: break-spaces;" func='requireNote'></td>
            <td data-attr='approve_note' style="white-space: break-spaces;"></td>
            <td data-attr='approve_count'></td>
        </tr>
    </tbody>
</table>


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
<div class="modal fade" id="successModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Thành công</h5>
          </div>
          <div class="modal-body">
            <p class="msg_success text-success"></p>
          </div>
          <div class="modal-footer">
           
          </div>
        </div>
      </div>
    </div>
@endsection

@section('script')
<script type="text/javascript">
    var transactions = @json($results['result']);
    var report1 = @json($results['report1']);
    var report2 = @json($results['report2']);
    var report3 = @json($results['report3']);
    console.log(transactions);
    console.log(report1);
    console.log(report2);
    console.log(report3);
    $("#fillter-button").on("click", function (event) {
        event.stopPropagation();
        $("#fillter-content").toggle();
    })
    $('#import_record').on('click', function(e){
        $('#modal_import').modal('show');
        e.preventDefault();
    });
    var dp = $("#select-time-2").datepicker( {
        format: "yyyy-mm",
        startView: "months",
        minViewMode: "months",
        autoclose: true
    });
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
    })
    function customeTime($value) {
        $value = parseInt($value);
        if ($value > 0) {
            var date = new Date($value * 1000);
            return date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate() + ' ' + date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds();
        }
        return "";
    }
    function totalDeductible($value) {
        $value = parseInt($value);
        if ($value > 0) {
            return "×";
        }
        return "";
    }
    function requireNote($value) {
        if ($value != "" && $value != undefined && $value != null) {
            let _data = JSON.parse($value);
            let _results = '';
            if (_data && typeof _data == 'object') {
                for(let i = 0; i < _data.length; i++) {
                    _results += _data[i]['value'] + '; ';
                }
            }
            return _results;
        } else {
            return "";
        }
        
    }
    function minutesTime ($value) {
        $value = parseInt($value);
        if ($value > 0) {
            return Math.round(($value/60) * 100) / 100;
        }
        return 0;
    }
    function processHourTime($value) {
        $value = parseInt($value);
        if ($value > 0) {
            return Math.round(($value/(60*60)) * 100) / 100;
        }
        return 0;
    }
    function customeDay($value) {
        $value = parseInt($value);
        if ($value > 0) {
            return Math.round(($value/(60*60*24)) * 100) / 100;
        }
        return 0;
    }
    function formatFloat($value) {
        return Math.round($value * 100) / 100;
    }
</script>
<script type="text/javascript">
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
<script type="text/javascript" src="{{ asset('viewcpanel/js/xlsx.js') }}"></script>
<script type="text/javascript" src="{{ asset('viewcpanel/js/reportLogTransaction/report.js') }}"></script>
@endsection
