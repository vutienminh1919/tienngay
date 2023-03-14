<?php


namespace Modules\CtvTienNgay\Service;


use Illuminate\Support\Facades\Http;

class ConfigService
{
    public static function lead_status_web($option)
    {
        $arr = [
            1 => 'Đang xử lý',
            2 => 'Thành công',
            3 => 'Thất bại'
        ];
        foreach ($arr as $k => $v) {
            if ($option == $k) {
                return $v;
            }
        }
        return 'Đang xử lý';
    }

    public static function lead_type_finance($type)
    {
        $arr = [
            3 => "Đăng kí ô tô",
            4 => "Đăng kí xe máy",
            7 => "Ứng tiền cho tài xế công nghệ",
            8 => "Sổ đỏ",
            9 => "Sổ hồng, hợp đồng mua bán căn hộ",
            10 => "Bảo hiểm Vững Tâm An",
            11 => "Bảo hiểm Phúc Lộc Thọ",
            12 => "Bảo hiểm Ung thư vú",
            13 => "Bảo hiểm Sốt xuất huyết",
            14 => "Bảo hiểm TNDS xe máy/ô tô",
            17 => "Bảo hiểm tai nạn con người"
        ];
        foreach ($arr as $k => $v) {
            if ($type == $k) {
                return $v;
            }
        }
        return 'Chưa xác định';
    }

    public static function get_list_bank()
    {
        $result = Http::get("https://api.vietqr.io/v2/banks");
        $result = json_decode($result->body());
        if ($result->code == "00") {
            return $result->data;
        } else {
            return null;
        }
    }

    private static function stars($phone)
    {
        $times = strlen(trim(substr($phone, 5, 5)));
        $star = '';
        for ($i = 0; $i < $times; $i++) {
            $star .= '*';
        }
        return $star;
    }

    public static function hide_number($phone, $role = "")
    {
        $result = str_replace(substr($phone, 3, 5), self::stars($phone), $phone);
        if ($role != "") {
            return $phone;
        } else {
            return $result;
        }
    }

    public static function number_format_vn($num)
    {
        return number_format($num, 0, ',', '.');
    }

}
