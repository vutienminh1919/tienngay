<?php
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

function check_isset($value)
{
    return isset($value) ? $value : null;
}

if (!function_exists('supplies_status')) {
    function supplies_status($status = null)
    {
        $result = '';
        $leadstatus = [
            1 => "Thiết bị mới",
            2 => "Thiết bị hỏng",
            3 => "Thiết bị lưu kho",
            4 => "Thiết bị đang sử dụng",
            5 => "Thiết bị chờ xử lý",
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

function check_undefined($value)
{
    if ($value) {
        if ($value !== "undefined") {
            return $value;
        } else {
            return "";
        }
    } else {
        return "";
    }

}

if (!function_exists('category_request')) {
    function category_request($status = null)
    {
        $result = '';
        $leadstatus = [
            3 => "Báo hỏng thiết bị",
            7 => "Gửi trả thiết bị",
            10 => "Gửi kiểm kê thiết bị",
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

if (!function_exists('color_status')) {
    function color_status($status = null)
    {
        $result = '';
        $leadstatus = [
            1 => "#ae3ec9",
            2 => "#d63939",
            3 => "#4299e1",
            4 => "#0ca678",
            5 => "#f59f00",
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

if (!function_exists('color_category_request')) {
    function color_category_request($status = null)
    {
        $result = '';
        $leadstatus = [
            3 => "text-danger",
            7 => "text-info",
            10 => "text-warning",
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

function gen_code($count)
{
    $code = '';
    $length = strlen((string)$count);
    switch ($length) {
        case 1:
            $code = '00' . $count;
            break;
        case 2 :
            $code = '0' . $count;
            break;
        default:
            $code = (string)$count;
    }
    return $code;
}
