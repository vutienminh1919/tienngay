<?php


namespace Modules\ViewCpanel\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\MongodbCore\Repositories\GroupRoleRepository;
use Modules\MongodbCore\Repositories\Interfaces\RoleRepositoryInterface as RoleRepository;
use Modules\MongodbCore\Repositories\StoreRepository;
use Modules\MongodbCore\Repositories\AreaRepository;
use Illuminate\Support\Arr;

class TradeMKT
{
    private $roleRepo;
    private $groupRoleRepo;
    private $areaRepository;
    const VAN_HANH = 'van-hanh';
    const KE_TOAN = 'ke-toan';
    const KE_TOAN_TRUONG = 'tpb-ke-toan';
    const QUAN_LY_CAP_CAO = 'quan-ly-cap-cao';
    const CUA_HANG_TRUONG = 'cua-hang-truong';
    const GIAO_DICH_VIEN = 'giao-dich-vien';
    const TRADE_MARKETING = 'trade-marketing';
    const TP_MARKETING = 'tbp-marketing';
    const ASM = "quan-ly-khu-vuc";
    const RSM = "quan-ly-vung";
    const GDKD = "giam-doc-kinh-doanh";
    const HANH_CHINH = "hanh-chinh";

    public function __construct(
        RoleRepository      $roleRepository,
        GroupRoleRepository $groupRoleRepository,
        StoreRepository     $storeRepository,
        AreaRepository      $areaRepository
    )
    {
        $this->roleRepo = $roleRepository;
        $this->groupRoleRepo = $groupRoleRepository;
        $this->storeRepository = $storeRepository;
        $this->areaRepository = $areaRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = session('user');
        Log::channel('cpanel')->info('User Info: ' . print_r($user, true));
        if (!$user) {
            echo 'Permission denied!';
            exit;
        }
        $email = $user['email'];
        $userId = $user['_id'];
        $isAdmin = (isset($user['is_superadmin']) && (int)$user['is_superadmin'] == 1) ? 1 : 0;
        if (!$isAdmin) {
            $user['is_superadmin'] = 0;
        }
        $groupRole = $this->groupRoleRepo->getGroupRoleByUserId($userId);
        $pgdActive = $this->storeRepository->getActiveList();
        $arrPgdActive = array_column($pgdActive->toArray(), '_id');
        $user['groupRole'] = $groupRole;
        $user['isTPGD'] = false; //truong phong gd
        $user['isASM'] = false; // quyen asm
        $user['isRSM'] = false; // quyen rsm
        $user['isGDKD'] = false; // quyen gdkd
        $user['isTPMKT'] = false; // quyen tp mkt
        $user['isTPKT'] = false; // quyen ke toan truong
        $user['isTradeMKT'] = false; // quyen trade mkt
        $user['roles']['tradeMKT'] = [
            'requestOrder' => [
                'requestOrderView'  => false,
                'requestOrder'      => false,
                'sentApprove'       => false,
                'detailOrderView'   => false,
                'approved'          => false,
                'asmApprove'        => false,
                'rsmApprove'        => false,
                'returned'          => false,
                'canceled'          => false,
                'editOrderView'     => false,
                'updateOrder'       => false,
                'index'             => false,
                'deleteOrder'       => false,
                'itemsTableView'    => false,
                'confirmedAllotment'    => false,
                'showAllAllotmentItems' => false,
                'allotmentConfirmedBtn' => false,
            ],
            'tradeBudgetEstimates' => [
                'index'             => false,
                'detail'            => false,
                'ccoApprovedButton' => false,
                'mktApprovedButton' => false,
                'sentApproveButton' => false,
                'returnedButton'    => false,
                'cancelButton'      => false,
                'cfoApprovedButton' => false,
                'ceoApprovedButton' => false,
                'updateCustomerGoal' => false,
                'addComment'        => false,
                'updateBudgetEstimateStatus' =>false,
                'editCusGoalBtn'    => false,
                'addNoteBtn'        => false,
                'deletebtn'         => false
            ],
            'filterDelivery' => [
                'domainSelect' => false,
                'areaSelect' => false,
                'pgdSelect' => false,
                'statusSelect' => false,
            ],
            'inventory' => [
                'index' => false,
                'explanationCreate' => false,
                'adjustmentCreate' => false,
                'explanationItemListCVKD' => false,
                'explanationItemListMKT' => false,
                'explanationItemListASM' => false,
                'itemDifferentMKT' => false,
                'adjustmentDetail' => false,
                'adjustmentDone' => false,
                'adjustmentCancel' => false,
                'reportDetailMkt' => false,
                'reportCreateBtn' => false,
            ],
            'publication' => [
                'show_list' => false,
                'detailPuclication' => false,
                'buttonAcception' => false,
                'buttonSaveOrder' => false,
                'buttonUpdatePublic' => false,
                'buttonDetailPuclic' => false,
                'buttonCreatePublic' => false,
                'buttonDeletePublic' => false,
            ]
        ];

        $pgdActive = $this->storeRepository->getActiveList();
        $this->roleTPGD($user, $pgdActive, in_array(self::CUA_HANG_TRUONG, $groupRole));
        $this->roleASM($user, $pgdActive, in_array(self::ASM, $groupRole));
        $this->roleRSM($user, $pgdActive, in_array(self::RSM, $groupRole));
        $this->roleTradeMKT($user, $pgdActive, in_array(self::TRADE_MARKETING, $groupRole));
        $this->roleKeToan($user, $pgdActive, in_array(self::KE_TOAN, $groupRole));
        $this->roleHanhChinh($user, $pgdActive, in_array(self::HANH_CHINH, $groupRole));
        $this->roleTPMKT($user, $pgdActive, in_array(self::TP_MARKETING, $groupRole));
        $this->roleGDKD($user, $pgdActive, in_array(self::GDKD, $groupRole));
        $this->roleTPKeToan($user, $pgdActive, in_array(self::KE_TOAN_TRUONG, $groupRole));
        $this->roleAdmin($user, $pgdActive, $isAdmin);

        $codeArea = [];
        $arrArea = [];
        if (empty($user['pgds'])) {
            $user['pgds'] = [];
        }
        foreach ($user['pgds'] as $code) {
            $area = $this->storeRepository->getCodeAreaByStoreId($code['_id']);
            $arrArea[] = $area;
        }
        $area = array_unique($arrArea);
        foreach ($area as $i) {
            $name_area = $this->areaRepository->getCodeAreaTitle($i);
            $codeArea[] = [
                'code' => $i,
                'name' => $name_area['title'],
            ];
        }
        $user['codeArea'] = $codeArea ?? [];
        Log::channel('cpanel')->info('User Info: ' . json_encode($user));
        session(['user' => $user]);
        return $next($request);
    }

