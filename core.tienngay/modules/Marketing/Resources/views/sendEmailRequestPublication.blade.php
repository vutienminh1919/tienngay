<!doctype html>
<html>

<head>
    <meta name='viewport' content='width=device-width'>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
    <title>Thông báo yêu cầu ấn phẩm</title>
    <style>
    @media only screen and (max-width: 620px) {
        table[class=body] h1 {
            font-size: 28px !important;
            margin-bottom: 10px !important
        }

        table[class=body] p,
        table[class=body] ul,
        table[class=body] ol,
        table[class=body] td,
        table[class=body] span,
        table[class=body] a {
            font-size: 16px !important
        }

        table[class=body] .wrapper,
        table[class=body] .article {
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

        table[class=body] .img-responsive {
            height: auto !important;
            max-width: 100% !important;
            width: auto !important
        }
    }

    @media all {
        .ExternalClass {
            width: 100%
        }

        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
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
    }
    </style>
</head>

<body class=''
    style='background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;'>
    <table border='0' cellpadding='0' cellspacing='0' class='body'
        style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;'>
        <tr>
            <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;'>&nbsp;</td>
            <td class='container'
                style='font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;'>
                <div class='content'
                    style='box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;'>
                    <span class='preheader'
                        style='color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;'></span>
                    <table class='main'
                        style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;'>
                        <tr>
                            <td class='wrapper'
                                style='font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;'>
                                <table border='0' cellpadding='0' cellspacing='0'
                                    style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;'>
                                    <tr>
                                        <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;'>
                                            <p style='text-align:center'> <img
                                                    src='https://tienngay.vn/assets/home/images/logo.png' alt=''></p>
                                            <h2 style=''>Thông Báo Yêu Cầu Mua Sắm Ấn Phẩm</h2>
                                            <strong>Kính gửi: Anh/Chị,</strong>
                                            @if ($flag == 1)
                                            <p>Phòng HCNS xin thông báo</p>
                                            <p>Những ấn phẩm sau đã được phòng HCNS đặt hàng, chi tiết như sau:</p>
                                            <table style='width:100%;' style="border: 1px solid #cccccc">
                                                <thead>
                                                    <tr>
                                                        <th scope='col' style="border: 1px solid #cccccc">Mã ấn phẩm</th>
                                                        <th scope='col' style="border: 1px solid #cccccc">Tên ấn phẩm</th>
                                                        <th scope='col' style="border: 1px solid #cccccc">Quy cách</th>
                                                        <th scope='col' style="border: 1px solid #cccccc">Số lượng</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($publication)
                                                        @foreach($publication as $key => $item)
                                                            <tr>
                                                                <td style='padding:5px;border:1px solid #cccccc'>{{$item['item_id']}}</td>
                                                                <td style='padding:5px;border:1px solid #cccccc;text-align: center'>{{$item['name_publications']}}</td>
                                                                <td style='padding:5px;border:1px solid #cccccc;text-align: center'>{{$item['specification']}}</td>
                                                                <td style='padding:5px;border:1px solid #cccccc;text-align: center'>{{$item['total_clone']}}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                            <p>Xem chi tiết <a href='{{$url}}'>tại đây</a></p>
                                            @endif
                                            @if ($flag == 2)
                                            <p>Hệ thống xin thông báo đến anh chị những ấn phẩm đã đến ngày nghiệm thu như sau:</p>
                                                @if ($publication)
                                                @foreach($publication as $key => $value)
                                                    <p>{{++$key}}. Phiếu mua sắm ấn phẩm của nhà cung cấp "{{$value['supplier']}}"</p>
                                                    <table style='width:100%;' style="border: 1px solid #cccccc">
                                                        <thead>
                                                            <tr>
                                                                <th scope='col' style="border: 1px solid #cccccc">Mã ấn phẩm</th>
                                                                <th scope='col' style="border: 1px solid #cccccc">Tên ấn phẩm</th>
                                                                <th scope='col' style="border: 1px solid #cccccc">Quy cách</th>
                                                                <th scope='col' style="border: 1px solid #cccccc">Số lượng</th>
                                                            </tr>
                                                        </thead>
                                                        @foreach ($value['lead_publications'] as $item)
                                                        <tbody>
                                                                <tr>
                                                                    <td style='padding:5px;border:1px solid #cccccc'>{{$item['item_id']}}</td>
                                                                    <td style='padding:5px;border:1px solid #cccccc;text-align: center'>{{$item['name_publications']}}</td>
                                                                    <td style='padding:5px;border:1px solid #cccccc;text-align: center'>{{$item['specification']}}</td>
                                                                    <td style='padding:5px;border:1px solid #cccccc;text-align: center'>{{$item['total_clone']}}</td>
                                                                </tr>
                                                        </tbody>
                                                        @endforeach
                                                    </table>
                                                    <p>Xem chi tiết <a href="{{$url.$value['_id']}}">tại đây</a></p>
                                                @endforeach
                                                @endif
                                            @endif
                                            @if ($flag == 3) 
                                                <p>Phòng HCNS xin thông báo</p>
                                                <p>Những ấn phẩm sau đã được phòng HCNS chỉnh sửa lại sau khi đặt hàng, chi tiết như sau:</p>
                                                <table style='width:100%;' style="border: 1px solid #cccccc">
                                                    <thead>
                                                        <tr>
                                                            <th scope='col' style="border: 1px solid #cccccc">Mã ấn phẩm</th>
                                                            <th scope='col' style="border: 1px solid #cccccc">Tên ấn phẩm</th>
                                                            <th scope='col' style="border: 1px solid #cccccc">Quy cách</th>
                                                            <th scope='col' style="border: 1px solid #cccccc">Số lượng</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($publication)
                                                            @foreach($publication as $key => $item)
                                                                <tr>
                                                                    <td style='padding:5px;border:1px solid #cccccc'>{{$item['item_id']}}</td>
                                                                    <td style='padding:5px;border:1px solid #cccccc;text-align: center'>{{$item['name_publications']}}</td>
                                                                    <td style='padding:5px;border:1px solid #cccccc;text-align: center'>{{$item['specification']}}</td>
                                                                    <td style='padding:5px;border:1px solid #cccccc;text-align: center'>{{$item['total_clone']}}</td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                                <p>Xem chi tiết <a href='{{$url}}'>tại đây</a></p>
                                            @endif
                                            @if ($flag == 4)
                                                <p>Bộ phận Trade Marketing xin thông báo</p>
                                                <p>Những ấn phẩm sau đã được BP Marketing nghiệm thu, chi tiết như sau:</p>
                                                <table style='width:100%;' style="border: 1px solid #cccccc">
                                                    <thead>
                                                        <tr>
                                                            <th scope='col' style="border: 1px solid #cccccc">Mã ấn phẩm</th>
                                                            <th scope='col' style="border: 1px solid #cccccc">Tên ấn phẩm</th>
                                                            <th scope='col' style="border: 1px solid #cccccc">Quy cách</th>
                                                            <th scope='col' style="border: 1px solid #cccccc">Tổng số lượng đã nghiệm thu</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($publication)
                                                            @foreach($publication as $key => $item)
                                                                <tr>
                                                                    <td style='padding:5px;border:1px solid #cccccc'>{{$item['item_id']}}</td>
                                                                    <td style='padding:5px;border:1px solid #cccccc;text-align: center'>{{$item['name_publications']}}</td>
                                                                    <td style='padding:5px;border:1px solid #cccccc;text-align: center'>{{$item['specification']}}</td>
                                                                    <td style='padding:5px;border:1px solid #cccccc;text-align: center'>{{$item['total_acceptance']}}</td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                                <p>Xem chi tiết <a href='{{$url}}'>tại đây</a></p>
                                            @endif
                                            @if ($flag == 5)
                                                <p>Bộ phận Trade Marketing xin thông báo</p>
                                                <p>Những ấn phẩm sau đã được phân bổ, chi tiết như sau:</p>
                                                <table style='width:100%;' style="border: 1px solid #cccccc">
                                                    <thead>
                                                        <tr>
                                                            <th scope='col' style="border: 1px solid #cccccc">Mã ấn phẩm</th>
                                                            <th scope='col' style="border: 1px solid #cccccc">Tên ấn phẩm</th>
                                                            <th scope='col' style="border: 1px solid #cccccc">Quy cách</th>
                                                            <th scope='col' style="border: 1px solid #cccccc">Số lượng phân bổ</th>
                                                            <th scope='col' style="border: 1px solid #cccccc">Phòng giao dịch</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($publication)
                                                            @foreach($publication as $key => $item)
                                                                <tr>
                                                                    <td style='padding:5px;border:1px solid #cccccc'>{{$item['code_item']}}</td>
                                                                    <td style='padding:5px;border:1px solid #cccccc;text-align: center'>{{$item['name_item']}}</td>
                                                                    <td style='padding:5px;border:1px solid #cccccc;text-align: center'>{{$item['specification']}}</td>
                                                                    <td style='padding:5px;border:1px solid #cccccc;text-align: center'>{{$item['total_allotment']}}</td>
                                                                    <td style='padding:5px;border:1px solid #cccccc;text-align: center'>{{$item['store_name']}}</td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                                <p>Xem chi tiết <a href='{{$url}}'>tại đây</a></p>
                                            @endif
                                            @if ($flag == 6) 
                                                <p>Phòng giao dịch&nbsp;{{$publication['store_name']}}&nbsp;xin thông tin đến anh/chị ấn phẩm đã được nhập vào kho của Phòng giao dịch</p>
                                                <p>Xem chi tiết <a href='{{$url}}'>tại đây</a></p>
                                            @endif
                                            <p>Trân trọng !</p>
                                            <p> <i>* Đây là email hệ thống tạo tự động, đề nghị không trả lời lại email
                                                    này.</i></p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <div class='footer' style='clear: both; Margin-top: 10px; text-align: center; width: 100%;'>
                        <table border='0' cellpadding='0' cellspacing='0'
                            style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;'>
                            <tr>
                                <td class='content-block powered-by'
                                    style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;'>
                                    Thông báo từ hệ thống tienngay.vn</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </td>
            <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;'>&nbsp;</td>
        </tr>
    </table>
</body>

</html>