@extends('viewcpanel::layouts.master')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" rel="stylesheet"/>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .table-of-contents a {
        text-decoration: none;
        font-weight: 400;
        font-size: 12px;
        line-height: 14px;
        color: #676767;
        text-decoration: none;
    }

    th {
        font-style: normal;
        font-weight: 600;
        font-size: 14px;
        line-height: 35px;
        color: #262626;
        border-bottom-width: 0px !important;
        white-space: nowrap;
        text-align: center !important;
    }

    .wrapper {
        width: 100%;
        /* background-color: #E5E5E5; */
    }

    .header {
        display: flex;
        justify-content: space-between;
        padding-top: 10px;
        padding: 10px 40px 0px;
    }

    .header h2 {
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        line-height: 24px;
        color: #3B3B3B;
        margin: 0px;
    }

    .header button {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        width: 100px;
        height: 40px;
        background: #D8D8D8;
        border-radius: 8px;
        border: none;
        font-style: normal;
        font-weight: 600;
        font-size: 14px;
        line-height: 16px;
        color: #676767;
    }
    .back {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        width: 100px;
        height: 40px;
        background: #D8D8D8;
        border-radius: 8px;
        border: none;
        font-style: normal;
        font-weight: 600;
        font-size: 14px;
        line-height: 16px;
        color: #676767;
        text-decoration:none
    }

    .style-container {
        background: #fff;
        padding: 24px 16px;
        border-radius: 8px;
        margin: 24px 40px;
    }

    .style-container h3 {
        color: #3B3B3B;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;

    }

    .form-ip {
        display: flex;
        flex-direction: column;
        gap: 8px;
        padding-top: 8px;
    }

    .form-ip input {
        padding: 16px;
        gap: 8px;
        width: 100%;
        height: 40px;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        outline: none;
    }

    .form-ip select {
        gap: 8px;
        width: 100%;
        height: 40px;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        outline: none;
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        display: flex;
        align-items: center;
        color: #676767;
        padding: 5px 16px;
    }

    .form-ip p {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #3B3B3B;
        margin: 0px;
    }

    .list-publications {
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
        border-radius: 8px;
        margin: 24px 40px;
    }

    .list-publications p {
        color: #3B3B3B;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        padding: 16px;
        margin: 0px;
        text-align: left;
    }

    thead {
        background-color: #E8F4ED;
    }

    .list-publications {
        background: #E8F4ED;
        text-align: center;
        text-align: center;
        font-style: normal;
        font-weight: 600;
        font-size: 14px;
        line-height: 16px;
        color: #262626;
    }

    /*.list-publications td {*/
    /*    text-align: center;*/
    /*    font-style: normal;*/
    /*    font-weight: 400;*/
    /*    font-size: 14px;*/
    /*    line-height: 16px;*/
    /*    color: #676767;*/


    td {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #676767;
        white-space: nowrap;
        text-align: center;
    }

    .footer {
        display: flex;
        justify-content: flex-end;
        padding: 0 16px;
    }
    .page-link {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #676767;
    }

    .page-link:focus {
        background-color: #1D9752 !important;
        color: #fff !important;
    }
    th {
        white-space: nowrap !important;
    }
    .form-footer {
        width: 100%;
    }
    .form-footer textarea {
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        width: 100%;
        padding: 16px;
        /* margin-left: 35px; */
    }
    .header > .btn-green {
        width: 153px;
        height: 40px;
        background: #1D9752;
        font-style: normal;
        font-weight: 600;
        font-size: 14px;
        line-height: 16px;
        color: #FFFFFF;
        border-radius: 8px;
        border: none;
    }
        .header {
        display: flex;
        justify-content: space-between;
        padding: 10px 40px 0px;
    }

    .header h2 {
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        line-height: 24px;
        color: #3B3B3B;
    }

    .table-of-contents a {
        font-weight: 400;
        font-size: 12px;
        line-height: 14px;
        color: #676767;
        text-decoration: none;
    }

    .header-btn {
        display: flex;
    }

    .header-btn > a {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        width: 100px;
        height: 40px;
        background: #D8D8D8;
        border-radius: 5px;
        border: none;
        font-style: normal;
        font-weight: 600;
        font-size: 14px;
        line-height: 16px;
        color: #676767;
        text-decoration:none;
        margin-right:10px;
    }

    .header-btn > button {
        width: 153px;
        height: 40px;
        background: #1D9752;
        font-style: normal;
        font-weight: 600;
        font-size: 14px;
        line-height: 16px;
        color: #FFFFFF;
        border-radius: 8px;
        border: none;
    }
    .header-btn {
        display: flex;
    }
    .reason-cancel {
        background-color: #FFFFFF;
        border: 1px solid #F0F0F0;
        border-radius: 8px;
        margin: 30px 40px;
        padding: 24px 16px;
    }

    .reason-cancel label {
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        color: #3B3B3B;
        margin-bottom: 16px;
    }

    .reason-cancel textarea {
        height: 100px;
        width: 100%;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        padding: 16px;
        background-color: #E6E6E6;;
    }
    .modal-content {
        padding: 24px 16px;
    }

    .title h5 {
        text-align: center;
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        color: #3B3B3B;
    }

    .title p {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        text-align: center;
        color: #676767;
    }

    .btn{
        color: #676767 !important;
    }

    .btn-footer {
        display: flex;
        justify-content: space-between;
    }
    .form-ip {
        display: flex;
        flex-direction: column;
        gap: 4px;
        padding-top: 10px;
    }

    .form-ip input {
        padding: 16px;
        gap: 8px;
        width: 100%;
        height: 40px;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        outline: none;
    }

    .form-ip select {
        gap: 8px;
        width: 100%;
        height: 40px;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        outline: none;
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        display: flex;
        align-items: center;
        color: #676767;
        padding: 5px 16px;
    }

    .form-ip input::placeholder {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        display: flex;
        align-items: center;
        color: #676767;
    }

    .form-ip p {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #3B3B3B;
        margin: 0px;
    }

    .form-ip span {
        font-style: normal;
        font-weight: 400;
        font-size: 10px;
        line-height: 12px;
        color: #676767;
    }

    .style-container {
        background-color: #FFFFFF;
        border: 1px solid #F0F0F0;
        border-radius: 8px;
        margin: 30px 40px;
        padding: 24px 16px;
    }

    .style-container h3 {
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
    }

    .form-ip {
        display: flex;
        flex-direction: column;
        gap: 4px;
        padding-top: 10px;
    }

    .form-ip input {
        padding: 16px;
        gap: 8px;
        width: 100%;
        height: 40px;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        outline: none;
    }

    .form-ip select {
        gap: 8px;
        width: 100%;
        height: 40px;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        outline: none;
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        display: flex;
        align-items: center;
        color: #676767;
        padding: 5px 16px;
    }

    .list-publications {
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
        border-radius: 8px;
        margin: 24px 40px;
    }

    .inputfile-box {
        position: relative;
        padding: 16px;
        width: 100%;
        height: 40px;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
    }

    .inputfile {
        display: none;
    }

    .file-box {
        width: 100%;
        height: 100%;
        box-sizing: border-box;
    }

    .file-button {
        padding-right: 12px;
        position: absolute;
        right: 0;
    }

    .style-label-ip {
        display: flex;
        align-items: center;
    }

    .style-label-ip span {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        display: flex;
        align-items: center;
        color: #B8B8B8;
        margin-top: -5px;
    }

    .btn-modal {
        display: flex;
        justify-content: space-between;
        margin-top: 16px;
    }

    .btn-accept {
        width: 200px;
        height: 40px;
        background: #1D9752;
        border-radius: 8px;
        font-style: normal;
        font-weight: 600;
        font-size: 14px;
        line-height: 16px;
        color: #FFFFFF;
        border: none;
    }

    .btn-delete {
        width: 200px;
        height: 40px;
        background: #D8D8D8;
        border-radius: 8px;
        font-style: normal;
        font-weight: 600;
        font-size: 14px;
        line-height: 16px;
        color: #676767;
        border: none;
    }

    .star {
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #C70404;
    }

    .status {
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        display: flex;
        align-items: center;
        color: #1D9752;
    }
    .img-area {
        border: solid 1px #D8D8D8;
        border-radius: 5px;
        padding: 3px;
        /*margin-bottom: 10px;*/
        position: relative;
    }
    #call-to-action {
        width: 120px;
        /*border: solid 1px #1D9752;*/
        font-size: 14px;
        color: #4299E1;
        border-radius: 5px;
        font-weight: 400;
        padding: 5px 0;
    }
    .cancelButton {
          -moz-appearance: none;
          -webkit-appearance: none;
          top: -3px;
          right: 3px;
          color: #000;
          text-align: center;
          font-weight: 700;
          background-color: transparent;
          padding: 0;
          margin: 0;
          border: 0;
          font-size: 16px;
          right: -8px;
          top: -8px;
          line-height: 15px;
          border-radius: 100%;
          background-color: #fff;
          position: inherit;
      }
    .block img, video {
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 100%;
        max-height: 100%;
    }
    .invalid {
        font-size: 13px;
        color: red;
        font-weight: 500;
    }
    .countImg {
        color: white;
        font-weight: bold;
        position: absolute;
        top: 58%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 2;
        padding: 20px;
        text-align: center;
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
    .is-animated {
        width:100%;
        height:1000px;
    }
    .modal-dialog-centered {
        top: 20%;
    }
</style>
@endsection
@section('content')
    <div class="wrapper">
        <div id="loading" class="theloading" style="display: none;">
            <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
        </div>
        <div class="header">
            <h2> Chi tiết phiếu điều chuyển
                <br>
                <small class="table-of-contents">
                <a class="redirect" style="text-decoration: none;" href="{{route('viewcpanel::warehouse.pgdIndex')}}"><i class="fa fa-home"></i>Home</a> /
                <a class="redirect" style="text-decoration: none;" href='{{$detailTransfer.$detail["_id"]}}'>Chi tiết phiếu điều chuyển</a>
                </small>
            </h2>

            <div class="header-btn">
                <a href="{{route('viewcpanel::warehouse.pgdIndex')}}" class="btn-gray redirect">Trở về <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                @if($importCreate && (in_array($user['email'], $mkt) || $isAdmin))
                <button type="button" class="" id="btn_create" style="background-color:#1D9752" data-bs-toggle="modal" data-bs-target="#createModal">Tạo phiếu<i class="fa fa-plus"
                        aria-hidden="true"></i></button>
                @endif
                @if($importButton && (!in_array($user['email'], $mkt) || $isAdmin))
                <button type="button" class="" id="btn_import" data-bs-toggle="modal" data-bs-target="#export_accept">Xác nhận nhận <i class="fa fa-check"
                        aria-hidden="true"></i></button>
                @endif
                @if($exportButton && (!in_array($user['email'], $mkt) || $isAdmin))
                <button type="button" class="" id="btn_export" data-bs-toggle="modal" data-bs-target="#export_accept">Xác nhận xuất <i class="fa fa-check"
                        aria-hidden="true"></i></button>
                @endif
            </div>
        </div>
        <div class="style-container">
            <h3>Thông tin chung</h3>
            <div class="style-col-ip">
                <div class="row">
                    
                    <div class="col-md-4">
                        <div class="form-ip">
                            <p>Người tạo</p>
                            <input type="text" style="background: #E6E6E6;" value="{{$detail['created_by']}}"
                                disabled />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-ip">
                            <p>Ngày tạo</p>
                            <input type="text" style="background: #E6E6E6;" value="{{!empty($detail['created_at']) ? date('Y-m-d H:i:s',$detail['created_at']) : ''}}" disabled />
                        </div>
                    </div>
                
                    <div class="col-md-4">
                        <div class="form-ip">
                            <p>Ngày yêu cầu</p>
                            <input type="text" style="background: #E6E6E6;" value="{{!empty($detail['requested_at']) ? date('Y-m-d H:i:s', $detail['requested_at']) : ''}}" disabled />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-ip">
                            <p>Phòng giao dịch xuất</p>
                            <input type="text" style="background: #E6E6E6;" value="{{$detail['stores_export']['name']}}" disabled />
                        </div>
                    </div>
                   
                    <div class="col-md-4">
                        <div class="form-ip">
                            <p>Ngày xuất</p>
                            <input type="text" style="background: #E6E6E6;" value="{{!empty($detail['date_export']) ? date('Y-m-d H:i:s', $detail['date_export']) : ''}}" disabled />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-ip">
                            <p>Chứng từ xuất</p>
                            @if ( $detail['license_export'] && count($detail['license_export']) > 0)
                            <a data-bs-toggle="modal"
                            data-bs-target="#modalLisenceExport"
                            style="height:40px;border:1px solid #D8D8D8; background-color:#E6E6E6; text-align: left; color: #676767;"
                            href="" class="text-success btn btn lisence_export">Xem chứng từ</a>
                            @else
                            <a data-bs-toggle=""
                            data-bs-target=""
                            style="height:40px;border:1px solid #D8D8D8; background-color:#E6E6E6; text-align: left; color: #676767;"
                            href="" class="btn btn">Chưa có chứng từ</a>
                            @endif
                        </div>
                    </div>
              
                    <div class="col-md-4">
                        <div class="form-ip">
                            <p>Phòng giao dịch nhận</p>
                            <input type="text" style="background: #E6E6E6;" value="{{$detail['stores_import']['name']}}" disabled />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-ip">
                            <p>Ngày nhận</p>
                            <input type="text" style="background: #E6E6E6;" value="{{!empty($detail['date_import']) ? date('Y-m-d H:i:s', $detail['date_import']) : ''}}" disabled />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-ip">
                            <p>Chứng từ nhận</p>
                            @if ($detail['license_import'] && count($detail['license_import']) > 0)
                            <a data-bs-toggle="modal"
                            data-bs-target="#modalLisenceImport"
                            style="height:40px; border:1px solid #D8D8D8; background-color:#E6E6E6; text-align: left; color: #676767 !important;"
                            href="" class="text-success btn btn lisence_import">Xem chứng từ</a>
                            @else
                            <a data-bs-toggle=""
                            data-bs-target=""
                            style="height:40px;border:1px solid #D8D8D8; background-color:#E6E6E6; text-align: left;"
                            href="" class="btn btn">Chưa có chứng từ</a>
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-ip">
                            <p>Tổng số loại ấn phẩm</p>
                            <input type="text" style="background: #E6E6E6;" value="{{count($detail['list'])}}" disabled />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-ip">
                            <p>Tổng số lượng ấn phẩm</p>
                            @php
                                $arr = [];
                                foreach ($detail['list'] as $i) {
                                    $arr[] = $i['amount'];
                                }
                            @endphp
                            <input type="text" style="background: #E6E6E6;" value="{{array_sum($arr)}}" disabled />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-ip">
                            <p>Trạng thái</p>
                            @foreach ($status as $k => $i)
                                @if ($k == $detail['status'])
                                    <input type="text" style="background: #E6E6E6; color:#1D9752; font-size: 16px; font-weight: bold" value="{{$i}}" disabled />
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="list-publications">
            <p>Danh sách ấn phẩm được phê duyệt</p>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Mã ấn phẩm</th>
                            <th scope="col">Tên ấn phẩm</th>
                            <th scope="col">Loại ấn phẩm</th>
                            <th scope="col">Quy cách</th>
                            <th scope="col">Ảnh mô tả</th>
                            <th scope="col">Số lượng ấn phẩm</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detail['list'] as $key => $item)
                        <tr>
                            <td style="padding-top: 20px;">{{++$key}}</td>
                            <td style="padding-top: 20px;">{{$item['code_item']}}</td>
                            <td style="padding-top: 20px;">{{$item['name']}}</td>
                            <td style="padding-top: 20px;">{{$item['type']}}</td>
                            <td style="padding-top: 20px;">{{$item['specification']}}</td>
                            <td>
                                <a href="#"
                                data-path={{json_encode($item['path'])}}
                                style="height:40px;" class="text-success btn btn image">Ảnh mô tả</a>
                            </td>
                            <td style="padding-top: 20px;">{{$item['amount']}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="footer">
                @if(!empty($paginate))
                    <nav aria-label="Page navigation" style="margin-top: 20px;">
                    {{ $paginate->withQueryString()->render('viewcpanel::trade.paginate') }}
                    </nav>
                @endif
            </div>
        </div>

         <div class="reason-cancel">
                <label for="">Lý do huỷ</label>
                <div class="reason">
                    <textarea class="form-control" readonly placeholder="">{{!empty($detail['reason_cancel']) ? $detail['reason_cancel'] : ""}}</textarea>
                </div>
            </div>
    </div>
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Chứng từ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body img">
                @if (count($item['path']) > 0)
                    <img style="width:100%;" src="{{$item['path'][0]}}" alt="" class="underline cursor-pointer" data-fancybox-trigger="gallery-c-{{$item['data_id']}}">
                    <div style="display:none">
                        @foreach($item['path'] as $k => $i)
                            <a data-fancybox="gallery-c-{{$item['data_id']}}" href="{{$i}}"><img class="rounded" src="{{$i}}"></a>
                        @endforeach
                    </div>
                    <h5 data-fancybox-trigger="gallery-c-{{$item['data_id']}}" class="underline cursor-pointer xt countImg">+{{count($item['path'])}}</h5>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalLisenceExport" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="text-align:center;" id="staticBackdropLabel">Chứng từ xuất</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body export">
                    <div class="row">
                        <div class="col-sm-6 col-md-6" style="text-align: center;">
                            <h6>Văn bản</h6>
                            <div id="documentPath">
                                @if(count($documentExport) > 0)
                                    @foreach ($documentExport as $item)
                                        <a style="max-width:100%;" href="{{$item['path']}}">{{substr($item['file_name'], 0, 25) . '...'}}</a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6" style="text-align: center;">
                            <h6>Hình ảnh</h6>
                            <div id="imgPath">
                                @if (count($imgExport) > 0)
                                    <img style="width: 100%; height: 200px;" src="{{$imgExport[0]['path']}}" alt=""
                                         class="underline cursor-pointer background" data-fancybox-trigger="gallery">
                                    <div style="display:none" class="imgP">
                                        @foreach($imgExport as $i)
                                            <a data-fancybox="gallery" href="{{$i['path']}}"><img class="rounded"
                                                                                                  src="{{$i['path']}}"></a>
                                        @endforeach
                                    </div>
                                    <h5 data-fancybox-trigger="gallery" class="underline cursor-pointer xt countImg">
                                        +{{count($imgExport)}}</h5>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalLisenceImport" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Chứng từ nhận</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body import">

                <!-- <h5 data-fancybox-trigger="gallery-e" class="underline cursor-pointer xt countImg"></h5> -->
                <div class="modal-body export">
                <div class="row">
                    <div class="col-sm-6 col-md-6" style="text-align: center;">
                        <h6>Văn bản</h6>
                        <div id="documentPath">
                            @if(count($documentImport) > 0)
                                @foreach ($documentImport as $item)
                                    <a style="max-width:100%;" href="{{$item['path']}}">{{$item['file_name']}}</a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6" style="text-align: center;">
                        <h6>Hình ảnh</h6>
                        <div id="imgPath">
                            @if (count($imgImport) > 0)
                            <img style="width: 100%; height: 200px;" src="{{$imgImport[0]['path']}}" alt="" class="underline cursor-pointer background" data-fancybox-trigger="gallery-e">
                            <div style="display:none" class="imgP">
                                @foreach($imgImport as $i)
                                    <a data-fancybox="gallery-e" href="{{$i['path']}}"><img class="rounded" src="{{$i['path']}}"></a>
                                @endforeach
                            </div>
                            <h5 data-fancybox-trigger="gallery-e" class="underline cursor-pointer xt countImg">+{{count($imgImport)}}</h5>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal xác nhận xuất -->
    <div class="modal fade" id="export_accept" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: -800px">
        @if ($detail['status'] == 2)
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 style="text-align: center">Xác nhận xuất</h5>
                    <div class="col-accept">
                        <div class="col-md-12">
                            @foreach($detail['list'] as $i)
                            <div class="form-ip">
                                <p>{{$i['name']}}</p>
                                <span>{{$i['type']}}</span>
                                <span>{{$i['specification']}}</span>
                                <input type="text" style="background: #E6E6E6;" placeholder="1,000"
                                    disabled value="{{$i['amount']}}" >
                            </div>
                            @endforeach
                            <div class="form-ip">
                                <p>Chứng từ <label for="" class="star">*</label></p>
                                <div class="img-area">
                                    <div id="imgInput"></div>
                                    <span type="button" style="height:30px; color:#B8B8B8; width:100%;" class="upload btn btn-default btn-lg" id="call-to-action"></span>
                                    <span class="file-button"><i style="position: absolute;right: 10px; padding-top:10px;"class="fa fa-upload upload" aria-hidden="true"></i></span>
                                    <div id="drop">
                                        <input type="file" name="imgs" hidden multiple multiple class="upload-hidden">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn-modal">
                        <button data-id="{{$detail['_id']}}" id="confirm_export" type="button" class="btn-accept">Xác nhận</button>
                        <button type="button" class="btn-delete" data-bs-dismiss="modal">Huỷ</button>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if ($detail['status'] == 3)
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 style="text-align: center">Xác nhận nhập</h5>
                    <div class="col-accept">
                        <div class="col-md-12">
                            @foreach($detail['list'] as $i)
                            <div class="form-ip">
                                <p>{{$i['name']}}</p>
                                <span>{{$i['type']}}</span>
                                <span>{{$i['specification']}}</span>
                                <input type="text" style="background: #E6E6E6;" placeholder="1,000"
                                    disabled value="{{$i['amount']}}" >
                            </div>
                            @endforeach
                            <div class="form-ip">
                                <p>Chứng từ <label for="" class="star">*</label></p>
                                <div class="img-area">
                                    <div id="imgInput"></div>
                                    <span type="button" style="height:30px; color:#B8B8B8; width:100%;" class="upload btn btn-default btn-lg" id="call-to-action"></span>
                                    <span class="file-button"><i style="position: absolute;right: 10px; padding-top:10px;"class="fa fa-upload upload" aria-hidden="true"></i></span>
                                    <div id="drop">
                                        <input type="file" name="imgs" hidden multiple multiple class="upload-hidden">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn-modal">
                        <button data-id="{{$detail['_id']}}" id="confirm_import" type="button" class="btn-accept">Xác nhận</button>
                        <button type="button" class="btn-delete" data-bs-dismiss="modal">Huỷ</button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    <div class="modal fade" id="modalExport" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        @if ($detail['status'] == 2)
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="title">
                <h5>Xác nhận</h5>
                <p>Bạn có chắc chắn xác nhận xuất danh sách ấn phẩm này?</p>
            </div>
            <div class="btn-footer">
                <button id="success_export" type="button" class="btn-accept">Đồng ý</button>
                <button type="button" class="btn-delete" data-bs-dismiss="modal">Huỷ</button>
            </div>
        </div>
        @endif
        @if($detail['status'] == 3)
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="title">
                <h5>Xác nhận</h5>
                <p>Bạn có chắc chắn xác nhận nhận danh sách ấn phẩm này?</p>
            </div>
            <div class="btn-footer">
                <button id="success_import" type="button" class="btn-accept">Đồng ý</button>
                <button type="button" class="btn-delete" data-bs-dismiss="modal">Huỷ</button>
            </div>
        </div>
        @endif
    </div>

    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 style="text-align: center">Tạo phiếu</h5>
                    <p style="text-align: center">Bạn có chắc chắn tạo phiếu điều chuyển danh sách ấn phẩm này?
                    </p>
                    <div class="btn-modal">
                        <button data-id="{{$detail['_id']}}" type="button" id="confirm_create" class="btn-accept">Đồng ý</button>
                        <button type="button" class="btn-delete" data-bs-dismiss="modal">Huỷ</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
        $(".image").click(function() {
            $("#modalLisence").modal('show');
        });
        $(".lisence_export").click(function() {
            $("#modalLisenceExport").modal('show');
        });
        $(".lisence_import").click(function() {
            $("#modalLisenceImport").modal('show');
        });
        $(".export").click(function() {
            $("#modalLisenceExport").modal('hide');
        });
        $(".import").click(function() {
            $("#modalLisenceImport").modal('hide');
        });
        $("#btn_export").click(function() {
            $("#export_accept").modal('show');
        });
        $("#btn_import").click(function() {
            $("#import_accept").modal('show');
        });
        $("#btn_create").click(function() {
            $("#createModal").modal('show');
        });
        $("#confirm_export").click(function() {
            let inputLicense = $('.img-area');
            let value_inputLicense = $('.img-area > .block > input[name="url[]"]');
            if (value_inputLicense.val() == '' || value_inputLicense.val() == undefined) {
                inputLicense.css('border','1px solid red');
                inputLicense.after('<span class="invalid" style="color:red; font-size: 13px; font-weight: 40px;">Chứng từ xuất không được để trống</span>');
            } else {
                $("#modalExport").modal('show');
                $("#export_accept").modal('hide');
            }
        });
        $("#confirm_import").click(function() {
            let inputLicense = $('.img-area');
            let value_inputLicense = $('.img-area > .block > input[name="url[]"]');
            if (value_inputLicense.val() == '' || value_inputLicense.val() == undefined) {
                inputLicense.css('border','1px solid red');
                inputLicense.after('<span class="invalid" style="color:red; font-size: 13px; font-weight: 40px;">Chứng từ nhận không được để trống</span>');
            } else {
                $("#modalExport").modal('show');
                $("#export_accept").modal('hide');
            }
        });


    });
