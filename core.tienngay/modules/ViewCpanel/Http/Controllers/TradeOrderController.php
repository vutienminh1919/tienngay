<?php

namespace Modules\ViewCpanel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\MongodbCore\Repositories\Interfaces\TradeOrderRepositoryInterface as TradeOrderRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeItemRepositoryInterface as TradeItemRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeBudgetEstimatesRepositoryInterface as TradeBudgetEstimatesRepository;
use Modules\MongodbCore\Entities\TradeOrder;
use Modules\MongodbCore\Entities\TradeBudgetEstimates;
use CURLFile;
use Illuminate\Support\Arr;

class TradeOrderController extends BaseController
{

    /**
     * Modules\MongodbCore\Repositories\TradeOrderRepository
     * */
    private $tradeOrderRepo;

    /**
     * Modules\MongodbCore\Repositories\TradeItemRepository
     * */
    private $tradeItemRepo;

    /**
     * Modules\MongodbCore\Repositories\TradeBudgetEstimatesRepository
     * */
    private $tradeBudgetEstimatesRepo;

    /**
     * @OA\Info(
     *     version="1.0",
     *     title="API Order Trade Item"
     * )
     */
    public function __construct(
        TradeOrderRepository $tradeOrderRepository,
        TradeItemRepository $tradeItemRepository,
        TradeBudgetEstimatesRepository $tradeBudgetEstimatesRepository
    ) {
        $this->tradeOrderRepo = $tradeOrderRepository;
        $this->tradeItemRepo = $tradeItemRepository;
        $this->tradeBudgetEstimatesRepo = $tradeBudgetEstimatesRepository;
    }

    /**
     * request order trade's item list
     * @return Renderable
     */
    public function index(Request $request)
    {
        Log::channel('cpanel')->info('TradeOrder index');
        $user = session('user');
        $userEmail = !empty($user['email']) ? $user['email'] : "";
        if (empty($userEmail)) {
            echo __('ViewCpanel::message.you_are_not_logged_in');
            exit;
        }
        if (!$user['roles']['tradeMKT']['requestOrder']['index']) {
            echo __('ViewCpanel::message.permission_denied');
            exit;
        }
        $stores = $user['pgds'];
        $storesId = Arr::pluck($stores, '_id');
        $formData = $request->all();
        $tradeOrders = [];
        $limit = 20;
        if (!empty($formData)) {
            if (empty($formData['store_id'])) {
                $formData['store_id'] = $storesId;
            }
            $tradeOrders = $this->tradeOrderRepo->searchByConditions($formData, $limit);
        } else {
            $conditions = [
                'store_id' => ['$in' => $storesId]
            ];
            $tradeOrders = $this->tradeOrderRepo->index($conditions, $limit);
        }
        $model = new TradeOrder();
        $motivatingGoals = TradeOrder::$motivatingGoals;
        $statusAll = TradeOrder::$statusAll;
        $editButton = $user['roles']['tradeMKT']['requestOrder']['editOrderView'];
        return view('viewcpanel::trade.tradeOrder.index', [
            'model' => $model,
            'items' => $tradeOrders,
            'requestOrderUrl' => route('viewcpanel::trade.tradeOrder.requestOrderView'),
            'stores' => $stores,
            'motivatingGoals' => $motivatingGoals,
            'statusAll' => $statusAll,
            'formData' => $formData,
            'tradeBEIndexUrl' => route('viewcpanel::trade.budgetEstimates.index'),
            'shoppingUrl' => route('viewcpanel::trade.publication.list'),
            'cpanelPath' => env('CPANEL_TN_PATH'),
            'editButton' => $editButton,
            'user' => $user
        ]);
    }

