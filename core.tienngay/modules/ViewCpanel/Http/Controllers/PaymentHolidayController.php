<?php

namespace Modules\ViewCpanel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Modules\MongodbCore\Repositories\Interfaces\PaymentHolidayRepositoryInterface as PaymentHolidayRepository;
use Modules\MongodbCore\Entities\PaymentHoliday;
use Illuminate\Support\Facades\Http;

class PaymentHolidayController extends BaseController
{
    /**
     * Modules\MongodbCore\Repositories\PaymentHolidayRepository
     * */
    private $paymentHolidayRepo;

    /**
     * Modules\MongodbCore\Repositories\HeyuStoreRepository
     * */
    private $heyuStoreRepo;

    public function __construct(
        PaymentHolidayRepository $paymentHolidayRepo
    ) {
        $this->paymentHolidayRepo = $paymentHolidayRepo;
    }

    /**
     * holidays list
     * @return Renderable
     */
    public function index(Request $request)
    {
        Log::channel('cpanel')->info('PaymentHoliday index');
        $user = session('user');
        $userEmail = !empty($user['email']) ? $user['email'] : "";
        if (empty($userEmail)) {
            echo __('ViewCpanel::message.unauthorized');
            exit;
        }
        if (!$user['roles']['paymentHolidays']['index']) {
            echo __('ViewCpanel::message.permission_denied');
            exit;
        }
        $formData = $request->all();
        $holidays = [];
        $limit = 15;
        if (!empty($formData)) {
            $holidays = $this->paymentHolidayRepo->index($formData, $limit);
        } else {
            $holidays = $this->paymentHolidayRepo->index([], $limit);
        }
        $model = new PaymentHoliday();
        return view('viewcpanel::paymentHolidays.index', [
            'model' => $model,
            'items' => $holidays,
            'formData' => $formData,
            'updateStatus' => route('viewcpanel::PaymentHolidays.updateStatus'),
            'createUrl' => route('viewcpanel::PaymentHolidays.store')
        ]);
    }

    /**
     * holidays detail
     * @return Renderable
     */
    public function detail($id)
    {
        Log::channel('cpanel')->info('PaymentHoliday detail');
        $user = session('user');
        $userEmail = !empty($user['email']) ? $user['email'] : "";
        if (empty($userEmail)) {
            echo __('ViewCpanel::message.unauthorized');
            exit;
        }
        if (!$user['roles']['paymentHolidays']['detail']) {
            echo __('ViewCpanel::message.permission_denied');
            exit;
        }
        $holiday = $this->paymentHolidayRepo->fetch($id);
        if (!$holiday) {
            abort(404);
        }
        $model = new PaymentHoliday();
        return view('viewcpanel::paymentHolidays.detail', [
            'id' => $id,
            'edit' => false,
            'model' => $model,
            'holiday' => $holiday,
            'updateUrl' => route('viewcpanel::PaymentHolidays.update')
        ]);
    }

    /**
     * holidays edit
     * @return Renderable
     */
    public function edit($id)
    {
        Log::channel('cpanel')->info('PaymentHoliday edit');
        $user = session('user');
        $userEmail = !empty($user['email']) ? $user['email'] : "";
        if (empty($userEmail)) {
            echo __('ViewCpanel::message.unauthorized');
            exit;
        }
        if (!$user['roles']['paymentHolidays']['update']) {
            echo __('ViewCpanel::message.permission_denied');
            exit;
        }
        $holiday = $this->paymentHolidayRepo->fetch($id);
        if (!$holiday) {
            abort(404);
        }
        $model = new PaymentHoliday();
        return view('viewcpanel::paymentHolidays.detail', [
            'id' => $id,
            'edit' => true,
            'model' => $model,
            'holiday' => $holiday,
            'updateUrl' => route('viewcpanel::PaymentHolidays.update')
        ]);
    }

