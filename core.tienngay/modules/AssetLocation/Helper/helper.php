<?php
if (!function_exists('contract_status')) {
    function contract_status($status = null)
    {
        $result = '';
        $leadstatus = [
            1 => "Mới",
            2 => "Chờ trưởng PGD duyệt",
            3 => "Đã hủy",
            4 => "Trưởng PGD không duyệt",
            5 => "Chờ hội sở duyệt",
            6 => "Đã duyệt",
            7 => "Kế toán không duyệt",
            8 => "Hội sở không duyệt",
            9 => "Chờ ngân lượng xử lý",
            10 => "Giải ngân ngân lượng thất bại",
            11 => "Chờ TP thu hồi nợ duyệt gia hạn",
            12 => "Chờ TP thu hồi nợ duyệt cơ cấu",
            13 => "TP thu hồi nợ không duyệt gia hạn",
            14 => "TP thu hồi nợ không duyệt cơ cấu",
            15 => "Chờ giải ngân",
            16 => "Đã tạo lệnh giải ngân thành công",
            17 => "Đang vay",
            18 => "Giải ngân thất bại",
            19 => "Đã tất toán",
            20 => "Đã quá hạn",
            21 => "Chờ trưởng PGD duyệt gia hạn",
            22 => "Trưởng PGD không duyệt gia hạn",
            23 => "Chờ trưởng PGD duyệt cơ cấu",
            24 => "Trưởng PGD không duyệt cơ cấu",
            25 => "Chờ hội sở duyệt gia hạn",
            26 => "Hội sở không duyệt gia hạn",
            27 => "Chờ hội sở duyệt cơ cấu",
            28 => "Hội sở không duyệt cơ cấu",
            29 => "Chờ tạo phiếu thu gia hạn",
            30 => "Chờ ASM duyệt gia hạn",
            31 => "Chờ tạo phiếu thu cơ cấu",
            32 => "Chờ ASM duyệt cơ cấu",
            33 => "Đã gia hạn",
            34 => "Đã cơ cấu",
            35 => "Chờ ASM duyệt",
            36 => "ASM không duyệt",
            37 => "Chờ thanh lý",
            38 => "Chờ CEO duyệt thanh lý",
            39 => "Chờ TP THN thanh lý tài sản",
            40 => "Chờ tạo phiếu thu thanh lý tài sản",
            41 => "ASM không duyệt gia hạn",
            42 => "ASM không duyệt cơ cấu",
            43 => "CEO không duyệt thanh lý xe",
            44 => "Chờ định giá tài sản thanh lý",
            45 => "BPĐG trả về yêu cầu định giá tài sản",
            46 => "Chờ TPTHN cập nhật giá tham khảo",
            47 => "Chờ TPTHN duyệt thay CEO",
            48 => "Chờ bán tài sản thanh lý",
            49 => "Chờ BPĐG định giá lại",
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
