<?php

return [
    'name' => 'ViewCpanel',
    'disable_module' => env("DISABLE_MODULE_VIEW_CPANEL", false),
    'rp_log_action' => [
        'create_rp'         => 'Tạo biên bản',
        'update_rp'         => 'Cập nhật biên bản',
        'confirm_rp'        => 'Duyệt biên bản',
        'not_confirm_rp'    => 'Không duyệt biên bản',
        'sent_reconfirm_rp' => 'Gửi duyệt lại biên bản',
        'infer_rp'          => 'Đưa ra kết luận',
        'feedback_rp'       => 'Phản hồi biên bản',
        'wait_confrim_rp'   => 'Gửi duyệt biên bản',
        'cancel_rp'         => 'Hủy biên bản',
        'wait_infer'        => 'Chờ kết luận từ TBP',
        'sendCeo'           => 'Gửi CEO xác nhận',
        'ceoConfirm'        => 'CEO đồng ý',
        'ceoNotConfirm'     => 'CEO chưa đồng ý',
        'infer_to_ceo_rp'   => 'Gửi ý kiến đến CEO',
    ],
    "CEO" => [
        "hailm@tienngay.vn"
    ],
    "QLTBP" => [
        '6302ebbd7aa12c374800c783',
    ],
    'note_log_action' => [
        'wait_confrim_note'     => 'Gửi duyệt phiếu ghi',
        'not_confrim_note'      => 'Không duyệt phiếu ghi',
        'reconfirm_note'        => 'Gửi duyệt lại phiếu ghi',
        'infer_note'            => 'Đưa ra kết luận',
        'feedback_note'         => 'Phản hồi phiếu ghi',
        'create_note'           => 'Tạo phiếu ghi',
        'update_note'           => 'Cập nhật phiếu ghi',
        'confirm_note'          => 'Duyệt phiếu ghi',
        'wait_infer_note'       => 'Chờ kết luận',
        'cancel_note'           => 'Hủy phiếu ghi',
    ],

    "TBPKSNB" => [
        'tients@tienngay.vn',
    ],
    
    'name_email' => [
        'marketing' => [
            'cskh@tienngay.vn' => 'CSKH-Tienngay.vn',
        ],
        'telesales' => [
            'cskh@tienngay.vn' => 'CSKH-Tienngay.vn',
        ],
    ],

    'action_macom' => [
        'create' => 'Tạo mới bản ghi',
        'update' => 'Cập nhật bản ghi',
    ],
    'tradeMkt' => [
        'deliveryBill' => [
            'create'        => "Tạo phiếu xuất kho",
            'updateLisence' => "Cập nhật chứng từ",
        ],
        'transfer' => [
            'create'        => 'Tạo phiếu điều chuyển',
            'edit'          => "Sửa phiếu điều chuyển",
            'uploadExport'  => "Upload chứng từ xuất",
            'uploadImport'  => "Upload chứng từ nhận",
            'cancel'        => "Hủy phiếu điều chuyển",
            'delete'        => "Xóa phiếu điều chuyển",
        ]
    ]
];

