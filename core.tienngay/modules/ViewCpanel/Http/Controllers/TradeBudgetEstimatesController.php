<?php

namespace Modules\ViewCpanel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Modules\MongodbCore\Repositories\Interfaces\TradeOrderRepositoryInterface as TradeOrderRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeBudgetEstimatesRepositoryInterface as TradeBudgetEstimatesRepository;
use Modules\MongodbCore\Entities\TradeOrder;
use Modules\MongodbCore\Entities\TradeBudgetEstimates;
use Illuminate\Support\Arr;
use Modules\MongodbCore\Repositories\Interfaces\AreaRepositoryInterface as AreaRepo;
use Modules\MongodbCore\Repositories\Interfaces\StoreRepositoryInterface as StoreRepo;

class TradeBudgetEstimatesController extends BaseController
{

    /**
     * Modules\MongodbCore\Repositories\TradeOrderRepository
     * */
    private $tradeOrderRepo;

    /**
     * Modules\MongodbCore\Repositories\TradeBudgetEstimatesRepository
     * */
    private $budgetEstimatesRepo;

    /**
     * Modules\MongodbCore\Repositories\AreaRepository
     * */
    private $areaRepo;

    /**
     * Modules\MongodbCore\Repositories\StoreRepository
     * */
    private $storeRepo;

    /**
     * @OA\Info(
     *     version="1.0",
     *     title="API Order Trade Item"
     * )
     */
    public function __construct(
        TradeOrderRepository $tradeOrderRepository,
        TradeBudgetEstimatesRepository $tradeBudgetEstimatesRepository,
        AreaRepo           $areaRepo,
        StoreRepo          $storeRepo
    ) {
        $this->tradeOrderRepo = $tradeOrderRepository;
        $this->budgetEstimatesRepo = $tradeBudgetEstimatesRepository;
        $this->areaRepo = $areaRepo;
        $this->storeRepo = $storeRepo;
    }

    /**
     * budget estimates list
     * @return Renderable
     */
    public function index(Request $request)
    {
        Log::channel('cpanel')->info('TradeBudgetEstimates index');
        $user = session('user');
        $userEmail = !empty($user['email']) ? $user['email'] : "";
        if (empty($userEmail)) {
            echo __('ViewCpanel::message.you_are_not_logged_in');
            exit;
        }
        if (!$user['roles']['tradeMKT']['tradeBudgetEstimates']['index']) {
            echo __('ViewCpanel::message.permission_denied');
            exit;
        }
        $formData = $request->all();
        $tradeOrders = [];
        $limit = 20;
        $budgetEstimates = $this->budgetEstimatesRepo->searchByConditions($formData, $limit);
        $model = new TradeBudgetEstimates();
        $statusAll = TradeBudgetEstimates::$statusAll;
        $deletebtn = $user['roles']['tradeMKT']['tradeBudgetEstimates']['deletebtn'];
        $beModel = new TradeBudgetEstimates();
        return view('viewcpanel::trade.budgetEstimates.index', [
            'model' => $model,
            'items' => $budgetEstimates,
            'statusAll' => $statusAll,
            'formData' => $formData,
            'tradeOrderIndexUrl' => route('viewcpanel::trade.tradeOrder.index'),
            'shoppingUrl' => route('viewcpanel::trade.publication.list'),
            'cpanelPath' => env('CPANEL_TN_PATH'),
            'deletebtn' => $deletebtn,
            'beModel' => $beModel
        ]);
    }

