<?php

if (!function_exists('page_render')) {
    function page_render($items, $perPage, $total)
    {
        return new \Illuminate\Pagination\LengthAwarePaginator(
            $items, $total, $perPage,
            \Illuminate\Pagination\Paginator::resolveCurrentPage(),
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );
    }
}

if (!function_exists('menu_url')) {
    function menu_url($url)
    {
        if (str_starts_with($url, '/')) {
            return request()->root() . $url;
        }
        return request()->root() . '/' . $url;
    }
}

if (!function_exists('menu_active')) {
    function menu_active($url)
    {
        if (!str_starts_with($url, '/')) {
            $url = '/' . $url;
        }
        if (request()->getRequestUri() == $url) {
            return 'active';
        }
        return '';
    }
}

if (!function_exists('lead_status')) {
    function lead_status($status = null)
    {
        $result = '';
        $leadstatus = [
            1 => "Chờ gọi lại lần 1",
            2 => "Chờ gọi lại lần 2",
            3 => "Chờ gọi lại lần 3",
            4 => "Chờ gọi lại lần 4",
            5 => "Chờ gọi lại lần 5",
            6 => "Chờ gọi lại lần 6",
            7 => "Chờ gọi lại lần 7",
            8 => "Chờ gọi lại lần 8",
            9 => "Chờ gọi lại lần 9",
            10 => "Đang suy nghĩ",
            11 => "Kích hoạt thành công",
            12 => "Chờ bổ sung thông tin",
            13 => "Huỷ",
            14 => "Đồng ý tải APP",
        ];
        if ($status === null) return $leadstatus;
        foreach ($leadstatus as $key => $item) {
            if ($key == $status) {
                $result = $item;
            }
        }
        return $result;
    }
}
if (!function_exists('note_delete')) {
    function note_delete($status = null)
    {
        $result = '';
        $leadstatus = [
            1 => "Đã đầu tư bên khác",
            2 => "Không có nhu cầu nữa",
            3 => "Chưa tin tưởng/ tìm hiểu thêm",
            4 => "Chưa có tiền đầu tư",
            5 => "Nhu cầu vay tiền",
            6 => "Khác",
            7 => 'Không nghe máy nhiều lần',
            8 => 'Thuê bao',
            9 => 'Cuộc gọi thất bại',
            10 => 'Nhầm máy',
            11 => 'Sai số/ SĐT báo không đúng',
            12 => 'Từ chối trao đổi',
            13 => 'Trùng khách hàng',
            14 => 'Đang tham khảo',
        ];
        if ($status === null) return $leadstatus;
        foreach ($leadstatus as $key => $item) {
            if ($key == $status) {
                $result = $item;
            }
        }
        return $result;
    }
}

if (!function_exists('get_province_name_by_code')) {
    function get_province_name_by_code($code = null)
    {
        $result = '';
        $province = [
            "89" => "An Giang",
            "62" => "Kon Tum",
            "67" => "Đắk Nông",
            "94" => "Sóc Trăng",
            "70" => "Bình Phước",
            "33" => "Hưng Yên",
            "38" => "Thanh Hóa",
            "45" => "Quảng Trị",
            "08" => "Tuyên Quang",
            "51" => "Quảng Ngãi",
            "01" => "Hà Nội",
            "10" => "Lào Cai",
            "86" => "Vĩnh Long",
            "68" => "Lâm Đồng",
            "52" => "Bình Định",
            "40" => "Nghệ An",
            "91" => "Kiên Giang",
            "02" => "Hà Giang",
            "54" => "Phú Yên",
            "20" => "Lạng Sơn",
            "48" => "Đà Nẵng",
            "14" => "Sơn La",
            "72" => "Tây Ninh",
            "36" => "Nam Định",
            "12" => "Lai Châu",
            "83" => "Bến Tre",
            "56" => "Khánh Hòa",
            "60" => "Bình Thuận",
            "04" => "Cao Bằng",
            "31" => "Hải Phòng",
            "37" => "Ninh Bình",
            "15" => "Yên Bái",
            "64" => "Gia Lai",
            "17" => "Hoà Bình",
            "77" => "Bà Rịa - Vũng Tàu",
            "96" => "Cà Mau",
            "74" => "Bình Dương",
            "92" => "Cần Thơ",
            "46" => "Thừa Thiên Huế",
            "75" => "Đồng Nai",
            "82" => "Tiền Giang",
            "11" => "Điện Biên",
            "26" => "Vĩnh Phúc",
            "49" => "Quảng Nam",
            "66" => "Đắk Lắk",
            "19" => "Thái Nguyên",
            "30" => "Hải Dương",
            "95" => "Bạc Liêu",
            "84" => "Trà Vinh",
            "34" => "Thái Bình",
            "42" => "Hà Tĩnh",
            "58" => "Ninh Thuận",
            "87" => "Đồng Tháp",
            "80" => "Long An",
            "93" => "Hậu Giang",
            "22" => "Quảng Ninh",
            "25" => "Phú Thọ",
            "44" => "Quảng Bình",
            "79" => "Hồ Chí Minh",
            "35" => "Hà Nam",
            "27" => "Bắc Ninh",
            "24" => "Bắc Giang",
            "06" => "Bắc Kạn",
        ];
        if ($code === null) return $province;
        foreach ($province as $key => $item) {
            if ($key == $code) {
                $result = $item;
            }
        }
        return $result;
    }
}

