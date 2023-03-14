<?php


namespace Modules\AssetTienNgay\Http\Controllers\App;


use Illuminate\Http\Request;
use Modules\AssetTienNgay\Http\Controllers\BaseController;
use Modules\AssetTienNgay\Http\Service\SuppliesService;
use Modules\AssetTienNgay\Http\Service\Upload;

class SuppliesController extends BaseController
{
    protected $suppliesService;
    protected $upload;

    public function __construct(SuppliesService $suppliesService,
                                Upload $upload)
    {
        $this->suppliesService = $suppliesService;
        $this->upload = $upload;
    }

    /**
     * @OA\Post(
     *     path="/asset/app/supplies/list",
     *     tags={"Supplies"},
     *     summary="Lấy danh sách thiết bị",
     *     description="Lấy danh sách thiết bị",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="name",type="string",description="tên thiết bị"),
     *                 @OA\Property(property="status",type="number",description="trạng thái thiết bị"),
     *                 @OA\Property(property="department_id",type="string",description="Phòng ban"),
     *                 @OA\Property(property="user_id",type="string",description="nhân viên"),
     *                 @OA\Property(property="equipment_id",type="string",description="loại thiết bị"),
     *                 @OA\Property(property="equipment_child_id",type="string",description="dòng thiết bị"),
     *                 @OA\Property(property="offset",type="number",description="offset"),
     *                 @OA\Property(property="limit",type="number",description="limit"),
     *                  example={"offset":"0","limit":"5"}
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
    public function list(Request $request)
    {
        $data = $this->suppliesService->list_app($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data['data'],
            'fitter' => $data['fitter'],
        ]);
    }

    /**
     * @OA\Post(
     *     path="/asset/app/supplies/show",
     *     tags={"Supplies"},
     *     summary="chi tiết thiết bị",
     *     description="chi tiết thiết bị",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="supplies_id",type="string",description="id thiet bi"),
     *                  example={"supplies_id": "618e0fcdfd060000530008c9"}
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
    public function show(Request $request)
    {
        $data = $this->suppliesService->show_app($request);
        if ($data) {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_OK,
                BaseController::MESSAGE => BaseController::SUCCESS,
                BaseController::DATA => $data
            ]);
        } else {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => BaseController::NO_DATA,
            ]);
        }
    }

    /**
     * @OA\Post(
     *     path="/asset/app/supplies/send_request", tags={"Supplies"}, summary="gửi yêu cầu", description="gửi yêu cầu",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="supplies_id",type="string",description="id thiet bi"),
     *                 @OA\Property(property="type_request",type="number",description="loai yeu cau"),
     *                 @OA\Property(property="note",type="string",description="ghi chu"),
     *                 @OA\Property(property="image_description",type="string"),
     *                  example={
     *                         "supplies_id": "618e0fcdfd060000530008c9",
     *                         "type_request": "3",
     *                         "note": "bao hong",
     *                         "image_description": {
     *                            {
     *                              "path": "https://sandboxservice.tienngay.vn/uploads/avatar/1637382400-8c50eb8fb0fdddfae1069e2fd22486fd.jpg",
     *                              "file_type": "image/jpeg",
     *                              "file_name": "tai-hinh-nen-vu-tru-cho-may-tinh-9.jpg",
     *                              "key": "61987900e87e0"
     *                           },
     *                            {
     *                              "path": "https://sandboxservice.tienngay.vn/uploads/avatar/1637382400-8c50eb8fb0fdddfae1069e2fd22486fd.jpg",
     *                              "file_type": "image/jpeg",
     *                              "file_name": "tai-hinh-nen-vu-tru-cho-may-tinh-9.jpg",
     *                              "key": "61943467787e0"
     *                           }
     *                      }
     *                  }
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
    public function send_request(Request $request)
    {
        $message = $this->suppliesService->validate_send_request($request);
        if (count($message) > 0) {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $message[0],
            ]);
        }
        $this->suppliesService->send_request($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/asset/app/supplies/upload",
     *     tags={"Media"},
     *     summary="Upload hình ảnh",
     *     description="Upload hình ảnh",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="file",type="file",description="ảnh thiết bị", format="binary"),
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
    public function upload(Request $request)
    {
        $message = $this->suppliesService->check_upload($request);
        if (count($message) > 0) {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $message[0],
            ]);
        }
        $data = $this->suppliesService->upload($request);
        if (count($data) > 0) {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_OK,
                BaseController::MESSAGE => BaseController::SUCCESS,
                BaseController::DATA => $data,
            ]);
        } else {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => "Upload thất bại",
            ]);
        }
    }

    /**
     * @OA\Post(
     *     path="/asset/app/supplies/type_request",
     *     tags={"Supplies"},
     *     summary="ds loại gửi yêu cầu",
     *     description="ds loại gửi yêu cầu",
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
    public function type_request(Request $request)
    {
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => category_request(),
        ]);
    }

    /**
     * @OA\Post(
     *     path="/asset/app/supplies/supplies_status",
     *     tags={"Supplies"},
     *     summary="ds trang thai thiet bi",
     *     description="ds trang thai thiet bi",
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
    public function supplies_status(Request $request)
    {
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => supplies_status(),
        ]);
    }

    /**
     * @OA\Post(
     *     path="/asset/app/supplies/confirm", tags={"Supplies"}, summary="xác nhận tiếp nhận thiết bị", description="xác nhận tiếp nhận thiết bị",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="supplies_id",type="string",description="id thiet bi"),
     *                 @OA\Property(property="note",type="string",description="ghi chu"),
     *                 @OA\Property(property="image_description",type="string"),
     *                  example={
     *                         "supplies_id": "618e0fcdfd060000530008c9",
     *                         "note": "da tiep nhan",
     *                         "image_description": {
     *                            {
     *                              "path": "https://sandboxservice.tienngay.vn/uploads/avatar/1637382400-8c50eb8fb0fdddfae1069e2fd22486fd.jpg",
     *                              "file_type": "image/jpeg",
     *                              "file_name": "tai-hinh-nen-vu-tru-cho-may-tinh-9.jpg",
     *                              "key": "61987900e87e0"
     *                           }
     *                      }
     *                  }
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
    public function confirm(Request $request)
    {
        $message = $this->suppliesService->validate_confirm($request);
        if (count($message) > 0) {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $message[0],
            ]);
        }
        $this->suppliesService->confirm($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
        ]);
    }
}
