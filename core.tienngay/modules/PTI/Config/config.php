<?php

return [
    'name' => 'PTI',
    'CODE_SUCCESS' => '000',
    'SO_ID_DT' => '1', //Số id đối tượng trong trường hợp danh sách nếu cấp lẻ để mặc định là 1 Cấp nhóm : 0
    'LOAI_IN' => 'I', // 'X' – Kết xuất bản xem trước chưa có hiệu lực 'I' – Kết xuất bản ký số
    'NV' => 'PVCOV', //Mã nghiệp vụ loại hình bảo hiểm, đối với VTA là VCOV, VTA Plus là PVCOV
    'DVI_SL' => '041', //Mã đơn vị bảo hiểm, khi sửa đơn phải truyền lại mã đơn vị của đơn cũ
    'SUC_KHOE' => 'K', // C: Có, K: Không
    'KIEU_HD_G' => 'G', // nếu hợp đồng là hợp đồng gốc
    'KIEU_HD_B' => 'B', // nếu hợp đồng là hợp đồng sửa đổi bổ sung
    'TTRANG_T' => 'T', // Đang trình
    'TTRANG_D' => 'D', // Đã duyệt
    'TTRANG_H' => 'H', // Huỷ


    'BHTN_DVI_SL' => '041',
    'BHTN_NV' => 'CN.2.1',
    'BHTN_KIEU_HD' => 'G',
    'BHTN_DS_DK' => [
        [
            "loai" => "A1",
            "tien" => "100000000"
        ],
        [
            "loai" => "A2",
            "tien" => "100000000",
        ],
        [
            "loai" => "A3",
            "tien" => "3000000"
        ],
        [
            "loai" => "A4",
            "tien" => "18000000"
        ],
        [
            "loai" => "A5",
            "tien" => "2000000"
        ],
        [
            "loai" => "A6",
            "tien" => "2000000"
        ]
    ],
    'BHTN_ENCRYPT' => 'K',
    'BHTN_MA_BC' => 'BHTN_GCNBH_TIENNGAY',
    'BHTN_SO_ID_DT' => '1',
    'BHTN_LOAI_IN' => 'I',
];