function hide_phone($phone, $role = "")
{
    $result = str_replace(substr($phone, 4, 4), stars($phone), $phone);
    if ($role != "") {
        return $phone;
    } else {
        return $result;
    }
}

function stars($phone)
{
    $times = strlen(trim(substr($phone, 4, 4)));
    $star = '';
    for ($i = 0; $i < $times; $i++) {
        $star .= '*';
    }
    return $star;
}

function slugify($text)
{
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    // transliterate
    $text = vn_to_str($text);
    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
    // trim
    $text = trim($text, '-');
    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);
    // lowercase
    $text = strtolower($text);
    if (empty($text)) {
        return 'n-a';
    }
    return $text;
}

function vn_to_str($str)
{
    $unicode = array(
        'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
        'd' => 'đ',
        'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
        'i' => 'í|ì|ỉ|ĩ|ị',
        'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
        'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
        'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'D' => 'Đ',
        'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
        'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
    );
    foreach ($unicode as $nonUnicode => $uni) {
        $str = preg_replace("/($uni)/i", $nonUnicode, $str);
    }
    $str = str_replace(' ', '_', $str);
    return $str;
}

if (!function_exists('source_lead')) {
    function source_lead($status = null)
    {
        $result = $status;
        $leadstatus = [
            1 => "VFC",
            2 => "VM",
            3 => "Tự kiếm",
            4 => "Vbee",
            5 => "Remkt"
        ];
        if ($status === null) return $leadstatus;
        foreach ($leadstatus as $key => $item) {
            if ($key == $status) {
                $result = $item;
                return $result;
            }
        }
        return $result;
    }
}

if (!function_exists('priority_lead')) {
    function priority_lead($status = null)
    {
        $result = '';
        $leadstatus = [
            1 => "Cao",
            2 => "Trung bình",
            3 => "Thấp",
            4 => "Kém",
        ];
        if ($status === null) return $leadstatus;
        foreach ($leadstatus as $key => $item) {
            if ($key == $status) {
                $result = $item;
                return $result;
            }
        }
        return $result;
    }
}

if (!function_exists('month_investment')) {
    function month_investment($status = null)
    {
        $result = '';
        $leadstatus = [
            30 => "1 tháng",
            60 => "2 tháng",
            90 => "3 tháng",
            180 => "6 tháng",
            270 => "9 tháng",
            360 => "12 tháng",
            450 => "15 tháng",
            540 => "18 tháng",
            720 => "24 tháng",
            750 => "25 tháng",
            780 => "26 tháng",
            1080 => "36 tháng",
        ];
        if ($status === null) return $leadstatus;
        foreach ($leadstatus as $key => $item) {
            if ($key == $status) {
                $result = $item;
                return $result;
            }
        }
        return $result;
    }
}

if (!function_exists('type_interest')) {
    function type_interest($status = null)
    {
        $result = '';
        $leadstatus = [
            1 => "Lãi hàng tháng, gốc hàng tháng",
            2 => "Lãi hàng tháng, gốc cuối kỳ",
            3 => "Lãi hàng quý, gốc cuối kỳ",
            4 => "Gốc lãi cuối kỳ",
            5 => "Lãi cuối tháng",
        ];
        if ($status === null) return $leadstatus;
        foreach ($leadstatus as $key => $item) {
            if ($key == $status) {
                $result = $item;
            }
        }
        return $result;
    }
}


function convert_interest($interest)
{
    $x = round($interest * 12, 1);
    $y = ($x - (int)$x);
    if ($y >= 0.5) {
        $z = (int)$x + 0.5;
    } else {
        $z = (int)$x;
    }
    return $z;
}

