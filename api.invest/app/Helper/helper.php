<?php

if (!function_exists('current_user')) {
    function current_user()
    {
        if (app('request')->hasHeader('Authorization')) {
            $token = \App\Service\Auth\Authorization::validateToken(app('request')->header('Authorization'));
            if ($token) {
                $user = app(\App\Repository\UserRepositoryInterface::class)->checkLoginUser($token->email, $token->phone, app('request')->header('Authorization'));
                if ($user) {
                    return $user;
                }
            }
        }

        return null;
    }
}

function check_leap_year($year)
{
    if (($year % 400 == 0) || ($year % 4 == 0 && $year % 100 != 0)) {
        return true;
    } else {
        return false;
    }
}

function get_created_at_with_year($month, $year)
{
    $leap_year = check_leap_year((int)$year);
    $condition = [];
    $condition['start'] = "$year-$month-01" . ' 00:00:00';
    switch ($month) {
        case '01':
            $condition['end'] = "$year-01-31" . ' 23:59:59';
            break;
        case '02':
            if ($leap_year == true) {
                $condition['end'] = "$year-02-29" . ' 23:59:59';
            } else {
                $condition['end'] = "$year-02-28" . ' 23:59:59';
            }
            break;
        case '03':
            $condition['end'] = "$year-03-31" . ' 23:59:59';
            break;
        case '04':
            $condition['end'] = "$year-04-30" . ' 23:59:59';
            break;
        case '05':
            $condition['end'] = "$year-05-31" . ' 23:59:59';
            break;
        case '06':
            $condition['end'] = "$year-06-30" . ' 23:59:59';
            break;
        case '07':
            $condition['end'] = "$year-07-31" . ' 23:59:59';
            break;
        case '08':
            $condition['end'] = "$year-08-31" . ' 23:59:59';
            break;
        case '09':
            $condition['end'] = "$year-09-30" . ' 23:59:59';
            break;
        case '10':
            $condition['end'] = "$year-10-31" . ' 23:59:59';
            break;
        case '11':
            $condition['end'] = "$year-11-30" . ' 23:59:59';
            break;
        case '12':
            $condition['end'] = "$year-12-31" . ' 23:59:59';
            break;
    }
    return $condition;
}

function number_format_vn($number)
{
    return number_format($number, 0, ',', '.');
}

function pmt($rate_per_period, $number_of_payments, $present_value, $future_value = 0, $type = 0)
{

    if ($rate_per_period != 0) {
        // Interest rate exists
        $q = pow(1 + $rate_per_period, $number_of_payments);
        return -($rate_per_period * ($future_value + ($q * $present_value))) / ((-1 + $q) * (1 + $rate_per_period * ($type)));

    } else if ($number_of_payments != 0) {
        // No interest rate, but number of payments exists
        return -($future_value + $present_value) / $number_of_payments;
    }

    return 0;
}

function get_end_day_month_with_year($month, $year)
{
    $leap_year = check_leap_year((int)$year);
    switch ($month) {
        case '01':
            $end = "$year-01-31";
            break;
        case '02':
            if ($leap_year == true) {
                $end = "$year-02-29";
            } else {
                $end = "$year-02-28";
            }
            break;
        case '03':
            $end = "$year-03-31";
            break;
        case '04':
            $end = "$year-04-30";
            break;
        case '05':
            $end = "$year-05-31";
            break;
        case '06':
            $end = "$year-06-30";
            break;
        case '07':
            $end = "$year-07-31";
            break;
        case '08':
            $end = "$year-08-31";
            break;
        case '09':
            $end = "$year-09-30";
            break;
        case '10':
            $end = "$year-10-31";
            break;
        case '11':
            $end = "$year-11-30";
            break;
        case '12':
            $end = "$year-12-31";
            break;
    }
    return $end;
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

if (!function_exists('title_notification')) {
    function title_notification($code = null)
    {
        $data = [
            "promotion" => "Chương trình khuyến mại",
            "investor" => "Đầu tư TienNgay.vn",
            "pay" => "Thanh toán kỳ nhà đầu tư",
            "auth" => "Xác thực nhà đầu tư",
            "general" => "Thông báo TienNgay.vn",
        ];
        if ($code == null) return "Thông báo TienNgay.vn";
        foreach ($data as $key => $item) {
            if ($key == $code) {
                $result = $item;
            }
        }
        return $result;
    }
}