</script>
<script>
    $(document).ready(function() {
        const csrf = "{{ csrf_token() }}";
        $('.upload-hidden').on('change', function () {
            var files = $(this)[0].files;
            for (let i = 0; i < files.length; i++) {
                let file = files[i];
                uploadImgs(file);
            }
        });

        const uploadImgs = async function (file) {
        var formData = new FormData();
        formData.append('file', file);
        formData.append('_token', csrf);
        var mine = ['application/vnd.ms-excel', 'application/msexcel', 'application/x-msexcel',
        'application/x-ms-excel', 'application/x-excel', 'application/x-dos_ms_excel',
        'application/xls', 'application/x-xls', 'application/excel', 'application/download',
        'application/vnd.ms-office', 'application/msword','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/zip', 'application/vnd.ms-excel', 'application/msword', 'application/x-zip',
        'image/jpeg', 'image/png', 'image/jpg', 'application/octet-stream',
        'application/vnd.ms-office','application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip',
        'application/msword', 'application/x-zip', 'application/pdf', 'application/force-download', 'application/x-download', 'binary/octet-stream'];
        if(mine.includes(file.type)) {

        } else {
            Swal.fire({
                position: 'top',
              icon: 'error',
              title: 'Có lỗi xảy ra...',
              text: 'File upload sai định dạng!',
            })
          return;
        }

        await $.ajax({
            dataType: 'json',
            enctype: 'multipart/form-data',
            url: '{{route("viewcpanel::warehouse.uploadLisence")}}',
            type: 'POST',
            data: formData,
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            success: function (data) {
                if (data && data.code == 200) {
                  console.log(data)
                  if (file.type == 'image/jpeg' || file.type == 'image/png' || file.type == 'image/jpg') {
                    let block = `
                    <div class="block" style="width:150px; border:none;">
                        <a target="_blank" style="font-size:14px;text-decoration: none " href="` + data.path + `">` + data.raw_name + ` </a>
                        <input data-fileType ="` + file.type +`" data-fileName = "`+ data.raw_name + `" multiple type="hidden" name="url[]" id="url" value="` + data.path + `">
                        <button type="button" onclick="deleteImage(this)" class="cancelButton">
                          <i class="fa fa-times-circle"></i>
                        </button>
                    </div>
                      `;
                    $('#imgInput').before(block);
                  } else {
                    let block = `
                    <div class="block" style="width:auto; border:none;">
                        <a style="font-size:13px; "href="` + data.path + `">` +data.raw_name+` </a>
                        <input data-fileType ="` + file.type +`" data-fileName = "`+ data.raw_name + `" multiple type="hidden" name="url[]" id="url" value="` + data.path + `">
                        <button type="button" onclick="deleteImage(this)" class="cancelButton">
                          <i class="fa fa-times-circle"></i>
                        </button>
                    </div>
                      `;
                    $('#imgInput').before(block);
                  }
                if (typeof(data) == "string") {
                  $("#errorModal").find(".msg_error").text(data);
                  $("#errorModal").modal('show');
                }
            }
          }
        });
      }


        $('#call-to-action, .upload').click(function () {
            $('.upload-hidden').click();
        });
    })
    const closeModal = function(el) {
        console.log("close");
        $(el).closest('.modal').hide();
    }

    function deleteImage(el) {
        if (confirm("Bạn có chắc chắn muốn xóa ?")){
        $(el).closest(".block").remove();
        $('#imgInput').find('[type="file"]').first().val('');
        }
    }