    /**
     * Store new payment holidays data into collection
     * @param $request Illuminate\Http\Request
     * @return json
     * */
    public function store(Request $request) {
        Log::channel('cpanel')->info('PaymentHoliday store');
        $user = session('user');
        $userEmail = !empty($user['email']) ? $user['email'] : "";
        if (empty($userEmail)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.unauthorized')
            ];
            Log::channel('cpanel')->info('PaymentHoliday store response: ' . print_r($response, true));
            return response()->json($response);
        }
        if (!$user['roles']['paymentHolidays']['store']) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.permission_denied')
            ];
            Log::channel('cpanel')->info('PaymentHoliday store response: ' . print_r($response, true));
            return response()->json($response);
        }

        $data = json_decode($request->getContent(), true);
        if (!is_array($data)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('PaymentHoliday::messages.errors'),
                'data' => $data
            ];
            return response()->json($response);
        }
        $data['created_by'] = $userEmail;
        $url = config('routes.paymentHolidays.create');
        Log::channel('cpanel')->info('Call Api: ' . $url . ' ' . print_r($data, true));
        //call api
        $result = Http::withBody(json_encode($data), 'application/json')->post($url, $data);
        Log::channel('cpanel')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['data']['_id'])) {
            $dataResult = $result->json();
            $dataResult['data']['targetUrl'] = route('viewcpanel::PaymentHolidays.detail', ['id' => $dataResult['data']['_id']]);
            $response = [
                'status' => Response::HTTP_OK,
                'message' => __('PaymentHoliday::messages.success'),
                'data' => $dataResult['data']
            ];
            return response()->json($response);
        }
        return response()->json($result->json());
    }

    /**
     * Edit existed payment holidays data 
     * @param $request Illuminate\Http\Request
     * @return json
     * */
    public function update(Request $request) {
        Log::channel('cpanel')->info('PaymentHoliday update');
        $user = session('user');
        $userEmail = !empty($user['email']) ? $user['email'] : "";
        if (empty($userEmail)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.unauthorized')
            ];
            Log::channel('cpanel')->info('PaymentHoliday update response: ' . print_r($response, true));
            return response()->json($response);
        }
        if (!$user['roles']['paymentHolidays']['update']) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.permission_denied')
            ];
            Log::channel('cpanel')->info('PaymentHoliday update response: ' . print_r($response, true));
            return response()->json($response);
        }

        $data = json_decode($request->getContent(), true);
        if (!is_array($data)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('PaymentHoliday::messages.errors'),
                'data' => $data
            ];
            return response()->json($response);
        }
        $data['created_by'] = $userEmail;
        $url = config('routes.paymentHolidays.update');
        Log::channel('cpanel')->info('Call Api: ' . $url . ' ' . print_r($data, true));
        //call api
        $result = Http::withBody(json_encode($data), 'application/json')->post($url, $data);
        Log::channel('cpanel')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());
    }

    /**
     * update existed payment holidays status 
     * @param $request Illuminate\Http\Request
     * @return json
     * */
    public function updateStatus(Request $request) {
        Log::channel('cpanel')->info('PaymentHoliday updateStatus');
        $user = session('user');
        $userEmail = !empty($user['email']) ? $user['email'] : "";
        if (empty($userEmail)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.unauthorized')
            ];
            Log::channel('cpanel')->info('PaymentHoliday updateStatus response: ' . print_r($response, true));
            return response()->json($response);
        }
        if (!$user['roles']['paymentHolidays']['update']) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.permission_denied')
            ];
            Log::channel('cpanel')->info('PaymentHoliday updateStatus response: ' . print_r($response, true));
            return response()->json($response);
        }

        $data = json_decode($request->getContent(), true);
        if (!is_array($data)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('PaymentHoliday::messages.errors'),
                'data' => $data
            ];
            return response()->json($response);
        }
        $data['created_by'] = $userEmail;
        $url = config('routes.paymentHolidays.status');
        Log::channel('cpanel')->info('Call Api: ' . $url . ' ' . print_r($data, true));
        //call api
        $result = Http::withBody(json_encode($data), 'application/json')->post($url, $data);
        Log::channel('cpanel')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());
    }

    /**
     * delete soft existed payment holidays 
     * @param $request Illuminate\Http\Request
     * @return json
     * */
    public function delete(Request $request) {
        Log::channel('cpanel')->info('PaymentHoliday delete');
        $user = session('user');
        $userEmail = !empty($user['email']) ? $user['email'] : "";
        if (empty($userEmail)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.unauthorized')
            ];
            Log::channel('cpanel')->info('PaymentHoliday delete response: ' . print_r($response, true));
            return response()->json($response);
        }
        if (!$user['roles']['paymentHolidays']['delete']) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.permission_denied')
            ];
            Log::channel('cpanel')->info('PaymentHoliday delete response: ' . print_r($response, true));
            return response()->json($response);
        }

        $data = json_decode($request->getContent(), true);
        if (!is_array($data)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('PaymentHoliday::messages.errors'),
                'data' => $data
            ];
            return response()->json($response);
        }
        $data['created_by'] = $userEmail;
        $url = config('routes.paymentHolidays.delete');
        Log::channel('cpanel')->info('Call Api: ' . $url . ' ' . print_r($data, true));
        //call api
        $result = Http::withBody(json_encode($data), 'application/json')->post($url, $data);
        Log::channel('cpanel')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());
    }
    
}
