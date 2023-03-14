<?php

namespace Modules\VFCPayment\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class BaseController extends Controller
{
    protected function getApiUrl($path) {

        if (env('APP_ENV') == 'dev') {
            return env('API_URL_STAGE') . '/' . $path;
        } elseif (env('APP_ENV') == 'product') {
            return env('API_URL_PROD') . '/' . $path;
        } else {
            return env('API_URL_LOCAL') . '/' . $path;
        }
    }

    protected function responseSuccess($data) {
        return response()->json([
            'code' => Response::HTTP_OK,
            'data' => $data
        ]);
    }

    protected function responseError($error) {
        return response()->json([
            'code' => Response::HTTP_BAD_REQUEST,
            'error' => $error
        ]);
    }

    /**
    * Hide numbers of a phone number
    */
    protected function hideNumberOfPhone($phone) {
        $phoneNumber = str_replace(substr($phone, 4,4), '****', $phone);
        return $phoneNumber;
    }

    /**
    * Hide numbers of a phone number
    */
    protected function hideNumberOfIdentityCard($identityCard) {
        if (strlen($identityCard) < 12) {
            $identityCard = str_replace(substr($identityCard, 4,4), '****', $identityCard);
        } else {
            $identityCard = str_replace(substr($identityCard, 4,5), '*****', $identityCard);
        }
        return $identityCard;
    }
}