</script>
<script type="text/javascript">
    const csrf = "{{ csrf_token() }}";
    $(document).ready(function() {
        $('#success_export').on('click', function() {
            $('#modalExport').modal('hide');
            var form = new FormData();
            let id = $('#confirm_export').attr('data-id');
            let image = [];
            $("input[name='url[]']").each(function (key, value) {
                let data = {};
                let url = $(this).val();
                let name = $(this).attr('data-fileName');
                let file_type = $(this).attr('data-fileType');
                data['path'] = url;
                data['file_name'] = name;
                data['file_type'] = file_type;
                image.push(data);
            });
            form.append('url', JSON.stringify(image));
            form.append('_token', csrf);
            form.append('id', id);
            $.ajax({
                dataType: 'json',
                enctype: 'multipart/form-data',
                url: '{{route("viewcpanel::transfer.confirmExport")}}',
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                success: function (data) {
                    console.log(data.data)
                    $('#modalExport').modal('hide');
                    Swal.fire({
                        position: 'top',
                        icon: 'success',
                        title: 'Xuất thành công',
                        showConfirmButton: false,
                        timer: 2500
                    });
                    setTimeout(function () {
                        location.reload()}, 2500);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $("#errorModal").find(".msg_error").text("Có lỗi xảy ra, vui lòng thử lại sau!");
                    $("#errorModal").modal('show');
                }
            })
        })
        $('#success_import').on('click', function() {
            $('#modalExport').modal('hide');
            var form = new FormData();
            let id = $('#confirm_import').attr('data-id');
            let image = [];
            $("input[name='url[]']").each(function (key, value) {
                let data = {};
                let url = $(this).val();
                let name = $(this).attr('data-fileName');
                let file_type = $(this).attr('data-fileType');
                data['path'] = url;
                data['file_name'] = name;
                data['file_type'] = file_type;
                image.push(data);
            });
            form.append('url', JSON.stringify(image));
            form.append('_token', csrf);
            form.append('id', id);
            $.ajax({
                dataType: 'json',
                enctype: 'multipart/form-data',
                url: '{{route("viewcpanel::transfer.confirmImport")}}',
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                success: function (data) {
                    console.log(data.data)
                    $('#modalExport').modal('hide');
                    Swal.fire({
                        position: 'top',
                        icon: 'success',
                        title: 'Nhập thành công',
                        showConfirmButton: false,
                        timer: 2500
                    });
                    setTimeout(function () {
                        location.reload()}, 2500);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $("#errorModal").find(".msg_error").text("Có lỗi xảy ra, vui lòng thử lại sau!");
                    $("#errorModal").modal('show');
                }
            })
        })

        $("#confirm_create").on('click', function() {
            $('#createModal').modal('hide');
            var form = new FormData();
            let id = $('#confirm_create').attr('data-id');
            form.append('_token', csrf);
            form.append('id', id);
            $.ajax({
                dataType: 'json',
                enctype: 'multipart/form-data',
                url: '{{route("viewcpanel::transfer.confirmCreate")}}',
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                success: function (data) {
                    console.log(data.data)
                    $('#createModal').modal('hide');
                    Swal.fire({
                        position: 'top',
                        icon: 'success',
                        title: 'Tạo phiếu điểu chuyển thành công',
                        showConfirmButton: false,
                        timer: 2500
                    });
                    setTimeout(function () {
                        location.reload()}, 2500);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $("#errorModal").find(".msg_error").text("Có lỗi xảy ra, vui lòng thử lại sau!");
                    $("#errorModal").modal('show');
                }
            })
        });
    });