    /**
     * request order trade's item
     * @return Renderable
     */
    public function requestOrderView()
    {
        Log::channel('cpanel')->info('TradeOrder requestOrderView');
        $user = session('user');
        $userEmail = !empty($user['email']) ? $user['email'] : "";
        if (empty($userEmail)) {
            echo __('ViewCpanel::message.you_are_not_logged_in');
            exit;
        }
        if (!$user['roles']['tradeMKT']['requestOrder']['requestOrderView']) {
            echo __('ViewCpanel::message.permission_denied');
            exit;
        }
        $stores = $user['pgds'];
        $motivatingGoals = TradeOrder::$motivatingGoals;
        $categories = TradeOrder::$categories;
        $implementationGoals = TradeOrder::$implementationGoals;
        return view('viewcpanel::trade.tradeOrder.requestOrder', [
            'motivatingGoals' => $motivatingGoals,
            'stores' => $stores,
            'categories' => $categories,
            'implementationGoals' => $implementationGoals,
            'getItemsByStoreId' => route('viewcpanel::trade.getItemsByStoreId'),
            'urlUpload' => route('viewcpanel::trade.tradeOrder.uploadPlan'),
            'orderUrl' => route('viewcpanel::trade.tradeOrder.requestOrder'),
            'indexUrl' => route('viewcpanel::trade.tradeOrder.index'),
            'sentFirstApproveUrl' => route('viewcpanel::trade.tradeOrder.sentFirstApprove'),
            'cpanelPath' => env('CPANEL_TN_PATH'),
        ]);
    }

