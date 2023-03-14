<?php


namespace Modules\CtvTienNgay\Http\Controllers;


use Illuminate\Http\Request;
use Modules\CtvTienNgay\Service\UploadService;

class UploadController extends BaseController
{
    protected $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    /**
     * @OA\Post(
     *     path="/ctv-tienngay/app/upload",
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
     * )
     */
    public function upload(Request $request)
    {
        $message = $this->uploadService->check_upload($request);
        if (count($message) > 0) {
            return BaseController::send_response(self::HTTP_BAD_REQUEST, $message[0]);
        }
        $data = $this->uploadService->upload($request);
        if (count($data) > 0) {
            return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
        } else {
            return BaseController::send_response(self::HTTP_BAD_REQUEST, self::FAIL);
        }
    }
}