</script>
<script>
    $(document).ready(function() {
        $(".image").on('click', function(e) {
            $("#staticBackdrop").find('.img').html('');
            e.preventDefault();
            let _el = $(e.target);
            let itemPath = JSON.parse($(_el).attr('data-path'));
            if (itemPath.length > 0) {
                let html = '<img style="width: 100%; height: 200px;" src="'+itemPath[0]+'" alt="" class="underline cursor-pointer" data-fancybox-trigger="gallery-modal">';
                html += '<div style="display:none">';
                for(let i = 0; i < itemPath.length; i++) {
                    html += '<a data-fancybox="gallery-modal" href="'+itemPath[i]+'"><img class="rounded" src="'+itemPath[i]+'"></a>';
                }
                    html += '</div>';
                    html += '<h5 style="position: absolute; top: 50%; left: 45%; color:white;" data-fancybox-trigger="gallery-modal" class="underline cursor-pointer xt">+'+itemPath.length+'</h5>';
                $("#staticBackdrop").find('.img').html(html);
            } else {
                $("#staticBackdrop").find('.img').html('<span>Không có ảnh</span>');
            }

            $("#staticBackdrop").modal('show');
        })
        $(".img").click(function() {
            $("#staticBackdrop").modal('hide');
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
</script>

<script type="text/javascript">
    const iframeMode = "<?= (!empty($_GET['iframe']) && $_GET['iframe'] == 1) ?>";
    console.log(iframeMode)
    const Redirect = (_url, _timeout) => {
        if (parseInt(iframeMode) != 1) {
            if (!_timeout) {
                window.location.href = _url;
                // window.parent.postMessage({targetLink: _url}, "{{$cpanelPath}}");
            } else {
                setTimeout(function(){window.location.href = _url}, _timeout);
                // setTimeout(function () {window.parent.postMessage({targetLink: _url}, "{{$cpanelPath}}");}, _timeout);
            }
        } else {
            _url = _url.replace(window.location.origin + '/', "");
            if (!_timeout) {
                // window.location.href = _url;
                window.parent.postMessage({targetLink: _url}, "{{$cpanelPath}}");
            } else {
                // setTimeout(function(){window.location.href = _url}, _timeout);
                setTimeout(function () {window.parent.postMessage({targetLink: _url}, "{{$cpanelPath}}");}, _timeout);
            }
        }
    }
</script>
@endsection