    /**
     * request order trade's item
     * @param $request Illuminate\Http\Request
     * @return json
     *
     */
    public function requestOrder(Request $request) {
        $user = session('user');
        $userEmail = !empty($user['email']) ? $user['email'] : "";
        if (empty($userEmail)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.you_are_not_logged_in')
            ];
            Log::channel('cpanel')->info('TradeOrder requestOrder response: ' . print_r($response, true));
            return response()->json($response);
        }
        if (!$user['roles']['tradeMKT']['requestOrder']['requestOrder']) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.permission_denied')
            ];
            Log::channel('cpanel')->info('TradeOrder requestOrder response: ' . print_r($response, true));
            return response()->json($response);
        }

        $url = config('routes.trade.tradeOrder.requestOrder');
        $dataPost = $request->all();
        $dataPost['created_by'] = $userEmail;
        Log::channel('cpanel')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::withBody(json_encode($dataPost), 'application/json')->post($url, $dataPost);
        Log::channel('cpanel')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));


        if (!empty($result->json()['data']['_id'])) {
            $response = [
                'status' => Response::HTTP_OK,
                'id' => $result->json()['data']['_id'],
                'targetUrl' => route('viewcpanel::trade.tradeOrder.detailOrderView', ['id' => $result->json()['data']['_id']]),
                'cpanelPath' => env('CPANEL_TN_PATH'),
                'cpanelTargetUrl' => env('CPANEL_TN_PATH') . '/trade/requestDetail/'.$result->json()['data']['_id'],
                'message' => 'Tạo yêu cầu ấn phẩm thành công',
            ];
        } else {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => !empty($result->json()['message']) ? $result->json()['message'] : __('ViewCpanel::message.something_errors'),
                'errors' => !empty($result->json()['errors']) ? $result->json()['errors'] : []
            ];
        }
        Log::channel('cpanel')->info('TradeOrder requestOrder response: ' . print_r($response, true));
        return response()->json($response);
    }

    /**
     * request order trade's item and sent ASM to approve
     * @param $request Illuminate\Http\Request
     * @return json
     *
     */
    public function sentFirstApprove(Request $request) {
        $user = session('user');
        $userEmail = !empty($user['email']) ? $user['email'] : "";
        if (empty($userEmail)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.you_are_not_logged_in')
            ];
            Log::channel('cpanel')->info('TradeOrder sentFirstApprove response: ' . print_r($response, true));
            return response()->json($response);
        }
        if (!$user['roles']['tradeMKT']['requestOrder']['sentApprove']) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.permission_denied')
            ];
            Log::channel('cpanel')->info('TradeOrder sentFirstApprove response: ' . print_r($response, true));
            return response()->json($response);
        }

        $url = config('routes.trade.tradeOrder.requestOrder');
        $dataPost = $request->all();
        $dataPost['created_by'] = $userEmail;
        Log::channel('cpanel')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::withBody(json_encode($dataPost), 'application/json')->post($url, $dataPost);
        Log::channel('cpanel')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));


        if (!empty($result->json()['data']['_id'])) {
            $id = $result->json()['data']['_id'];
            $url = config('routes.trade.tradeOrder.updateProgress');
            $dataPost = [
                'id' => $id,
                'created_by' => $userEmail,
                'status' => TradeOrder::STATUS_SENT_APPROVE,
            ];
            Log::channel('cpanel')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
            //call api
            $result = Http::withBody(json_encode($dataPost), 'application/json')->post($url, $dataPost);
            Log::channel('cpanel')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));

            if ($result['status'] == Response::HTTP_OK) {
                $response = [
                    'id' => $id,
                    'targetUrl' => route('viewcpanel::trade.tradeOrder.detailOrderView', ['id' => $id]),
                    'cpanelPath' => env('CPANEL_TN_PATH'),
                    'cpanelTargetUrl' => env('CPANEL_TN_PATH') . '/trade/requestDetail/'.$id,
                    'status' => Response::HTTP_OK,
                    'message' => 'Gửi duyệt yêu cầu ấn phẩm thành công.'
                ];
            } else {
                $response = [
                    'status' => Response::HTTP_BAD_REQUEST,
                    'message' => __('ViewCpanel::message.something_errors')
                ];
            }
            Log::channel('cpanel')->info('TradeOrder sentFirstApprove response: ' . print_r($response, true));
            return response()->json($response);

        } else {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => !empty($result->json()['message']) ? $result->json()['message'] : __('ViewCpanel::message.something_errors'),
                'errors' => !empty($result->json()['errors']) ? $result->json()['errors'] : []
            ];
        }
        Log::channel('cpanel')->info('TradeOrder sentFirstApprove response: ' . print_r($response, true));
        return response()->json($response);
    }

    /**
     * Upload plan file
     * @param $request Illuminate\Http\Request
     * @return json
     * */
    public function uploadPlan(Request $request) {
        if($_FILES['file']['size'] > 10000000) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => 'Kích thước file không vượt quá 10MB'
            ];
            return response()->json($response);
        }
        $serviceUpload = env("URL_SERVICE_UPLOAD");
        Log::channel('cpanel')->info('TradeOrder requestOrder serviceUpload: ' . $serviceUpload);
        Log::channel('cpanel')->info('TradeOrder requestOrder serviceUpload: ' . print_r($_FILES, true));
        $cfile = new CURLFile($_FILES['file']["tmp_name"],$_FILES['file']["type"],$_FILES['file']["name"]);
        Log::channel('cpanel')->info('TradeOrder requestOrder cfile: ' . print_r($cfile, true));
        $post = array('avatar'=> $cfile);
        Log::channel('cpanel')->info('TradeOrder requestOrder post: ' . print_r($post, true));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$serviceUpload);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec ($ch);
        curl_close ($ch);
        $result1 = json_decode($result);
        if ($result1->path) {
            $response = [
                'status' => Response::HTTP_OK,
                'message' => __('ViewCpanel::message.success'),
                'path' => $result1->path,
                'raw_name' => $_FILES['file']['name']
            ];
            return response()->json($response);
        } else {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.errors')
            ];
            return response()->json($response);
        }
    }

    /**
     * detail order trade's item
     * @return Renderable
     */
    public function detailOrderView($id)
    {
        Log::channel('cpanel')->info('TradeOrder detailOrderView');
        $user = session('user');
        $userEmail = !empty($user['email']) ? $user['email'] : "";
        if (empty($userEmail)) {
            echo __('ViewCpanel::message.you_are_not_logged_in');
            exit;
        }
        if (!$user['roles']['tradeMKT']['requestOrder']['detailOrderView']) {
            echo __('ViewCpanel::message.permission_denied');
            exit;
        }
        $tradeOrder = $this->tradeOrderRepo->fetch($id);
        if (!$tradeOrder) {
            abort(404);
        }
        $budgetEstimates = $this->tradeBudgetEstimatesRepo->newAll();
        $statusLabel = TradeOrder::statusLabel($tradeOrder['status'], $tradeOrder['progress']);
        $items = $this->tradeItemRepo->getItemsByStoreId($tradeOrder['store_id']);
        $requestAllotment = $this->tradeOrderRepo->fetchRequestAllotment($id);
        $logsAllotment = $this->tradeOrderRepo->fetchLogsAllotment($id);
        $stores = $user['pgds'];
        $motivatingGoals = TradeOrder::$motivatingGoals;
        $categories = TradeOrder::$categories;
        $implementationGoals = TradeOrder::$implementationGoals;
        $itemsTableView = (
            $user['roles']['tradeMKT']['requestOrder']['itemsTableView'] && 
            $tradeOrder['progress'] >= TradeOrder::PROGRESS_HCNS_BUYING
        );
        $editButton = false;
        $cancelButton = true;
        $approvedButton = false;
        $sentApproveButton = false;
        $returnedButton = false;
        $addBudgetEstimates = false;
        $removeBudgetEstimates = false;
        $showAllAllotmentItems = $user['roles']['tradeMKT']['requestOrder']['showAllAllotmentItems'];
        $allotmentConfirmedBtn = $user['roles']['tradeMKT']['requestOrder']['allotmentConfirmedBtn'];
        $logsAllotmentTable = $tradeOrder['progress'] > TradeOrder::PROGRESS_CEO;
        $progress = $tradeOrder['progress'];
        $budgetDetail = null;
        if (
            $tradeOrder['progress'] == TradeOrder::PROGRESS_GDKD_MKT && 
            $user['roles']['tradeMKT']['tradeBudgetEstimates']['updateBudgetEstimateStatus']
        ) {
            if ($tradeOrder['budget_estimates'] == TradeOrder::BUDGET_ESTIMATES_ADDED) {
                $budgetDetail = $this->tradeBudgetEstimatesRepo->fetch($tradeOrder[TradeOrder::BUDGET_ESTIMATES_ID]);
                if ($budgetDetail && (
                    $budgetDetail[TradeBudgetEstimates::PROGRESS] == TradeBudgetEstimates::PROGRESS_CREATE_NEW &&
                    $budgetDetail[TradeBudgetEstimates::STATUS] != TradeBudgetEstimates::STATUS_WAIT_APPROVE
                )) {
                    $removeBudgetEstimates = true;
                }

                if ($budgetDetail[TradeBudgetEstimates::STATUS] == TradeBudgetEstimates::STATUS_RETURNED) {

                }
            } else {
                $addBudgetEstimates = true;
            }
            
        }


        switch ($tradeOrder['status']) {
            case TradeOrder::STATUS_NEW:
                $editButton = true;
                $sentApproveButton = true;
                $approvedButton = false;
                $returnedButton = false;
                $cancelButton = false;
                break;
            case TradeOrder::STATUS_WAIT_APPROVE:
                $editButton = false;
                $sentApproveButton = false;
                $approvedButton = true;
                $returnedButton = true;
                $cancelButton = true;
                break;
            case TradeOrder::STATUS_RETURNED:
                $editButton = true;
                $sentApproveButton = true;
                $approvedButton = false;
                $returnedButton = false;
                $cancelButton = true;
                $addBudgetEstimates = false;
                $removeBudgetEstimates = false;
                $progress = $progress - 1;
                break;
            case TradeOrder::STATUS_APPROVED:
                $editButton = false;
                $sentApproveButton = true;
                $approvedButton = false;
                $returnedButton = false;
                break;
            case TradeOrder::STATUS_SENT_APPROVE:
                $editButton = false;
                $sentApproveButton = true;
                $approvedButton = false;
                $returnedButton = false;
                break;
            case TradeOrder::STATUS_CANCLED:
                $editButton = false;
                $cancelButton = false;
                $approvedButton = false;
                $sentApproveButton = false;
                $returnedButton = false;
                $addBudgetEstimates = false;
                $removeBudgetEstimates = false;
                break;
        }
        if ($tradeOrder['progress'] > TradeOrder::PROGRESS_RSM) {
            $cancelButton = false;
            $approvedButton = false;
            $sentApproveButton = false;
            $returnedButton = false;
        }

        if ($tradeOrder['progress'] == TradeOrder::PROGRESS_GDKD_MKT) {
            if ($tradeOrder['status'] == TradeOrder::STATUS_WAIT_APPROVE) {
                $cancelButton = true;
                $returnedButton = true;
            } else if ($tradeOrder['status'] == TradeOrder::STATUS_RETURNED) {
                $sentApproveButton = true;
                $cancelButton = true;
            }
        }

        if (
            $budgetDetail && 
            $budgetDetail[TradeBudgetEstimates::PROGRESS] >= TradeBudgetEstimates::PROGRESS_GDKD_MKT
        ) {
            $cancelButton = false;
            $returnedButton = false;
        }

        $editButton = $editButton && $user['roles']['tradeMKT']['requestOrder']['editOrderView'] && (
            ($user['isTPGD'] && $progress == TradeOrder::PROGRESS_PGD_CREATE) ||
            ($user['isASM'] && $progress == TradeOrder::PROGRESS_ASM) ||
            ($user['isRSM'] && $progress == TradeOrder::PROGRESS_RSM) || 
            ((int)$user['is_superadmin'] == 1)
        );
        $cancelButton = $cancelButton && $user['roles']['tradeMKT']['requestOrder']['canceled'] && (
            ($user['isTPGD'] && $progress == TradeOrder::PROGRESS_PGD_CREATE) ||
            ($user['isASM'] && $progress == TradeOrder::PROGRESS_ASM) ||
            ($user['isRSM'] && $progress == TradeOrder::PROGRESS_RSM) ||
            ($user['isTradeMKT'] && $progress == TradeOrder::PROGRESS_GDKD_MKT) ||
            ((int)$user['is_superadmin'] == 1)
        );
        $approvedButton = $approvedButton && $user['roles']['tradeMKT']['requestOrder']['approved'] && (
            ($user['isASM'] && $progress == TradeOrder::PROGRESS_ASM) ||
            ($user['isRSM'] && $progress == TradeOrder::PROGRESS_RSM) ||
            ((int)$user['is_superadmin'] == 1)
        );
        $sentApproveButton = $sentApproveButton && $user['roles']['tradeMKT']['requestOrder']['sentApprove'] && (
            ($user['isTPGD'] && $progress == TradeOrder::PROGRESS_PGD_CREATE) ||
            ($user['isASM'] && $progress == TradeOrder::PROGRESS_ASM) ||
            ($user['isRSM'] && $progress == TradeOrder::PROGRESS_RSM) ||
            ((int)$user['is_superadmin'] == 1)
        );
        $returnedButton = $returnedButton && $user['roles']['tradeMKT']['requestOrder']['returned'] && (
            ($user['isASM'] && $progress == TradeOrder::PROGRESS_ASM) ||
            ($user['isRSM'] && $progress == TradeOrder::PROGRESS_RSM) ||
            ($user['isTradeMKT'] && $progress == TradeOrder::PROGRESS_GDKD_MKT) ||
            ((int)$user['is_superadmin'] == 1)
        );
        $addBudgetEstimates = $addBudgetEstimates && $user['roles']['tradeMKT']['tradeBudgetEstimates']['updateBudgetEstimateStatus'];
        $removeBudgetEstimates = $removeBudgetEstimates && $user['roles']['tradeMKT']['tradeBudgetEstimates']['updateBudgetEstimateStatus'];

        return view('viewcpanel::trade.tradeOrder.detail', [
            'motivatingGoals' => $motivatingGoals,
            'stores' => $stores,
            'categories' => $categories,
            'implementationGoals' => $implementationGoals,
            'roles' => $user['roles']['tradeMKT']['requestOrder'],
            'getItemsByStoreId' => route('viewcpanel::trade.getItemsByStoreId'),
            'urlUpload' => route('viewcpanel::trade.tradeOrder.uploadPlan'),
            'orderUrl' => route('viewcpanel::trade.tradeOrder.requestOrder'),
            'editUrl' => route('viewcpanel::trade.tradeOrder.editOrderView', ['id' => $id]),
            'indexUrl' => route('viewcpanel::trade.tradeOrder.index'),
            'sentFirstApproveUrl' => route('viewcpanel::trade.tradeOrder.sentFirstApprove'),
            'updateStatusUrl' => route('viewcpanel::trade.tradeOrder.updateStatus', ['id' => $id]),
            'tradeOrder' => $tradeOrder,
            'items' => $items,
            'statusLabel' => $statusLabel,
            'editButton' => $editButton,
            'approvedButton' => $approvedButton,
            'sentApproveButton' => $sentApproveButton,
            'returnedButton' => $returnedButton,
            'cancelButton' => $cancelButton,
            'itemsTableView' => $itemsTableView,
            'addBudgetEstimates' => $addBudgetEstimates,
            'removeBudgetEstimates' => $removeBudgetEstimates,
            'updateBudgetEstimateStatusUrl' => route('viewcpanel::trade.budgetEstimates.updateBudgetEstimateStatus', ['id' => $id]),
            'budgetEstimates' => $budgetEstimates,
            'logsAllotmentTable' => $logsAllotmentTable,
            'logsAllotment' => $logsAllotment,
            'confirmedAllotmentUrl' => route('viewcpanel::trade.tradeOrder.confirmedAllotment', ['id' => $id]),
            'requestAllotment' => $requestAllotment,
            'cpanelPath' => env('CPANEL_TN_PATH'),
            'cpanelEditUrl' => env('CPANEL_TN_PATH') . '/trade/requestEdit/'.$id,
            'cpanelIndexUrl' => env('CPANEL_TN_PATH') . '/trade/requestIndex/',
            'showAllAllotmentItems' => $showAllAllotmentItems,
            'allotmentConfirmedBtn' => $allotmentConfirmedBtn
        ]);
    }

    /**
     * sent to approve
     * @param $id string
     * @return json
     *
     */
    public function updateStatus($id, Request $request) {
        $user = session('user');
        $userEmail = !empty($user['email']) ? $user['email'] : "";
        if (empty($userEmail)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.you_are_not_logged_in')
            ];
            Log::channel('cpanel')->info('TradeOrder updateStatus response: ' . print_r($response, true));
            return response()->json($response);
        }

        $dataPost = $request->all();
        if (empty($dataPost['action'])) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.errors')
            ];
            Log::channel('cpanel')->info('TradeOrder updateStatus response: ' . print_r($response, true));
            return response()->json($response);
        }
        $status = 0;
        $note = !empty($dataPost['note']) ? $dataPost['note'] : "";
        if (
            empty($note) && (
            ($dataPost['action'] == 'returned') || ($dataPost['action'] == 'canceled'))
        ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Lý do không được để trống"
            ];
            Log::channel('cpanel')->info('TradeOrder updateStatus response: ' . print_r($response, true));
            return response()->json($response);
        }
        $message = __('ViewCpanel::message.success');
        switch ($dataPost['action']) {
            case 'sentApprove':
                $status = TradeOrder::STATUS_SENT_APPROVE;
                $message = __('ViewCpanel::message.sent_approve_success');
                break;
            case 'approved':
                $status = TradeOrder::STATUS_APPROVED;
                $message = __('ViewCpanel::message.approved_success');
                break;
            case 'returned':
                $status = TradeOrder::STATUS_RETURNED;
                $message = __('ViewCpanel::message.returned_success');
                break;
            case 'canceled':
                $status = TradeOrder::STATUS_CANCLED;
                $message = __('ViewCpanel::message.canceled_success');
                break;
        }
        $url = config('routes.trade.tradeOrder.updateProgress');
        $dataPost = [
            'id' => $id,
            'created_by' => $userEmail,
            'status' => $status,
            'note' => $note
        ];
        Log::channel('cpanel')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::withBody(json_encode($dataPost), 'application/json')->post($url, $dataPost);
        Log::channel('cpanel')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));

        if ($result['status'] == Response::HTTP_OK) {
            $response = [
                'id' => $id,
                'targetUrl' => route('viewcpanel::trade.tradeOrder.detailOrderView', ['id' => $id]),
                'cpanelPath' => env('CPANEL_TN_PATH'),
                'cpanelTargetUrl' => env('CPANEL_TN_PATH') . '/trade/requestDetail/'.$id,
                'status' => Response::HTTP_OK,
                'message' => $message
            ];
        } else {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => !empty($result['message']) ? $result['message'] : __('ViewCpanel::message.something_errors')
            ];
        }
        Log::channel('cpanel')->info('TradeOrder updateStatus response: ' . print_r($response, true));
        return response()->json($response);
    }

    /**
     * edit order trade's item
     * @return Renderable
     */
    public function editOrderView($id)
    {
        Log::channel('cpanel')->info('TradeOrder editOrderView');
        $user = session('user');
        $userEmail = !empty($user['email']) ? $user['email'] : "";
        if (empty($userEmail)) {
            echo __('ViewCpanel::message.you_are_not_logged_in');
            exit;
        }
        if (!$user['roles']['tradeMKT']['requestOrder']['editOrderView']) {
            echo __('ViewCpanel::message.permission_denied');
            exit;
        }
        $tradeOrder = $this->tradeOrderRepo->fetch($id);
        if (!$tradeOrder) {
            abort(404);
        }
        $statusLabel = TradeOrder::statusLabel($tradeOrder['status'], $tradeOrder['progress']);
        $items = $this->tradeItemRepo->getItemsByStoreId($tradeOrder['store_id']);
        $stores = $user['pgds'];
        $motivatingGoals = TradeOrder::$motivatingGoals;
        $categories = TradeOrder::$categories;
        $implementationGoals = TradeOrder::$implementationGoals;
        return view('viewcpanel::trade.tradeOrder.edit', [
            'motivatingGoals' => $motivatingGoals,
            'stores' => $stores,
            'categories' => $categories,
            'implementationGoals' => $implementationGoals,
            'roles' => $user['roles']['tradeMKT']['requestOrder'],
            'getItemsByStoreId' => route('viewcpanel::trade.getItemsByStoreId'),
            'urlUpload' => route('viewcpanel::trade.tradeOrder.uploadPlan'),
            'updateUrl' => route('viewcpanel::trade.tradeOrder.updateOrder', ['id' => $id]),
            'indexUrl' => route('viewcpanel::trade.tradeOrder.index'),
            'sentFirstApproveUrl' => route('viewcpanel::trade.tradeOrder.sentFirstApprove'),
            'updateStatusUrl' => route('viewcpanel::trade.tradeOrder.updateStatus', ['id' => $id]),
            'tradeOrder' => $tradeOrder,
            'items' => $items,
            'statusLabel' => $statusLabel,
            'cpanelPath' => env('CPANEL_TN_PATH'),
            'cpanelIndexUrl' => env('CPANEL_TN_PATH') . '/trade/requestIndex/',
        ]);
    }

    /**
     * update trade's request order
     * @param $request Illuminate\Http\Request
     * @return json
     *
     */
    public function updateOrder($id, Request $request) {
        $user = session('user');
        $userEmail = !empty($user['email']) ? $user['email'] : "";
        if (empty($userEmail)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.you_are_not_logged_in')
            ];
            Log::channel('cpanel')->info('TradeOrder updateOrder response: ' . print_r($response, true));
            return response()->json($response);
        }
        if (!$user['roles']['tradeMKT']['requestOrder']['updateOrder']) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.permission_denied')
            ];
            Log::channel('cpanel')->info('TradeOrder updateOrder response: ' . print_r($response, true));
            return response()->json($response);
        }

        $url = config('routes.trade.tradeOrder.updateOrder');
        $dataPost = $request->all();
        $dataPost['created_by'] = $userEmail;
        $dataPost['id'] = $id;
        Log::channel('cpanel')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::withBody(json_encode($dataPost), 'application/json')->post($url, $dataPost);
        Log::channel('cpanel')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));


        if (!empty($result->json()['status']) && $result->json()['status'] == 200) {
            $response = [
                'status' => Response::HTTP_OK,
                'id' => $id,
                'targetUrl' => route('viewcpanel::trade.tradeOrder.detailOrderView', ['id' => $id]),
                'cpanelPath' => env('CPANEL_TN_PATH'),
                'cpanelTargetUrl' => env('CPANEL_TN_PATH') . '/trade/requestDetail/'.$id,
                'message' => 'Cập nhật yêu cầu ấn phẩm thành công'
            ];
            if (isset($dataPost['action']) && $dataPost['action'] == 'sentRequest') {
                Log::channel('cpanel')->info('TradeOrder updateOrder begin sent approve ');
                $url = config('routes.trade.tradeOrder.updateProgress');
                $dataPost = [
                    'id' => $id,
                    'created_by' => $userEmail,
                    'status' => TradeOrder::STATUS_SENT_APPROVE,
                ];
                Log::channel('cpanel')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
                //call api
                $result = Http::withBody(json_encode($dataPost), 'application/json')->post($url, $dataPost);
                Log::channel('cpanel')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
                if ($result['status'] !== Response::HTTP_OK) {
                    $response = [
                        'status' => Response::HTTP_BAD_REQUEST,
                        'message' => __('ViewCpanel::message.something_errors')
                    ];
                } else {
                    $response['message'] = 'Gửi duyệt yêu cầu ấn phẩm thành công.';
                }
            }
        } else {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => !empty($result->json()['message']) ? $result->json()['message'] : __('ViewCpanel::message.something_errors'),
                'errors' => !empty($result->json()['errors']) ? $result->json()['errors'] : []
            ];
        }
        Log::channel('cpanel')->info('TradeOrder updateOrder response: ' . print_r($response, true));
        return response()->json($response);
    }

    /**
     * delete trade's request order
     * @param $request Illuminate\Http\Request
     * @return json
     *
     */
    public function deleteOrder($id, Request $request) {
        $user = session('user');
        $userEmail = !empty($user['email']) ? $user['email'] : "";
        if (empty($userEmail)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.you_are_not_logged_in')
            ];
            Log::channel('cpanel')->info('TradeOrder deleteOrder response: ' . print_r($response, true));
            return response()->json($response);
        }
        if (!$user['roles']['tradeMKT']['requestOrder']['deleteOrder']) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.permission_denied')
            ];
            Log::channel('cpanel')->info('TradeOrder deleteOrder response: ' . print_r($response, true));
            return response()->json($response);
        }

        $url = config('routes.trade.tradeOrder.deleteOrder');
        $dataPost = $request->all();
        $dataPost['created_by'] = $userEmail;
        $dataPost['id'] = $id;
        Log::channel('cpanel')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::withBody(json_encode($dataPost), 'application/json')->post($url, $dataPost);
        Log::channel('cpanel')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == 200) {
            $response = [
                'status' => Response::HTTP_OK,
                'message' => __('ViewCpanel::message.success')
            ];
        } else {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => !empty($result->json()['message']) ? $result->json()['message'] : __('ViewCpanel::message.something_errors')
            ];
        }
        Log::channel('cpanel')->info('TradeOrder deleteOrder response: ' . print_r($response, true));
        return response()->json($response);
    }

    /**
     * confirm item's allotment then put item into storage
     * @param $id String
     * @param $request Illuminate\Http\Request
     * @return json
     *
     */
    public function confirmedAllotment($id, Request $request) {
        $user = session('user');
        $userEmail = !empty($user['email']) ? $user['email'] : "";
        if (empty($userEmail)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.you_are_not_logged_in')
            ];
            Log::channel('cpanel')->info('TradeOrder confirmedAllotment response: ' . print_r($response, true));
            return response()->json($response);
        }
        if (!$user['roles']['tradeMKT']['requestOrder']['confirmedAllotment']) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.permission_denied')
            ];
            Log::channel('cpanel')->info('TradeOrder confirmedAllotment response: ' . print_r($response, true));
            return response()->json($response);
        }
        $url = config('routes.trade.tradeOrder.confirmedAllotment');
        $dataPost = $request->all();
        $dataPost['created_by'] = $userEmail;
        $dataPost['id'] = $id;
        Log::channel('cpanel')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::withBody(json_encode($dataPost), 'application/json')->post($url, $dataPost);
        Log::channel('cpanel')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == 200) {
            $response = [
                'status' => Response::HTTP_OK,
                'message' => __('ViewCpanel::message.success')
            ];
        } else {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => !empty($result->json()['message']) ? $result->json()['message'] : __('ViewCpanel::message.something_errors')
            ];
        }
        Log::channel('cpanel')->info('TradeOrder confirmedAllotment response: ' . print_r($response, true));
        return response()->json($response);
    }

}