if (!function_exists('event_month')) {
    function event_month($status = null)
    {
        $result = '';
        $leadstatus = [
            1 => "1 lần",
            2 => "2 lần",
//            4 => "4 lần",
        ];
        if ($status === null) return $leadstatus;
        foreach ($leadstatus as $key => $item) {
            if ($key == $status) {
                $result = $item;
            }
        }
        return $result;
    }
}

if (!function_exists('event_day')) {
    function event_day($status = null)
    {
        $result = '';
        $leadstatus = [
            1 => "Thứ hai",
            2 => "Thứ ba",
            3 => "Thứ tư",
            4 => "Thứ năm",
            5 => "Thứ sáu",
            6 => "Thứ bảy",
            7 => "Chủ nhật",
        ];
        if ($status === null) return $leadstatus;
        foreach ($leadstatus as $key => $item) {
            if ($key == $status) {
                $result = $item;
            }
        }
        return $result;
    }
}

if (!function_exists('event_hour')) {
    function event_hour($status = null)
    {
        $result = '';
        $leadstatus = [
            7 => "7AM - 8AM",
            8 => "8AM - 9AM",
            9 => "9AM - 10AM",
            10 => "10AM - 11AM",
            14 => "14PM - 15PM",
            15 => "15PM - 16PM",
            16 => "16PM - 17PM",
            21 => "21PM - 22PM",
            22 => "22PM - 23PM",
        ];
        if ($status === null) return $leadstatus;
        foreach ($leadstatus as $key => $item) {
            if ($key == $status) {
                $result = $item;
            }
        }
        return $result;
    }
}

if (!function_exists('event_repeat')) {
    function event_repeat($status = null)
    {
        $result = '';
        $leadstatus = [
            1 => "Hàng ngày",
            2 => "Hàng tuần",
            3 => "Hàng tháng",
            4 => "Hàng năm",
        ];
        if ($status === null) return $leadstatus;
        foreach ($leadstatus as $key => $item) {
            if ($key == $status) {
                $result = $item;
            }
        }
        return $result;
    }
}

if (!function_exists('event_object')) {
    function event_object($status = null)
    {
        $result = '';
        $leadstatus = [
            1 => "Tất cả",
            2 => "Chưa kích hoạt",
            3 => "Đã kích hoạt và đầu tư",
            4 => "Đã kích hoạt và chưa đầu tư",
            5 => "Đã đáo hạn nhưng chưa quay lại đầu tư",
            6 => "Đến ngày sinh nhật",
        ];
        if ($status === null) return $leadstatus;
        foreach ($leadstatus as $key => $item) {
            if ($key == $status) {
                $result = $item;
            }
        }
        return $result;
    }
}

if (!function_exists('status_contract')) {
    function status_contract($status = null)
    {
        $result = '';
        $leadstatus = [
            1 => "Đang đầu tư",
            2 => "Đã đáo hạn",
        ];
        if ($status === null) return $leadstatus;
        foreach ($leadstatus as $key => $item) {
            if ($key == $status) {
                $result = $item;
            }
        }
        return $result;
    }
}

if (!function_exists('color_status_contract')) {
    function color_status_contract($status = null)
    {
        $result = '';
        $leadstatus = [
            1 => "bg-success",
            2 => "bg-danger",
        ];
        if ($status === null) return $leadstatus;
        foreach ($leadstatus as $key => $item) {
            if ($key == $status) {
                $result = $item;
            }
        }
        return $result;
    }
}

if (!function_exists('status_pay')) {
    function status_pay($status = null)
    {
        $result = 'Đang xử lý';
        $leadstatus = [
            1 => "Chưa thanh toán",
            2 => "Đã thanh toán",
        ];
        if ($status === null) return $leadstatus;
        foreach ($leadstatus as $key => $item) {
            if ($key == $status) {
                $result = $item;
            }
        }
        return $result;
    }
}

if (!function_exists('color_status_pay')) {
    function color_status_pay($status = null)
    {
        $result = 'bg-warning';
        $leadstatus = [
            1 => "bg-danger",
            2 => "bg-success",
            3 => "bg-warning"
        ];
        if ($status === null) return $leadstatus;
        foreach ($leadstatus as $key => $item) {
            if ($key == $status) {
                $result = $item;
            }
        }
        return $result;
    }
}

if (!function_exists('color_priority_lead')) {
    function color_priority_lead($status = null)
    {
        $result = '';
        $leadstatus = [
            1 => "badge-success",
            2 => "badge-warning",
            3 => "badge-danger",
            4 => "badge-danger",
        ];
        if ($status === null) return $leadstatus;
        foreach ($leadstatus as $key => $item) {
            if ($key == $status) {
                $result = $item;
                return $result;
            }
        }
        return $result;
    }
}

