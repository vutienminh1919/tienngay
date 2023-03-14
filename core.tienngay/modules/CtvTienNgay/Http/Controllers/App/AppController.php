<?php


namespace Modules\CtvTienNgay\Http\Controllers\App;


use Modules\CtvTienNgay\Http\Controllers\BaseController;

class AppController extends BaseController
{
    /**
     * @OA\Get (
     *     path="/ctv-tienngay/app/review",
     *     tags={"App"},
     *     summary="review app",
     *     description="review app",
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
    public function review()
    {
        $data = [
            'apple' => env('APPLE') ?? false,
            'google' => env('GOOGLE') ?? false,
        ];
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }
}
