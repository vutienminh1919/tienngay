@extends('viewcpanel::layouts.master')

@section('title', 'Giao dịch VPBank')

@section('css')
<link href="{{ asset('viewcpanel/css/vpbank/storeCodes.css') }}" rel="stylesheet"/>
@endsection

@section('content')
<section class="main-content">
    <div id="loading" class="theloading" style="display: none;">
        <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    </div>
    <div class="container">
        <h5 class="tilte_top_tabs">
            Danh Sách Quản Lý Phòng Giao Dịch
        </h5>
        <div class="middle table_tabs" style="margin-top: 100px;">
            <p hidden>Page: <span id="page"></span></p>
            <div class="table-responsive" style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr style="text-align: center">
                            <th style="text-align: center;">STT</th>
                            <th scope="col" style="text-align: left; min-width: 200px;">Tên Phòng GD</th>
                            <th scope="col" style="text-align: center; min-width: 50px;">VPBank Code</th>
                            <th scope="col" style="text-align: center; min-width: 50px;">Số Điện Thoại</th>
                            <th scope="col" style="text-align: center">Địa Chỉ</th>
                            <th scope="col" style="text-align: center">Trạng Thái</th>
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
</section>
<!-- clone object -->
<table id="clone-object" class="table table-striped" hidden >
    <thead>
        <tr style="text-align: center">
            <th style="text-align: center;">STT</th>
            <th scope="col" style="text-align: left;">Tên Phòng GD</th>
            <th scope="col" style="text-align: center;">VPBank Code</th>
            <th scope="col" style="text-align: center;">Số Điện Thoại</th>
            <th scope="col" style="text-align: center">Địa Chỉ</th>
            <th scope="col" style="text-align: center">Trạng Thái</th>
        </tr>
    </thead>
    <tbody align="center" id="table-rows">
        <tr id="clone-item" data-id="">
            <td id="transaction_no" style="text-align: left;"></td>
            <td style="text-align: left;" data-attr='name'></td>
            <td data-attr='vpb_store_code'></td>
            <td data-attr='phone'></td>
            <td data-attr='address'></td>
            <td data-attr='status'></td>
        </tr>
    </tbody>
</table>
<div id="errorModal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box danger">
                    <i class="fa fa-times"></i>
                </div>
                <h4 class="modal-title">Error</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <p class="msg_error"></p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    var transactions = @json($stores);
    console.log(transactions);

</script>
<script type="text/javascript">
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
<script type="text/javascript" src="{{ asset('viewcpanel/js/vpbank/storeCodes.js') }}"></script>
@endsection