    /**
     * request order trade's item list
     * @return Renderable
     */
    public function detail($id)
    {
        Log::channel('cpanel')->info('TradeBudgetEstimates detail');
        $user = session('user');
        $userEmail = !empty($user['email']) ? $user['email'] : "";
        if (empty($userEmail)) {
            echo __('ViewCpanel::message.you_are_not_logged_in');
            exit;
        }
        if (!$user['roles']['tradeMKT']['tradeBudgetEstimates']['detail']) {
            echo __('ViewCpanel::message.permission_denied');
            exit;
        }
        $budgetEstimates = $this->budgetEstimatesRepo->fetch($id);
        if (!$budgetEstimates) {
            abort(404);
        }
        $storeKV = $this->areaRepo->groupKV();
        $storeAll = $this->areaRepo->groupKV();
        $detail = $this->tradeOrderRepo->calculateBudgetEstimate($id, $storeKV, $this->storeRepo);
        $comments = $this->budgetEstimatesRepo->fetchComment($id);
        $statusLabel = TradeBudgetEstimates::statusLabel($budgetEstimates['status'], $budgetEstimates['progress']);
        if (!empty($comments)) {
            $comments = $comments[0]['comments'];
        }
        $cancelButton = $user['roles']['tradeMKT']['tradeBudgetEstimates']['cancelButton'];
        $cfoApprovedButton = false;
        $sentApproveButton = false;
        $returnedButton = false;
        $ccoApprovedButton = false;
        $mktApprovedButton = false;
        $ceoApprovedButton = false;
        $editCusGoalBtn = false;
        $addNoteBtn = false;
        switch ($budgetEstimates[TradeBudgetEstimates::STATUS]) {
            case TradeBudgetEstimates::STATUS_NEW:
                $sentApproveButton = true;
                $cancelButton = $cancelButton && true;
                $editCusGoalBtn = true;
                break;
            case TradeBudgetEstimates::STATUS_WAIT_APPROVE:
                if ($budgetEstimates[TradeBudgetEstimates::PROGRESS] == TradeBudgetEstimates::PROGRESS_GDKD_MKT) {
                    if (empty($budgetEstimates[TradeBudgetEstimates::IS_CCO_ACCEPT])) {
                        $ccoApprovedButton = true;
                    }
                    if (empty($budgetEstimates[TradeBudgetEstimates::IS_MKT_ACCEPT])) {
                        $mktApprovedButton = true;
                    }
                    $returnedButton = true;
                } else if ($budgetEstimates[TradeBudgetEstimates::PROGRESS] == TradeBudgetEstimates::PROGRESS_CFO) {
                    $cfoApprovedButton = true;
                    $returnedButton = true;
                } else if ($budgetEstimates[TradeBudgetEstimates::PROGRESS] == TradeBudgetEstimates::PROGRESS_CEO) {
                    $ceoApprovedButton = true;
                }
                $cancelButton = $cancelButton && true;
                break;
            case TradeBudgetEstimates::STATUS_RETURNED:
                $sentApproveButton = true;
                $cancelButton = false;
                $editCusGoalBtn = true;
                break;
            case TradeBudgetEstimates::STATUS_SENT_APPROVE:
                $sentApproveButton = true;
                $cancelButton = $cancelButton && true;
                break;
        }
        $role = $user['roles']['tradeMKT']['tradeBudgetEstimates'];
        $progress = $budgetEstimates['progress'];
        $cancelButton      = $cancelButton && ( 
            $progress !== TradeBudgetEstimates::PROGRESS_GDKD_MKT && 
            $progress !== TradeBudgetEstimates::PROGRESS_CFO
        );
        $cfoApprovedButton = $cfoApprovedButton && $role['cfoApprovedButton'];
        $sentApproveButton = $sentApproveButton && $role['sentApproveButton'];
        $ccoApprovedButton = $ccoApprovedButton && $role['ccoApprovedButton'];
        $mktApprovedButton = $mktApprovedButton && $role['mktApprovedButton'];
        $ceoApprovedButton = $ceoApprovedButton && $role['ceoApprovedButton'];
        $returnedButton    = $returnedButton && $role['returnedButton'] && ($cfoApprovedButton || $ccoApprovedButton || $mktApprovedButton || $ceoApprovedButton);
        $editCusGoalBtn = $editCusGoalBtn && $role['editCusGoalBtn'];
        $addNoteBtn = $role['addNoteBtn'];
        $tradeOrders = $this->tradeOrderRepo->fetchItemsByBudgetEstimateId($id);

        return view('viewcpanel::trade.budgetEstimates.detail', [
            'detail' => $detail,
            'budgetEstimates' => $budgetEstimates,
            'updateCustomerGoalUrl' => route('viewcpanel::trade.budgetEstimates.updateCustomerGoal', ['id' => $id]),
            'comments' => $comments,
            'addCommentUrl' => route('viewcpanel::trade.budgetEstimates.addComment', ['id' => $id]),
            'updateProgressUrl' => route('viewcpanel::trade.budgetEstimates.updateProgress', ['id' => $id]),
            'ccoApprovedButton' => $ccoApprovedButton,
            'mktApprovedButton' => $mktApprovedButton,
            'sentApproveButton' => $sentApproveButton,
            'returnedButton' => $returnedButton,
            'cancelButton' => $cancelButton,
            'statusLabel'  => $statusLabel,
            'cfoApprovedButton' => $cfoApprovedButton,
            'ceoApprovedButton' => $ceoApprovedButton,
            'editCusGoalBtn' => $editCusGoalBtn,
            'addNoteBtn' => $addNoteBtn,
            'items' => $tradeOrders,
            'tradeOrderModel' => new TradeOrder(),
            'cpanelPath' => env('CPANEL_TN_PATH'),
            'tradeBEIndexUrl' => route('viewcpanel::trade.budgetEstimates.index')
        ]);
    }

