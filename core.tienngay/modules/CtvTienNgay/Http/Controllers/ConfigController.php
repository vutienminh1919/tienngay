<?php


namespace Modules\CtvTienNgay\Http\Controllers;


use Illuminate\Support\Facades\Http;
use Modules\CtvTienNgay\Service\ConfigService;

class ConfigController extends BaseController
{
    protected $configService;

    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
    }

    /**
     * @OA\Get (
     *     path="/ctv-tienngay/app/config/lead_type_finance",
     *     tags={"Const"},
     *     summary="Danh sach hinh thuc vay",
     *     description="Danh sach hinh thuc vay",
     *     @OA\Response(
     *         response=200,
     *         description="successfully",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="failed",
     *     ),
     * )
     */
    public function lead_type_finance()
    {
        $lead_type_finance = [
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
        return BaseController::send_response(BaseController::HTTP_OK, BaseController::SUCCESS, $lead_type_finance);
    }

    /**
     * @OA\Get (
     *     path="/ctv-tienngay/app/config/get_list_bank",
     *     tags={"Const"},
     *     summary="Danh sach bank",
     *     description="Danh sach bank",
     *     @OA\Response(
     *         response=200,
     *         description="successfully",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="failed",
     *     ),
     * )
     */
    public function get_list_bank()
    {
        $data = $this->configService->get_list_bank();
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }
}