    /**
     * setup TPGD's permission
     * */
    public function roleTPGD(&$user, &$pgdActive, $bool = false)
    {
        if (!$bool) {
            return false;
        }
        $user['isTPGD'] = true; //truong phong gd
        // $user['isASM'] = true; // quyen asm
        // $user['isRSM'] = true; // quyen rsm
        // $user['isGDKD'] = true; // quyen gdkd
        // $user['isTPMKT'] = true; // quyen tp mkt
        // $user['isTPKT'] = true; // quyen ke toan truong
        // $user['isTradeMKT'] = true; // quyen trade mkt
        $user['roles']['tradeMKT']['requestOrder']['requestOrderView'] = true;
        $user['roles']['tradeMKT']['requestOrder']['requestOrder'] = true;
        $user['roles']['tradeMKT']['requestOrder']['sentApprove'] = true;
        $user['roles']['tradeMKT']['requestOrder']['detailOrderView'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['asmApprove'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['rsmApprove'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['approved'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['returned'] = true;
        $user['roles']['tradeMKT']['requestOrder']['canceled'] = true;
        $user['roles']['tradeMKT']['requestOrder']['editOrderView'] = true;
        $user['roles']['tradeMKT']['requestOrder']['updateOrder'] = true;
        $user['roles']['tradeMKT']['requestOrder']['index'] = true;
        $user['roles']['tradeMKT']['requestOrder']['deleteOrder'] = true;
        $user['roles']['tradeMKT']['requestOrder']['itemsTableView'] = true;
        $user['roles']['tradeMKT']['requestOrder']['confirmedAllotment'] = true;
        $user['roles']['tradeMKT']['requestOrder']['allotmentConfirmedBtn'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['showAllAllotmentItems'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['updateBudgetEstimateStatus'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['detail'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['updateCustomerGoal'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['addComment'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['ccoApprovedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['mktApprovedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['sentApproveButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['returnedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['cancelButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['ceoApprovedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['cfoApprovedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['index'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['editCusGoalBtn'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['addNoteBtn'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['deletebtn'] = true;

         $user['roles']['tradeMKT']['inventory']['explanationCreate'] = true;
        // $user['roles']['tradeMKT']['inventory']['adjustmentCreate'] = true;
         $user['roles']['tradeMKT']['inventory']['explanationItemListCVKD'] = true;
         $user['roles']['tradeMKT']['inventory']['reportCreateBtn'] = true;
        // $user['roles']['tradeMKT']['inventory']['index'] = true;
        // $user['roles']['tradeMKT']['inventory']['explanationItemListMKT'] = true;
        // $user['roles']['tradeMKT']['inventory']['explanationItemListASM'] = true;
        // $user['roles']['tradeMKT']['inventory']['itemDifferentMKT'] = true;
        // $user['roles']['tradeMKT']['inventory']['adjustmentDetail'] = true;
        // $user['roles']['tradeMKT']['inventory']['adjustmentDone'] = true;
        // $user['roles']['tradeMKT']['inventory']['adjustmentCancel'] = true;
        // $user['roles']['tradeMKT']['inventory']['reportDetailMkt'] = true;
        // //publication
        // $user['roles']['tradeMKT']['publication']['show_list'] = true;
        // $user['roles']['tradeMKT']['publication']['detailPuclication'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonAcception'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonSaveOrder'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonUpdatePublic'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonDetailPuclic'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonCreatePublic'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonDeletePublic'] = true;

        // $user['roles']['tradeMKT']['filterDelivery']['pgdSelect'] = true;
        // $user['roles']['tradeMKT']['filterDelivery']['statusSelect'] = true;
        // $user['roles']['tradeMKT']['filterDelivery']['areaSelect'] = true;
        // $user['roles']['tradeMKT']['filterDelivery']['domainSelect'] = true;

        $pgds = $this->roleRepo->getStoreList($user['_id'], false);
        $pgdIds = Arr::pluck($pgds, '_id');
        $user['pgds'] = $this->storeRepository->fillterActiveList($pgdIds);
        return true;
    }

    /**
     * setup ASM's permission
     * */
    public function roleASM(&$user, &$pgdActive, $bool = false)
    {
        if (!$bool) {
            return false;
        }
        // $user['isTPGD'] = true; //truong phong gd
        $user['isASM'] = true; // quyen asm
        // $user['isRSM'] = true; // quyen rsm
        // $user['isGDKD'] = true; // quyen gdkd
        // $user['isTPMKT'] = true; // quyen tp mkt
        // $user['isTPKT'] = true; // quyen ke toan truong
        // $user['isTradeMKT'] = true; // quyen trade mkt

        // $user['roles']['tradeMKT']['requestOrder']['requestOrderView'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['requestOrder'] = true;
        $user['roles']['tradeMKT']['requestOrder']['sentApprove'] = true;
        $user['roles']['tradeMKT']['requestOrder']['detailOrderView'] = true;
        $user['roles']['tradeMKT']['requestOrder']['asmApprove'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['rsmApprove'] = true;
        $user['roles']['tradeMKT']['requestOrder']['approved'] = true;
        $user['roles']['tradeMKT']['requestOrder']['returned'] = true;
        $user['roles']['tradeMKT']['requestOrder']['canceled'] = true;
        $user['roles']['tradeMKT']['requestOrder']['editOrderView'] = true;
        $user['roles']['tradeMKT']['requestOrder']['updateOrder'] = true;
        $user['roles']['tradeMKT']['requestOrder']['index'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['deleteOrder'] = true;
        $user['roles']['tradeMKT']['requestOrder']['itemsTableView'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['confirmedAllotment'] = true;
        $user['roles']['tradeMKT']['requestOrder']['showAllAllotmentItems'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['allotmentConfirmedBtn'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['updateBudgetEstimateStatus'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['detail'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['updateCustomerGoal'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['addComment'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['ccoApprovedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['mktApprovedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['sentApproveButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['returnedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['cancelButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['ceoApprovedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['cfoApprovedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['index'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['editCusGoalBtn'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['addNoteBtn'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['deletebtn'] = true;

        // $user['roles']['tradeMKT']['inventory']['index'] = true;
        // $user['roles']['tradeMKT']['inventory']['explanationCreate'] = true;
         $user['roles']['tradeMKT']['inventory']['adjustmentCreate'] = true;
        // $user['roles']['tradeMKT']['inventory']['explanationItemListCVKD'] = true;
        // $user['roles']['tradeMKT']['inventory']['explanationItemListMKT'] = true;
         $user['roles']['tradeMKT']['inventory']['explanationItemListASM'] = true;
        // $user['roles']['tradeMKT']['inventory']['itemDifferentMKT'] = true;
         $user['roles']['tradeMKT']['inventory']['adjustmentDetail'] = true;
        // $user['roles']['tradeMKT']['inventory']['adjustmentDone'] = true;
        // $user['roles']['tradeMKT']['inventory']['adjustmentCancel'] = true;
        // $user['roles']['tradeMKT']['inventory']['reportDetailMkt'] = true;
        // //publication
        // $user['roles']['tradeMKT']['publication']['show_list'] = true;
        // $user['roles']['tradeMKT']['publication']['detailPuclication'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonAcception'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonSaveOrder'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonUpdatePublic'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonDetailPuclic'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonCreatePublic'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonDeletePublic'] = true;

        // $user['roles']['tradeMKT']['filterDelivery']['pgdSelect'] = true;
        // $user['roles']['tradeMKT']['filterDelivery']['statusSelect'] = true;
        // $user['roles']['tradeMKT']['filterDelivery']['areaSelect'] = true;
        // $user['roles']['tradeMKT']['filterDelivery']['domainSelect'] = true;

        $pgds = $this->roleRepo->getStoreList($user['_id'], false);
        $pgdIds = Arr::pluck($pgds, '_id');
        $user['pgds'] = $this->storeRepository->fillterActiveList($pgdIds);
        return true;
    }

    /**
     * setup RSM's permission
     * */
    public function roleRSM(&$user, &$pgdActive, $bool = false)
    {
        if (!$bool) {
            return false;
        }
        // $user['isTPGD'] = true; //truong phong gd
        // $user['isASM'] = true; // quyen asm
        $user['isRSM'] = true; // quyen rsm
        // $user['isGDKD'] = true; // quyen gdkd
        // $user['isTPMKT'] = true; // quyen tp mkt
        // $user['isTPKT'] = true; // quyen ke toan truong
        // $user['isTradeMKT'] = true; // quyen trade mkt

        // $user['roles']['tradeMKT']['requestOrder']['requestOrderView'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['requestOrder'] = true;
        $user['roles']['tradeMKT']['requestOrder']['sentApprove'] = true;
        $user['roles']['tradeMKT']['requestOrder']['detailOrderView'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['asmApprove'] = true;
        $user['roles']['tradeMKT']['requestOrder']['rsmApprove'] = true;
        $user['roles']['tradeMKT']['requestOrder']['approved'] = true;
        $user['roles']['tradeMKT']['requestOrder']['returned'] = true;
        $user['roles']['tradeMKT']['requestOrder']['canceled'] = true;
        $user['roles']['tradeMKT']['requestOrder']['editOrderView'] = true;
        $user['roles']['tradeMKT']['requestOrder']['updateOrder'] = true;
        $user['roles']['tradeMKT']['requestOrder']['index'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['deleteOrder'] = true;
        $user['roles']['tradeMKT']['requestOrder']['itemsTableView'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['confirmedAllotment'] = true;
        $user['roles']['tradeMKT']['requestOrder']['showAllAllotmentItems'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['allotmentConfirmedBtn'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['updateBudgetEstimateStatus'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['detail'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['updateCustomerGoal'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['addComment'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['ccoApprovedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['mktApprovedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['sentApproveButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['returnedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['cancelButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['ceoApprovedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['cfoApprovedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['index'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['editCusGoalBtn'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['addNoteBtn'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['deletebtn'] = true;

        $user['roles']['tradeMKT']['inventory']['index'] = true;
        // $user['roles']['tradeMKT']['inventory']['explanationCreate'] = true;
        // $user['roles']['tradeMKT']['inventory']['adjustmentCreate'] = true;
        // $user['roles']['tradeMKT']['inventory']['explanationItemListCVKD'] = true;
        // $user['roles']['tradeMKT']['inventory']['explanationItemListMKT'] = true;
        // $user['roles']['tradeMKT']['inventory']['explanationItemListASM'] = true;
        // $user['roles']['tradeMKT']['inventory']['itemDifferentMKT'] = true;
        // $user['roles']['tradeMKT']['inventory']['adjustmentDetail'] = true;
        // $user['roles']['tradeMKT']['inventory']['adjustmentDone'] = true;
        // $user['roles']['tradeMKT']['inventory']['adjustmentCancel'] = true;
        // $user['roles']['tradeMKT']['inventory']['reportDetailMkt'] = true;
        // //publication
        // $user['roles']['tradeMKT']['publication']['show_list'] = true;
        // $user['roles']['tradeMKT']['publication']['detailPuclication'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonAcception'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonSaveOrder'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonUpdatePublic'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonDetailPuclic'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonCreatePublic'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonDeletePublic'] = true;

        // $user['roles']['tradeMKT']['filterDelivery']['pgdSelect'] = true;
        // $user['roles']['tradeMKT']['filterDelivery']['statusSelect'] = true;
        // $user['roles']['tradeMKT']['filterDelivery']['areaSelect'] = true;
        // $user['roles']['tradeMKT']['filterDelivery']['domainSelect'] = true;

        $pgds = $this->roleRepo->getStoreList($user['_id'], false);
        $pgdIds = Arr::pluck($pgds, '_id');
        $user['pgds'] = $this->storeRepository->fillterActiveList($pgdIds);
        return true;
    }


    /**
     * setup GDKD's permission
     * */
    public function roleGDKD(&$user, &$pgdActive, $bool = false)
    {
        if (!$bool) {
            return false;
        }

        // $user['isTPGD'] = true; //truong phong gd
        // $user['isASM'] = true; // quyen asm
        // $user['isRSM'] = true; // quyen rsm
        $user['isGDKD'] = true; // quyen gdkd
        // $user['isTPMKT'] = true; // quyen tp mkt
        // $user['isTPKT'] = true; // quyen ke toan truong
        // $user['isTradeMKT'] = true; // quyen trade mkt

        // $user['roles']['tradeMKT']['requestOrder']['requestOrderView'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['requestOrder'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['sentApprove'] = true;
        $user['roles']['tradeMKT']['requestOrder']['detailOrderView'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['asmApprove'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['rsmApprove'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['approved'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['returned'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['canceled'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['editOrderView'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['updateOrder'] = true;
        $user['roles']['tradeMKT']['requestOrder']['index'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['deleteOrder'] = true;
        $user['roles']['tradeMKT']['requestOrder']['itemsTableView'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['confirmedAllotment'] = true;
        $user['roles']['tradeMKT']['requestOrder']['showAllAllotmentItems'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['allotmentConfirmedBtn'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['updateBudgetEstimateStatus'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['detail'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['updateCustomerGoal'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['addComment'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['ccoApprovedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['mktApprovedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['sentApproveButton'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['returnedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['cancelButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['ceoApprovedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['cfoApprovedButton'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['index'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['editCusGoalBtn'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['addNoteBtn'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['deletebtn'] = true;

        $user['roles']['tradeMKT']['inventory']['index'] = true;
        // $user['roles']['tradeMKT']['inventory']['explanationCreate'] = true;
        // $user['roles']['tradeMKT']['inventory']['adjustmentCreate'] = true;
        // $user['roles']['tradeMKT']['inventory']['explanationItemListCVKD'] = true;
        // $user['roles']['tradeMKT']['inventory']['explanationItemListMKT'] = true;
        // $user['roles']['tradeMKT']['inventory']['explanationItemListASM'] = true;
        // $user['roles']['tradeMKT']['inventory']['itemDifferentMKT'] = true;
        // $user['roles']['tradeMKT']['inventory']['adjustmentDetail'] = true;
        // $user['roles']['tradeMKT']['inventory']['adjustmentDone'] = true;
        // $user['roles']['tradeMKT']['inventory']['adjustmentCancel'] = true;
        // $user['roles']['tradeMKT']['inventory']['reportDetailMkt'] = true;
        // //publication
        // $user['roles']['tradeMKT']['publication']['show_list'] = true;
        // $user['roles']['tradeMKT']['publication']['detailPuclication'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonAcception'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonSaveOrder'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonUpdatePublic'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonDetailPuclic'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonCreatePublic'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonDeletePublic'] = true;

        // $user['roles']['tradeMKT']['filterDelivery']['pgdSelect'] = true;
        // $user['roles']['tradeMKT']['filterDelivery']['statusSelect'] = true;
        // $user['roles']['tradeMKT']['filterDelivery']['areaSelect'] = true;
        // $user['roles']['tradeMKT']['filterDelivery']['domainSelect'] = true;

        $user['pgds'] = $pgdActive->toArray();
        return true;
    }

    /**
     * setup Trade MKT's permission
     * */
    public function roleTradeMKT(&$user, &$pgdActive, $bool = false)
    {
        if (!$bool) {
            return false;
        }

        // $user['isTPGD'] = true; //truong phong gd
        // $user['isASM'] = true; // quyen asm
        // $user['isRSM'] = true; // quyen rsm
        // $user['isGDKD'] = true; // quyen gdkd
        // $user['isTPMKT'] = true; // quyen tp mkt
        // $user['isTPKT'] = true; // quyen ke toan truong
        $user['isTradeMKT'] = true; // quyen trade mkt

        // $user['roles']['tradeMKT']['requestOrder']['requestOrderView'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['requestOrder'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['sentApprove'] = true;
        $user['roles']['tradeMKT']['requestOrder']['detailOrderView'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['asmApprove'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['rsmApprove'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['approved'] = true;
        $user['roles']['tradeMKT']['requestOrder']['returned'] = true;
        $user['roles']['tradeMKT']['requestOrder']['canceled'] = true;
        $user['roles']['tradeMKT']['requestOrder']['editOrderView'] = true;
        $user['roles']['tradeMKT']['requestOrder']['updateOrder'] = true;
        $user['roles']['tradeMKT']['requestOrder']['index'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['deleteOrder'] = true;
        $user['roles']['tradeMKT']['requestOrder']['itemsTableView'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['confirmedAllotment'] = true;
        $user['roles']['tradeMKT']['requestOrder']['showAllAllotmentItems'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['allotmentConfirmedBtn'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['updateBudgetEstimateStatus'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['detail'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['updateCustomerGoal'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['addComment'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['ccoApprovedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['mktApprovedButton'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['sentApproveButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['returnedButton'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['cancelButton'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['ceoApprovedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['cfoApprovedButton'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['index'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['editCusGoalBtn'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['addNoteBtn'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['deletebtn'] = true;

        $user['roles']['tradeMKT']['inventory']['index'] = true;
        // $user['roles']['tradeMKT']['inventory']['explanationCreate'] = true;
        // $user['roles']['tradeMKT']['inventory']['adjustmentCreate'] = true;
        // $user['roles']['tradeMKT']['inventory']['explanationItemListCVKD'] = true;
         $user['roles']['tradeMKT']['inventory']['explanationItemListMKT'] = true;
        // $user['roles']['tradeMKT']['inventory']['explanationItemListASM'] = true;
         $user['roles']['tradeMKT']['inventory']['itemDifferentMKT'] = true;
         $user['roles']['tradeMKT']['inventory']['adjustmentDetail'] = true;
         $user['roles']['tradeMKT']['inventory']['adjustmentDone'] = true;
         $user['roles']['tradeMKT']['inventory']['adjustmentCancel'] = true;
         $user['roles']['tradeMKT']['inventory']['reportDetailMkt'] = true;
        // //publication
         $user['roles']['tradeMKT']['publication']['show_list'] = true;
         $user['roles']['tradeMKT']['publication']['detailPuclication'] = true;
         $user['roles']['tradeMKT']['publication']['buttonAcception'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonSaveOrder'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonUpdatePublic'] = true;
         $user['roles']['tradeMKT']['publication']['buttonDetailPuclic'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonCreatePublic'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonDeletePublic'] = true;

        $user['roles']['tradeMKT']['filterDelivery']['pgdSelect'] = true;
        $user['roles']['tradeMKT']['filterDelivery']['statusSelect'] = true;
        $user['roles']['tradeMKT']['filterDelivery']['areaSelect'] = true;
        $user['roles']['tradeMKT']['filterDelivery']['domainSelect'] = true;

        $user['pgds'] = $pgdActive->toArray();
        return true;
    }

    /**
     * setup TP MKT's permission
     * */
    public function roleTPMKT(&$user, &$pgdActive, $bool = false)
    {
        if (!$bool) {
            return false;
        }

        // $user['isTPGD'] = true; //truong phong gd
        // $user['isASM'] = true; // quyen asm
        // $user['isRSM'] = true; // quyen rsm
        // $user['isGDKD'] = true; // quyen gdkd
        $user['isTPMKT'] = true; // quyen tp mkt
        // $user['isTPKT'] = true; // quyen ke toan truong
        // $user['isTradeMKT'] = true; // quyen trade mkt

        // $user['roles']['tradeMKT']['requestOrder']['requestOrderView'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['requestOrder'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['sentApprove'] = true;
        $user['roles']['tradeMKT']['requestOrder']['detailOrderView'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['asmApprove'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['rsmApprove'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['approved'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['returned'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['canceled'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['editOrderView'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['updateOrder'] = true;
        $user['roles']['tradeMKT']['requestOrder']['index'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['deleteOrder'] = true;
        $user['roles']['tradeMKT']['requestOrder']['itemsTableView'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['confirmedAllotment'] = true;
        $user['roles']['tradeMKT']['requestOrder']['showAllAllotmentItems'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['allotmentConfirmedBtn'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['updateBudgetEstimateStatus'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['detail'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['updateCustomerGoal'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['addComment'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['ccoApprovedButton'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['mktApprovedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['sentApproveButton'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['returnedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['cancelButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['ceoApprovedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['cfoApprovedButton'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['index'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['editCusGoalBtn'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['addNoteBtn'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['deletebtn'] = true;

        $user['roles']['tradeMKT']['inventory']['index'] = true;
        // $user['roles']['tradeMKT']['inventory']['explanationCreate'] = true;
        // $user['roles']['tradeMKT']['inventory']['adjustmentCreate'] = true;
        // $user['roles']['tradeMKT']['inventory']['explanationItemListCVKD'] = true;
        // $user['roles']['tradeMKT']['inventory']['explanationItemListMKT'] = true;
        // $user['roles']['tradeMKT']['inventory']['explanationItemListASM'] = true;
        // $user['roles']['tradeMKT']['inventory']['itemDifferentMKT'] = true;
        // $user['roles']['tradeMKT']['inventory']['adjustmentDetail'] = true;
        // $user['roles']['tradeMKT']['inventory']['adjustmentDone'] = true;
        // $user['roles']['tradeMKT']['inventory']['adjustmentCancel'] = true;
        // $user['roles']['tradeMKT']['inventory']['reportDetailMkt'] = true;
        // //publication
         $user['roles']['tradeMKT']['publication']['show_list'] = true;
         $user['roles']['tradeMKT']['publication']['detailPuclication'] = true;
         $user['roles']['tradeMKT']['publication']['buttonAcception'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonSaveOrder'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonUpdatePublic'] = true;
         $user['roles']['tradeMKT']['publication']['buttonDetailPuclic'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonCreatePublic'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonDeletePublic'] = true;

        // $user['roles']['tradeMKT']['filterDelivery']['pgdSelect'] = true;
        // $user['roles']['tradeMKT']['filterDelivery']['statusSelect'] = true;
        // $user['roles']['tradeMKT']['filterDelivery']['areaSelect'] = true;
        // $user['roles']['tradeMKT']['filterDelivery']['domainSelect'] = true;

        $user['pgds'] = $pgdActive->toArray();
        return true;
    }

    /**
     * setup KeToan's permission
     * */
    public function roleKeToan(&$user, &$pgdActive, $bool = false)
    {
        if (!$bool) {
            return false;
        }
        // $user['roles']['tradeMKT']['requestOrder']['requestOrderView'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['requestOrder'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['sentApprove'] = true;
         $user['roles']['tradeMKT']['requestOrder']['detailOrderView'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['asmApprove'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['rsmApprove'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['approved'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['returned'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['canceled'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['editOrderView'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['updateOrder'] = true;
         $user['roles']['tradeMKT']['requestOrder']['index'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['deleteOrder'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['itemsTableView'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['confirmedAllotment'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['showAllAllotmentItems'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['allotmentConfirmedBtn'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['updateBudgetEstimateStatus'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['detail'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['updateCustomerGoal'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['addComment'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['ccoApprovedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['mktApprovedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['sentApproveButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['returnedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['cancelButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['ceoApprovedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['cfoApprovedButton'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['index'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['editCusGoalBtn'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['addNoteBtn'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['deletebtn'] = true;

        $user['roles']['tradeMKT']['inventory']['index'] = true;
        // $user['roles']['tradeMKT']['inventory']['explanationCreate'] = true;
        // $user['roles']['tradeMKT']['inventory']['adjustmentCreate'] = true;
        // $user['roles']['tradeMKT']['inventory']['explanationItemListCVKD'] = true;
        // $user['roles']['tradeMKT']['inventory']['explanationItemListMKT'] = true;
        // $user['roles']['tradeMKT']['inventory']['explanationItemListASM'] = true;
        // $user['roles']['tradeMKT']['inventory']['itemDifferentMKT'] = true;
        // $user['roles']['tradeMKT']['inventory']['adjustmentDetail'] = true;
        // $user['roles']['tradeMKT']['inventory']['adjustmentDone'] = true;
        // $user['roles']['tradeMKT']['inventory']['adjustmentCancel'] = true;
        // $user['roles']['tradeMKT']['inventory']['reportDetailMkt'] = true;
        // //publication
        // $user['roles']['tradeMKT']['publication']['show_list'] = true;
        // $user['roles']['tradeMKT']['publication']['detailPuclication'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonAcception'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonSaveOrder'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonUpdatePublic'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonDetailPuclic'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonCreatePublic'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonDeletePublic'] = true;

        // $user['roles']['tradeMKT']['filterDelivery']['pgdSelect'] = true;
        // $user['roles']['tradeMKT']['filterDelivery']['statusSelect'] = true;
        // $user['roles']['tradeMKT']['filterDelivery']['areaSelect'] = true;
        // $user['roles']['tradeMKT']['filterDelivery']['domainSelect'] = true;

        $user['pgds'] = $pgdActive->toArray();
        return true;
    }

    /**
     * setup TP KeToan's permission
     * */
    public function roleTPKeToan(&$user, &$pgdActive, $bool = false)
    {
        if (!$bool) {
            return false;
        }

        // $user['isTPGD'] = true; //truong phong gd
        // $user['isASM'] = true; // quyen asm
        // $user['isRSM'] = true; // quyen rsm
        // $user['isGDKD'] = true; // quyen gdkd
        // $user['isTPMKT'] = true; // quyen tp mkt
        $user['isTPKT'] = true; // quyen ke toan truong

        // $user['roles']['tradeMKT']['requestOrder']['requestOrderView'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['requestOrder'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['sentApprove'] = true;
         $user['roles']['tradeMKT']['requestOrder']['detailOrderView'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['asmApprove'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['rsmApprove'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['approved'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['returned'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['canceled'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['editOrderView'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['updateOrder'] = true;
         $user['roles']['tradeMKT']['requestOrder']['index'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['deleteOrder'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['itemsTableView'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['confirmedAllotment'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['showAllAllotmentItems'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['allotmentConfirmedBtn'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['updateBudgetEstimateStatus'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['detail'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['updateCustomerGoal'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['addComment'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['ccoApprovedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['mktApprovedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['sentApproveButton'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['returnedButton'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['cancelButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['ceoApprovedButton'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['cfoApprovedButton'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['index'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['editCusGoalBtn'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['addNoteBtn'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['deletebtn'] = true;

        $user['roles']['tradeMKT']['inventory']['index'] = true;
        // $user['roles']['tradeMKT']['inventory']['explanationCreate'] = true;
        // $user['roles']['tradeMKT']['inventory']['adjustmentCreate'] = true;
        // $user['roles']['tradeMKT']['inventory']['explanationItemListCVKD'] = true;
        // $user['roles']['tradeMKT']['inventory']['explanationItemListMKT'] = true;
        // $user['roles']['tradeMKT']['inventory']['explanationItemListASM'] = true;
        // $user['roles']['tradeMKT']['inventory']['itemDifferentMKT'] = true;
        // $user['roles']['tradeMKT']['inventory']['adjustmentDetail'] = true;
        // $user['roles']['tradeMKT']['inventory']['adjustmentDone'] = true;
        // $user['roles']['tradeMKT']['inventory']['adjustmentCancel'] = true;
        // $user['roles']['tradeMKT']['inventory']['reportDetailMkt'] = true;
        // //publication
        // $user['roles']['tradeMKT']['publication']['show_list'] = true;
        // $user['roles']['tradeMKT']['publication']['detailPuclication'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonAcception'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonSaveOrder'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonUpdatePublic'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonDetailPuclic'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonCreatePublic'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonDeletePublic'] = true;

        // $user['roles']['tradeMKT']['filterDelivery']['pgdSelect'] = true;
        // $user['roles']['tradeMKT']['filterDelivery']['statusSelect'] = true;
        // $user['roles']['tradeMKT']['filterDelivery']['areaSelect'] = true;
        // $user['roles']['tradeMKT']['filterDelivery']['domainSelect'] = true;

        $user['pgds'] = $pgdActive->toArray();
        return true;
    }

    /**
     * setup Hanh chinh's permission
     * */
    public function roleHanhChinh(&$user, &$pgdActive, $bool = false)
    {
        if (!$bool) {
            return false;
        }
        // $user['roles']['tradeMKT']['requestOrder']['requestOrderView'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['requestOrder'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['sentApprove'] = true;
         $user['roles']['tradeMKT']['requestOrder']['detailOrderView'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['asmApprove'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['rsmApprove'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['approved'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['returned'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['canceled'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['editOrderView'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['updateOrder'] = true;
         $user['roles']['tradeMKT']['requestOrder']['index'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['deleteOrder'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['itemsTableView'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['confirmedAllotment'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['showAllAllotmentItems'] = true;
        // $user['roles']['tradeMKT']['requestOrder']['allotmentConfirmedBtn'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['updateBudgetEstimateStatus'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['detail'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['updateCustomerGoal'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['addComment'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['ccoApprovedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['mktApprovedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['sentApproveButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['returnedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['cancelButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['ceoApprovedButton'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['cfoApprovedButton'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['index'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['editCusGoalBtn'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['addNoteBtn'] = true;
        // $user['roles']['tradeMKT']['tradeBudgetEstimates']['deletebtn'] = true;

        $user['roles']['tradeMKT']['inventory']['index'] = true;
        // $user['roles']['tradeMKT']['inventory']['explanationCreate'] = true;
        // $user['roles']['tradeMKT']['inventory']['adjustmentCreate'] = true;
        // $user['roles']['tradeMKT']['inventory']['explanationItemListCVKD'] = true;
        // $user['roles']['tradeMKT']['inventory']['explanationItemListMKT'] = true;
        // $user['roles']['tradeMKT']['inventory']['explanationItemListASM'] = true;
        // $user['roles']['tradeMKT']['inventory']['itemDifferentMKT'] = true;
        // $user['roles']['tradeMKT']['inventory']['adjustmentDetail'] = true;
        // $user['roles']['tradeMKT']['inventory']['adjustmentDone'] = true;
        // $user['roles']['tradeMKT']['inventory']['adjustmentCancel'] = true;
        // $user['roles']['tradeMKT']['inventory']['reportDetailMkt'] = true;
        // //publication
         $user['roles']['tradeMKT']['publication']['show_list'] = true;
         $user['roles']['tradeMKT']['publication']['detailPuclication'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonAcception'] = true;
         $user['roles']['tradeMKT']['publication']['buttonSaveOrder'] = true;
         $user['roles']['tradeMKT']['publication']['buttonUpdatePublic'] = true;
        // $user['roles']['tradeMKT']['publication']['buttonDetailPuclic'] = true;
         $user['roles']['tradeMKT']['publication']['buttonCreatePublic'] = true;
         $user['roles']['tradeMKT']['publication']['buttonDeletePublic'] = true;

        // $user['roles']['tradeMKT']['filterDelivery']['pgdSelect'] = true;
        // $user['roles']['tradeMKT']['filterDelivery']['statusSelect'] = true;
        // $user['roles']['tradeMKT']['filterDelivery']['areaSelect'] = true;
        // $user['roles']['tradeMKT']['filterDelivery']['domainSelect'] = true;

        $user['pgds'] = $pgdActive->toArray();
        return true;
    }

    /**
     * setup Hanh chinh's permission
     * */
    public function roleAdmin(&$user, &$pgdActive, $bool = false)
    {
        if (!$bool) {
            return false;
        }
        $user['roles']['tradeMKT']['requestOrder']['requestOrderView'] = true;
        $user['roles']['tradeMKT']['requestOrder']['requestOrder'] = true;
        $user['roles']['tradeMKT']['requestOrder']['sentApprove'] = true;
        $user['roles']['tradeMKT']['requestOrder']['detailOrderView'] = true;
        $user['roles']['tradeMKT']['requestOrder']['asmApprove'] = true;
        $user['roles']['tradeMKT']['requestOrder']['rsmApprove'] = true;
        $user['roles']['tradeMKT']['requestOrder']['approved'] = true;
        $user['roles']['tradeMKT']['requestOrder']['returned'] = true;
        $user['roles']['tradeMKT']['requestOrder']['canceled'] = true;
        $user['roles']['tradeMKT']['requestOrder']['editOrderView'] = true;
        $user['roles']['tradeMKT']['requestOrder']['updateOrder'] = true;
        $user['roles']['tradeMKT']['requestOrder']['index'] = true;
        $user['roles']['tradeMKT']['requestOrder']['deleteOrder'] = true;
        $user['roles']['tradeMKT']['requestOrder']['itemsTableView'] = true;
        $user['roles']['tradeMKT']['requestOrder']['confirmedAllotment'] = true;
        $user['roles']['tradeMKT']['requestOrder']['showAllAllotmentItems'] = true;
        $user['roles']['tradeMKT']['requestOrder']['allotmentConfirmedBtn'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['updateBudgetEstimateStatus'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['detail'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['updateCustomerGoal'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['addComment'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['ccoApprovedButton'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['mktApprovedButton'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['sentApproveButton'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['returnedButton'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['cancelButton'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['ceoApprovedButton'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['cfoApprovedButton'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['index'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['editCusGoalBtn'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['addNoteBtn'] = true;
        $user['roles']['tradeMKT']['tradeBudgetEstimates']['deletebtn'] = true;
        $user['roles']['tradeMKT']['inventory']['index'] = true;
        $user['roles']['tradeMKT']['inventory']['explanationCreate'] = true;
        $user['roles']['tradeMKT']['inventory']['adjustmentCreate'] = true;
        $user['roles']['tradeMKT']['inventory']['explanationItemListCVKD'] = true;
        $user['roles']['tradeMKT']['inventory']['explanationItemListMKT'] = true;
        $user['roles']['tradeMKT']['inventory']['explanationItemListASM'] = true;
        $user['roles']['tradeMKT']['inventory']['itemDifferentMKT'] = true;
        $user['roles']['tradeMKT']['inventory']['adjustmentDetail'] = true;
        $user['roles']['tradeMKT']['inventory']['adjustmentDone'] = true;
        $user['roles']['tradeMKT']['inventory']['adjustmentCancel'] = true;
        $user['roles']['tradeMKT']['inventory']['reportDetailMkt'] = true;
        //publication
        $user['roles']['tradeMKT']['publication']['show_list'] = true;
        $user['roles']['tradeMKT']['publication']['detailPuclication'] = true;
        $user['roles']['tradeMKT']['publication']['buttonAcception'] = true;
        $user['roles']['tradeMKT']['publication']['buttonSaveOrder'] = true;
        $user['roles']['tradeMKT']['publication']['buttonUpdatePublic'] = true;
        $user['roles']['tradeMKT']['publication']['buttonDetailPuclic'] = true;
        $user['roles']['tradeMKT']['publication']['buttonCreatePublic'] = true;
        $user['roles']['tradeMKT']['publication']['buttonDeletePublic'] = true;

        $user['roles']['tradeMKT']['filterDelivery']['pgdSelect'] = true;
        $user['roles']['tradeMKT']['filterDelivery']['statusSelect'] = true;
        $user['roles']['tradeMKT']['filterDelivery']['areaSelect'] = true;
        $user['roles']['tradeMKT']['filterDelivery']['domainSelect'] = true;

        $user['pgds'] = $pgdActive->toArray();
        return true;
    }
}