    /**
     * update budget estimates status
     * @param $id string
     * @param $request Illuminate\Http\Request;
     * @return json
     * 
     */
    public function updateBudgetEstimateStatus($id, Request $request) {
        $user = session('user');
        $userEmail = !empty($user['email']) ? $user['email'] : "";
        if (empty($userEmail)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.you_are_not_logged_in')
            ];
            Log::channel('cpanel')->info('TradeBudgetEstimates updateBudgetEstimateStatus response: ' . print_r($response, true));
            return response()->json($response);
        }

        if (!$user['roles']['tradeMKT']['tradeBudgetEstimates']['updateBudgetEstimateStatus']) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.permission_denied')
            ];
            Log::channel('cpanel')->info('TradeBudgetEstimates updateBudgetEstimateStatus response: ' . print_r($response, true));
            return response()->json($response);
        }

        $dataPost = $request->all();
        if (empty($dataPost['action'])) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.errors')
            ];
            Log::channel('cpanel')->info('TradeBudgetEstimates updateBudgetEstimateStatus response: ' . print_r($response, true));
            return response()->json($response);
        }
        $status = 0;
        $message = __('ViewCpanel::message.success');
        switch ($dataPost['action']) {
            case 'add':
                $status = TradeOrder::BUDGET_ESTIMATES_ADDED;
                $message = __('ViewCpanel::message.add_budget_estimates_success');
                $url = config('routes.trade.budgetEstimates.addBudgetEstimate');
                break;
            case 'remove':
                $status = TradeOrder::BUDGET_ESTIMATES_REMOVED;
                $message = __('ViewCpanel::message.remove_budget_estimates_success');
                $url = config('routes.trade.budgetEstimates.removeBudgetEstimate');
                $targetUrl = route('viewcpanel::trade.tradeOrder.detailOrderView', ['id' => $id]);
                break;
        }
        if ($status == 0) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.undefined_value')
            ];
            Log::channel('cpanel')->info('TradeBudgetEstimates updateBudgetEstimateStatus response: ' . print_r($response, true));
            return response()->json($response);
        }
        if (empty($url)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.something_errors')
            ];
            Log::channel('cpanel')->info('TradeBudgetEstimates updateStatus response: ' . print_r($response, true));
            return response()->json($response);
        }
        $dataPost['orderId'] = $id;
        $dataPost['created_by'] = $userEmail;
        $dataPost['status'] = $status;
        Log::channel('cpanel')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::withBody(json_encode($dataPost), 'application/json')->post($url, $dataPost);
        Log::channel('cpanel')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        if ($dataPost['action'] == 'add' && !empty($result['id'])) {
            $targetUrl = route('viewcpanel::trade.budgetEstimates.detail', ['id' => $result['id']]);
        }
        if ($result['status'] == Response::HTTP_OK) {
            $response = [
                'targetUrl' => $targetUrl,
                'status' => Response::HTTP_OK,
                'message' => $message
            ];
        } else {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => !empty($result['message']) ? $result['message'] : __('ViewCpanel::message.something_errors')
            ];
        }
        Log::channel('cpanel')->info('TradeBudgetEstimates updateStatus response: ' . print_r($response, true));
        return response()->json($response);
    }

    /**
     * update budget estimates status
     * @param $id string
     * @param $request Illuminate\Http\Request;
     * @return json
     * 
     */
    public function updateCustomerGoal($id, Request $request) {
        $user = session('user');
        $userEmail = !empty($user['email']) ? $user['email'] : "";
        if (empty($userEmail)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.you_are_not_logged_in')
            ];
            Log::channel('cpanel')->info('TradeBudgetEstimates updateCustomerGoal response: ' . print_r($response, true));
            return response()->json($response);
        }

        if (!$user['roles']['tradeMKT']['tradeBudgetEstimates']['updateCustomerGoal']) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.permission_denied')
            ];
            Log::channel('cpanel')->info('TradeBudgetEstimates updateCustomerGoal response: ' . print_r($response, true));
            return response()->json($response);
        }

        $dataPost = $request->all();
        $dataPost['budgetEstimateId'] = $id;
        $dataPost['created_by'] = $userEmail;
        $url = config('routes.trade.budgetEstimates.updateCustomerGoal');
        Log::channel('cpanel')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::withBody(json_encode($dataPost), 'application/json')->post($url, $dataPost);
        Log::channel('cpanel')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        if ($result['status'] == Response::HTTP_OK) {
            $response = [
                'status' => Response::HTTP_OK,
                'message' => __('ViewCpanel::message.success')
            ];
        } else {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => !empty($result['message']) ? $result['message'] : __('ViewCpanel::message.something_errors')
            ];
        }
        Log::channel('cpanel')->info('TradeBudgetEstimates updateCustomerGoal response: ' . print_r($response, true));
        return response()->json($response);
    }

    /**
     * add client'comment method
     * @param $id string
     * @param $request Illuminate\Http\Request;
     * @return json
     * 
     */
    public function addComment($id, Request $request) {
        $user = session('user');
        $userEmail = !empty($user['email']) ? $user['email'] : "";
        if (empty($userEmail)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.you_are_not_logged_in')
            ];
            Log::channel('cpanel')->info('TradeBudgetEstimates addComment response: ' . print_r($response, true));
            return response()->json($response);
        }

        if (!$user['roles']['tradeMKT']['tradeBudgetEstimates']['addComment']) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.permission_denied')
            ];
            Log::channel('cpanel')->info('TradeBudgetEstimates addComment response: ' . print_r($response, true));
            return response()->json($response);
        }

        $dataPost = $request->all();
        $dataPost['budgetEstimateId'] = $id;
        $dataPost['created_by'] = $userEmail;
        $url = config('routes.trade.budgetEstimates.addComment');
        Log::channel('cpanel')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::withBody(json_encode($dataPost), 'application/json')->post($url, $dataPost);
        Log::channel('cpanel')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        if ($result['status'] == Response::HTTP_OK) {
            $response = [
                'status' => Response::HTTP_OK,
                'message' => __('ViewCpanel::message.success')
            ];
        } else {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => !empty($result['message']) ? $result['message'] : __('ViewCpanel::message.something_errors')
            ];
        }
        Log::channel('cpanel')->info('TradeBudgetEstimates addComment response: ' . print_r($response, true));
        return response()->json($response);
    }


    /**
     * sent to approve
     * @param $id string
     * @param $request Illuminate\Http\Request;
     * @return json
     * 
     */
    public function updateProgress($id, Request $request) {
        $user = session('user');
        $userEmail = !empty($user['email']) ? $user['email'] : "";
        if (empty($userEmail)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.you_are_not_logged_in')
            ];
            Log::channel('cpanel')->info('TradeBudgetEstimates updateProgress response: ' . print_r($response, true));
            return response()->json($response);
        }

        $data = $request->all();
        Log::channel('cpanel')->info('TradeBudgetEstimates updateProgress request data: ' . print_r($data, true));
        if (empty($data['action'])) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.errors')
            ];
            Log::channel('cpanel')->info('TradeBudgetEstimates updateProgress response: ' . print_r($response, true));
            return response()->json($response);
        }
        $note = !empty($data['note']) ? $data['note'] : "";
        if (
            empty($note) && (
            ($data['action'] == 'returned') || ($data['action'] == 'canceled'))
        ) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Lý do không được để trống"
            ];
            Log::channel('cpanel')->info('TradeOrder updateStatus response: ' . print_r($response, true));
            return response()->json($response);
        }
        $status = 0;
        $message = __('ViewCpanel::message.success');
        $dataPost = [
            'id' => $id,
            'created_by' => $userEmail,
            'note' => $note
        ];
        switch ($data['action']) {
            case 'sentApprove':
                $status = TradeBudgetEstimates::STATUS_SENT_APPROVE;
                $message = __('ViewCpanel::message.sent_approve_success');
                break;
            case 'approved':
                $status = TradeBudgetEstimates::STATUS_APPROVED;
                $message = __('ViewCpanel::message.approved_success');
                break;
            case 'returned':
                $status = TradeBudgetEstimates::STATUS_RETURNED;
                $message = __('ViewCpanel::message.returned_success');
                break;
            case 'canceled':
                $status = TradeBudgetEstimates::STATUS_CANCLED;
                $message = __('ViewCpanel::message.canceled_success');
                break;
            case 'ccoApproved':
                $dataPost['isCCOAccept'] = 1;
                $status = TradeBudgetEstimates::STATUS_APPROVED;
                $message = __('ViewCpanel::message.approved_success');
                break;
            case 'mktApproved':
                $dataPost['isMKTAccept'] = 1;
                $status = TradeBudgetEstimates::STATUS_APPROVED;
                $message = __('ViewCpanel::message.approved_success');
                break;
        }
        $url = config('routes.trade.budgetEstimates.updateBudgetEstimateProgress');
        $dataPost['status'] = $status;

        Log::channel('cpanel')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::withBody(json_encode($dataPost), 'application/json')->post($url, $dataPost);
        Log::channel('cpanel')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));

        if ($result['status'] == Response::HTTP_OK) {
            $response = [
                'id' => $id,
                'targetUrl' => route('viewcpanel::trade.budgetEstimates.detail', ['id' => $id]),
                'status' => Response::HTTP_OK,
                'message' => $message
            ];
        } else {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => !empty($result['message']) ? $result['message'] : __('ViewCpanel::message.something_errors')
            ];
        }
        Log::channel('cpanel')->info('TradeBudgetEstimates updateProgress response: ' . print_r($response, true));
        return response()->json($response);
    }

    /**
     * delete trade's budget estimate
     * @param $request Illuminate\Http\Request
     * @return json
     *
     */
    public function deleteBE($id, Request $request) {
        $user = session('user');
        $userEmail = !empty($user['email']) ? $user['email'] : "";
        if (empty($userEmail)) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.you_are_not_logged_in')
            ];
            Log::channel('cpanel')->info('TradeBudgetEstimates deleteOrder response: ' . print_r($response, true));
            return response()->json($response);
        }
        if (!$user['roles']['tradeMKT']['tradeBudgetEstimates']['deletebtn']) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => __('ViewCpanel::message.permission_denied')
            ];
            Log::channel('cpanel')->info('TradeBudgetEstimates deleteOrder response: ' . print_r($response, true));
            return response()->json($response);
        }

        $url = config('routes.trade.budgetEstimates.deleteBE');
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
        Log::channel('cpanel')->info('TradeBudgetEstimates deleteOrder response: ' . print_r($response, true));
        return response()->json($response);
    }

}
