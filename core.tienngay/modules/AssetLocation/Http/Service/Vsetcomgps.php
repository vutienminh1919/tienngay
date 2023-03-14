<?php


namespace Modules\AssetLocation\Http\Service;


use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class Vsetcomgps
{
    public function __construct()
    {
        $this->url = env('VSET_URL');
        $this->id = env('VSET_APPID');
        $this->key = 'OCRh7@mEdKi#7iqPmjbd1fk@eDLI09Jr';

    }

    public function auth()
    {
        $time = Carbon::now()->unix();
        $data = [
            'appid' => $this->id,
            'time' => $time,
            'signature' => md5(md5($this->key) . $time)
        ];
        $url = $this->url . 'api/auth';
        $result = $this->api_post($url, $data);
        return $result;
    }

    //lay trang thai thiet bi
    public function miles($access_token, $imei)
    {
        $url = $this->url . 'api/device/status?accessToken=' . $access_token . '&imei=' . $imei . '&lang=EN';
        $result = Http::get($url);
        if ($result) {
            return json_decode($result->body());
        } else {
            return null;
        }
    }

    public function location($access_token, $imei)
    {
        $url = $this->url . '/api/device/location?accessToken=' . $access_token . '&imei=' . $imei;
        $result = Http::get($url);
        if ($result) {
            return json_decode($result->body());
        } else {
            return null;
        }

    }

    public function api_post($url, $data)
    {
        $headers = [
            'Content-Type: application/json'
        ];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $result = curl_exec($ch);
        curl_close($ch);
        $result1 = json_decode($result);
        return $result1;
    }

    public static function error_code($code)
    {
        $data = [
            0 => 'Thành công',
            10001 => 'Appid không được rỗng',
            10002 => 'Time không được rỗng',
            10003 => 'Chữ ký không chính xác',
            10004 => 'Tên người dùng và mật khẩu không chính xác',
            21001 => 'IMEI không được rỗng',
            21002 => 'IMEI không tồn tại',
            21003 => 'Không có quyền truy cập vào thiết bị này',
            21006 => 'Thời gian bắt đầu không được để trống',
            21007 => 'Thời gian bắt đầu không được muộn hơn thời gian kết thúc',
            21008 => 'Thời lượng không được quá 1 tháng',
            21009 => 'Dữ liệu trong vòng 9 tháng có thể được thu thập',
            23001 => 'Tham số không được rỗng',
            23002 => 'Tham số không được hỗ trợ: {sai tham số}',
            23004 => 'Lỗi định dạng IMEI, IMEI: {sai tham số}',
            23005 => 'Không có giấy phép truy cập, IMEI: {sai tham số}',
            23007 => 'Lệnh không được hỗ trợ cho thiết bị này',
            24001 => 'Uuid không được rỗng',
            24002 => 'Sai uuid: {sai tham số}',
            24003 => 'Không có giấy phép truy cập để kiểm tra uuid: {sai tham số}',
            25001 => 'Tài khoản phụ sai: {sai tham số}',
            25002 => 'Không có quyền truy cập vào tài khoản phụ: {sai tham số}',
            26001 => 'Vui lòng nhập thông tin thiết bị',
            26002 => 'Thiết bị được tạo nhiều lần',
            26003 => 'Loại thiết bị sai: {sai tham số}',
            26004 => 'Thông tin sử dụng sai',
            26005 => 'Không có quyền truy cập để vận hành người dùng: {sai tham số}',
            26006 => 'Định dạng IMEI sai: {sai tham số}',
            26007 => 'Định dạng biển số sai: {sai tham số}',
            26008 => 'Cần loại thiết bị khi tạo',
            26009 => 'Số VIN bắt buộc khi tạo',
            26010 => 'Định dạng VIN sai: {sai tham số}',
            26011 => 'Hỗ trợ tối đa 20 ký tự cho tên thiết bị',
            26013 => 'Trả lại mã trạng thái sai khi tạo phương tiện',
            26014 => 'Nhắc nhở lỗi khi thiết bị bỏ nhóm',
            27001 => 'IMEI không tồn tại: {sai tham số}',
            27002 => 'Không có giấy phép truy cập thao tác, IMEI: {sai tham số}',
            28000 => 'Không có giấy phép để truy cập người dùng này',
        ];
        if (empty($code)) {
            if ($code != 0) {
                return 'Lỗi không xác định';
            } else {
                return $data[(int)$code];
            }
        } else {
            return $data[(int)$code];
        }
    }

    public static function status($status)
    {
        $data = [
            '静止' => 'Đứng yên',
            '行驶' => 'Đang di chuyển',
            '离线' => 'Ngoại tuyến',
            '未启用' => 'Không hoạt động',
            '休眠' => 'Thiết bị đang chế độ ngủ'
        ];
        return $data[$status];
    }

    public static function const_status($status)
    {
        $data = [
            '静止' => 1,
            '行驶' => 2,
            '离线' => 3,
            '未启用' => 4,
            '休眠' => 5
        ];
        return $data[$status];
    }

    public static function const_alarm($status)
    {
        $data = [
            'REMOVE' => 1,
            'LOWVOT' => 2,
            'ERYA' => 3,
            'FENCEIN' => 4,
            'FENCEOUT' => 5,
            'SEP' => 6,
            'SOS' => 7,
            'OVERSPEED' => 8,
            'HOME' => 9,
            'COMPANY' => 10,
            'SHAKE' => 11,
            'STAYTIMEOUT' => 12,
            'AREAOUT' => 13,
            'AREAIN' => 14,
            'ACCOFF' => 15,
            'ACCON' => 16,
            'REMOVECONTINUOUSLY' => 17,
            'ABNORMALACCUMULATION' => 18,
            'VINMISMATCH' => 19,
            'TURNOVER' => 20,
            'CRASH' => 21,
            'SHARPTURN' => 22,
            'FASTACCELERATION' => 23,
            'FASTDECELERATION' => 24,
            'SHIFT' => 25
        ];
        return $data[$status];
    }

    public static function alarm($status)
    {
        $data = [
            'REMOVE' => "Báo động cắt điện hơn 5s",
            'LOWVOT' => "Báo động pin yếu",
            'ERYA' => "Báo động lần 2",
            'FENCEIN' => 'Báo động vào hàng rào',
            'FENCEOUT' => 'Báo động ngoài hàng rào',
            'SEP' => "Báo động riêng biệt",
            'SOS' => "Báo động SOS",
            'OVERSPEED' => 'Báo động quá tốc độ',
            'HOME' => "Báo động không về nhà",
            'COMPANY' => "Báo động không hoạt động",
            'SHAKE' => "Báo động rung",
            'STAYTIMEOUT' => "Hết giờ đỗ xe",
            'AREAOUT' => "Báo động ra ngoài khu vực",
            'AREAIN' => "Báo động vào trong khu vực",
            'ACCOFF' => "Báo động động cơ ngừng máy",
            'ACCON' => "Báo động khởi động",
            'REMOVECONTINUOUSLY' => "Báo động cúp điện",
            'ABNORMALACCUMULATION' => "Báo động bất thường",
            'VINMISMATCH' => "Báo động số khung không khớp",
            'TURNOVER' => "Báo động lật xe",
            'CRASH' => "Báo động va chạm",
            'SHARPTURN' => "Báo động rẽ ngoặt",
            'FASTACCELERATION' => "Báo động nhanh",
            'FASTDECELERATION' => "Báo động nhanh",
            'SHIFT' => 'Báo động thay đổi'
        ];
        return $data[$status];
    }
}
