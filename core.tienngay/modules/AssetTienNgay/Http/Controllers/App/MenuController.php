<?php


namespace Modules\AssetTienNgay\Http\Controllers\App;


use Illuminate\Http\Request;
use Modules\AssetTienNgay\Http\Controllers\BaseController;
use Modules\AssetTienNgay\Http\Service\MenuAssetService;

class MenuController extends BaseController
{
    protected $menuService;

    public function __construct(MenuAssetService $menuService)
    {
        $this->menuService = $menuService;
    }

    /**
     * @OA\Post(
     *     path="/asset/app/menu/get_depart_main",
     *     tags={"Supplies"},
     *     summary="Danh sách phòng ban",
     *     description="Danh sách phòng ban",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successfully",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="failed",
     *     ),
     *     security={
     *         {"api_key": {}}
     *     },
     * )
     */
    public function get_depart_main(Request $request)
    {
        $data = $this->menuService->get_depart_main($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }

    /**
     * @OA\Post(
     *     path="/asset/app/menu/get_child_app",
     *     tags={"Supplies"},
     *     summary="lấy danh sách con của phòng ban, loại thiết bị",
     *     description="lấy danh sách con của phòng ban, thiết bị",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="parent_id",type="string",description="id"),
     *                  example={"parent_id": "618b6948e6030000c8003528"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successfully",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="failed",
     *     ),
     *     security={
     *         {"api_key": {}}
     *     },
     * )
     */
    public function get_child_app(Request $request)
    {
        $data = $this->menuService->get_child_app($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }

    /**
     * @OA\Post(
     *     path="/asset/app/menu/get_equip_main",
     *     tags={"Supplies"},
     *     summary="Danh sách loại thiết bị",
     *     description="Danh sách loại thiết bị",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successfully",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="failed",
     *     ),
     *     security={
     *         {"api_key": {}}
     *     },
     * )
     */
    public function get_equip_main(Request $request){
        $data = $this->menuService->get_equip_main($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }
}