if (!function_exists('status_job')) {
    function status_job($status = null)
    {
        $result = "";
        $leadstatus = [
            1 => 'Nhân viên văn phòng',
            2 => 'Nhân viên kinh doanh',
            3 => 'Bán hàng',
            4 => 'Kế toán-Kiểm toán',
            5 => 'Tư vấn',
            6 => 'Kỹ thuật',
            7 => 'Quản trị kinh doanh',
            8 => 'Xây dựng',
            9 => 'Marketing-PR',
            10 => 'Điện-Điện tử-Điện lạnh',
            11 => 'Cơ khí-Chế tạo',
            12 => 'Khách sạn-Nhà hàng',
            13 => 'Kiến trúc-TK nội thất',
            14 => 'Nhân sự',
            15 => 'Kho vận-Vật tư',
            16 => 'Thực phẩm-Đồ uống',
            17 => 'Dịch vụ',
            18 => 'Thư ký-Trợ lý',
            19 => 'Ngân hàng',
            20 => 'Thiết kế-Mỹ thuật',
            21 => 'Tài chính-Đầu tư',
            22 => 'Biên-Phiên dịch',
            23 => 'Vận tải',
            24 => 'Tiếp thị-Quảng cáo',
            25 => 'Ngoại thương-Xuất nhập khẩu',
            26 => 'IT phần mềm',
            27 => 'Ô tô - Xe máy',
            28 => 'KD bất động sản',
            29 => 'IT phần cứng/mạng',
            30 => 'Y tế-Dược',
            31 => 'Kỹ thuật ứng dụng',
            32 => 'Thiết kế đồ hoạ web',
            33 => 'Dệt may - Da giày',
            34 => 'Giáo dục-Đào tạo',
            35 => 'Điện tử viễn thông',
            36 => 'Thương mại điện tử',
            37 => 'Spa-Mỹ phẩm-Trang sức',
            38 => 'Công nghiệp',
            39 => 'Thời trang',
            40 => 'Báo chí-Truyền hình',
            41 => 'Hoá học-Sinh học',
            42 => 'Ngành nghề khác',
            43 => 'In ấn-Xuất bản',
            44 => 'Du lịch',
            45 => 'Pháp lý-Luật',
            46 => 'Hoạch định-Dự án',
            47 => 'Quan hệ đối ngoại',
            48 => 'Nông-Lâm-Ngư nghiệp',
            49 => 'An ninh-Bảo vệ',
            50 => 'Bảo hiểm',
            51 => 'Tổ chức sự kiện-Quà tặng',
            52 => 'Bưu chính',
            53 => 'Dầu khí-Hóa chất',
            54 => 'Nghệ thuật - Điện ảnh',
            55 => 'Công nghệ cao',
            56 => 'Hàng gia dụng',
            57 => 'Hàng hải',
            58 => 'Chứng khoán- Vàng',
            59 => 'Hàng không',
            60 => 'Thủ công mỹ nghệ',
            61 => 'Gamer',
            62 => 'Tài xế tự do',
            63 => 'Kinh doanh tự do',
            64 => 'Tài xế công nghệ',
            65 => 'Tài xế Grap',
            66 => 'Tài xế Be',
            67 => 'Tài xế Goviet',
            68 => 'Tài xế HeyU',
            69 => 'Tài xế FastGo',
            70 => 'Tài xế MyGo',
            71 => 'Shipper tự do',
            72 => 'Shipper công nghệ',
            73 => 'Tài xế Gojek'
        ];
        if ($status === null) return $leadstatus;
        foreach ($leadstatus as $key => $item) {
            if ($key == $status) {
                $result = $item;
            }
        }
        return $result;
    }
}

if (!function_exists('color_lead_status')) {
    function color_lead_status($status = null)
    {
        $result = '';
        $leadstatus = [
            1 => "badge-block",
            2 => "badge-block",
            3 => "badge-block",
            4 => "badge-block",
            5 => "badge-block",
            6 => "badge-block",
            7 => "badge-block",
            8 => "badge-block",
            9 => "badge-block",
            10 => "badge-active",
            11 => "badge-active",
            12 => "badge-active",
            13 => "badge-block",
            14 => "badge-active",
        ];
        if ($status === null) return $leadstatus;
        foreach ($leadstatus as $key => $item) {
            if ($key == $status) {
                $result = $item;
            }
        }
        return $result;
    }
}
