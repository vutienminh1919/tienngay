<!doctype html>
<html>
<head>
    <meta name='viewport' content='width=device-width'>
    <meta http - equiv='Content-Type' content='text/html; charset=UTF-8'>
    <title>Phiếu Ghi nhận kỳ thanh toán tới hạn </title>
    <style>@media only screen and (max-width: 620px ) {
            table[class=body] h1 {
                font-size: 28px !important;
                margin-bottom: 10px !important
            }

            table[class=body] p, table[class=body] ul, table[class=body] ol, table[class=body] td, table[class=body] span, table[class=body] a {
                font-size: 16px !important
            }

            table[class=body] .wrapper, table[class=body] .article {
                padding: 10px !important
            }

            table[class=body] .content {
                padding: 0 !important
            }

            table[class=body] .container {
                padding: 0 !important;
                width: 100% !important
            }

            table[class=body] .main {
                border-left-width: 0 !important;
                border-radius: 0 !important;
                border-right-width: 0 !important
            }

            table[class=body] .btn table {
                width: 100% !important
            }

            table[class=body] .btn a {
                width: 100% !important
            }

            table[class=body].img-responsive {
                height: auto !important;
                max-width: 100% !important;
                width: auto !important
            }
        }

        @media all {
            . ExternalClass {
                width: 100%
            }

            .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {
                line-height: 100%
            }

            .apple-link a {
                color: inherit !important;
                font-family: inherit !important;
                font-size: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
                text-decoration: none !important
            }

            #MessageViewBody a {
                color: inherit;
                text-decoration: none;
                font-size: inherit;
                font-family: inherit;
                font-weight: inherit;
                line-height: inherit
            }

            .btn-primary table td:hover {
                background-color: #34495e !important
            }

            .btn-primary a:hover {
                background-color: #34495e !important;
                border-color: #34495e !important
            }
        }</style>
</head>
<body class=''
      style='background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;'>
<table border='0' cellpadding='0' cellspacing='0' class='body'
       style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;'>
    <tbody>
    <tr>
        <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;'>&nbsp;</td>
        <td class='container'
            style='font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto; max-width: 780px; padding: 10px;'>
            <div class='content'
                 style='box-sizing: border-box; display: block; Margin: 0 auto; max-width: 980px; padding: 10px;'><span
                    class='preheader'
                    style='color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;'></span>
                <table class='main'
                       style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;'>
                    <tbody>
                    <tr>
                        <td class='wrapper'
                            style='font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;'>
                            <table border='0' cellpadding='0' cellspacing='0'
                                   style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;'>
                                <tbody>
                                <tr>
                                    <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;'><p
                                            style='text-align:center'><img
                                                src='https://tienngay.vn/assets/home/images/logo.png' alt=''></p>
                                        <strong>Kính gửi: <span> @if($user_email=='ducta@tienngay.vn') CFO Nguyễn Ngọc
                                                Bích @else Khối Tài Chính - Kế Toán @endif </span></strong>
                                        <p>Hiện tại đang có các hợp đồng thuê mặt bằng tới hạn cần thanh toán</p>
                                        <p>Chi tiết như sau:</p>
                                        <table style='width:100%;' style="border: 1px solid #cccccc">
                                            <thead>
                                            <tr>
                                                <th scope='col' style="border: 1px solid #cccccc">STT</th>
                                                <th scope='col' style="border: 1px solid #cccccc">Mã hợp đồng</th>
                                                <th scope='col' style="border: 1px solid #cccccc">Tổng tiền trả</th>
                                                <th scope='col' style="border: 1px solid #cccccc">Ngày thanh toán</th>
                                                <th scope='col' style="border: 1px solid #cccccc">Trạng thái thanh toán</th>
                                                <th scope='col' style="border: 1px solid #cccccc">Thuế GTGT +thuế TNCN</th>
                                                <th scope='col' style="border: 1px solid #cccccc">Trạng thái nộp thuế</th>
                                            </tr>
                                            </thead>
                                            <tbody> @foreach ($data as $key=> $item)
                                                <tr>
                                                    <td style='padding:5px;border:1px solid #cccccc'>{{++$key}}</td>
                                                    <td style='padding:5px;border:1px solid #cccccc'>{{$item['code_contract']}}</td>
                                                    <td style='padding:5px;border:1px solid #cccccc;text-align: center'>{{number_format($item['one_month_rent'])}}</td>
                                                    <td style='padding:5px;border:1px solid #cccccc;text-align: center'>{{$item['ngay_thanh_toan']}}</td>
                                                        @if($item['status'] == 'chua_thanh_toan')
                                                            <td style='padding:5px;border:1px solid #cccccc;text-align: center'>Chưa thanh toán</td>
                                                        @elseif($item['status'] == 'da_thanh_toan')
                                                            <td style='padding:5px;border:1px solid #cccccc;text-align: center'>Đã thanh toán</td>
                                                        @endif
                                                    <td style='padding:5px;border:1px solid #cccccc;text-align: center'>{{number_format($item['tien_thue'])}}</td>
                                                        @if($item['status_thue'] == 'chua_thanh_toan')
                                                            <td style='padding:5px;border:1px solid #cccccc;text-align: center'>Chưa thanh toán</td>
                                                        @elseif($item['status_thue'] == 'da_thanh_toan')
                                                            <td style='padding:5px;border:1px solid #cccccc;text-align: center'>Đã thanh toán</td>
                                                        @endif
                                                    @endforeach
                                                </tr></tbody>
                                        </table>
                                        <br></td>
                                </tr>
                                </tbody>
                            </table>
                            <br>
                            <div class='footer'
                                 style='clear: both; Margin-top: 10px; text-align: center; width: 100%;font-size: 13px; text-align: left'>
                                <p>Trân trọng cảm ơn,</p><h5 style='font-weight: 600'>CÔNG TY CỔ PHẦN CÔNG NGHỆ TÀI
                                    CHÍNH VIỆT</h5>
                                <p><strong>Địa chỉ:</strong>Lô A12/D21 KĐT mới Cầu Giấy, Ngõ 100 Dịch Vọng Hậu, Cầu
                                    Giấy, Hà Nội</p>
                                <div style='border: 1px solid green; width: 100%;height: 2px;margin-bottom: 5px'></div>
                                <p>Đây là email được gửi tự động từ Kiểm Soát Nội Bộ của VFC. Vui lòng không gửi lại vào
                                    email này.</p></div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class='footer' style='clear: both; Margin-top: 10px; text-align: center; width: 100%;'>
                    <table border='0' cellpadding='0' cellspacing='0'
                           style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;'>
                        <tbody>
                        <tr>
                            <td class='content-block powered-by'
                                style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;'>
                                Thông báo từ Kiểm soát nội bộ VFC Tienngay.vn
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </td>
        <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;'>&nbsp;</td>
    </tr>
    </tbody>
</table>
</body>
</html>
