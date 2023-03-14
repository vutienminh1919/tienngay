<?php
namespace Modules\ViewCpanel\Http\Controllers;

use Illuminate\Http\Request;
use Modules\MongodbCore\Repositories\RoleRepository;
use Modules\ViewCpanel\Http\Controllers\BaseController;
use Exception;
use Illuminate\Http\Response;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Modules\MongodbCore\Repositories\Interfaces\KsnbRepositoryInterface as KsnbRepository;
// use Modules\MongodbCore\Repositories\Interfaces\StoreRepositoryInterface as StoreRepository;
use Modules\MongodbCore\Repositories\KsnbCodeErrorsRepositoryInterface as KsnbCodeErrorsRepository;
use Illuminate\Support\Facades\Validator;
use Modules\MongodbCore\Repositories\Interfaces\UserCpanelRepositoryInterface as userCpanelRepository;

use Modules\ViewCpanel\Service\ApiCall;
use Modules\MongodbCore\Repositories\GroupRoleRepository;

class NoteKsnbViewController extends BaseController
{
    private $ksnbRepository;
    private $ksnbCodeErrorsRepository;
    private $roleRepository;
    private $userCpanelRepository;
    private $groupRepository;

   public function __construct(
        KsnbRepository $ksnbRepository,
        KsnbCodeErrorsRepository $ksnbCodeErrorsRepository,
        RoleRepository $roleRepository,
        UserCpanelRepository $userCpanelRepository,
        GroupRoleRepository $groupRoleRepository
    ) {
        $this->ksnbRepository = $ksnbRepository;
        $this->roleRepository = $roleRepository;
        $this->ksnbCodeErrorsRepository = $ksnbCodeErrorsRepository;
        $this->userCpanelRepo = $userCpanelRepository;
        $this->groupRepository = $groupRoleRepository;
    }


    /**
    * View list All Note
    * @return view
    */
    public function listAllNote(Request $request) {
        $user = session('user');
        $email = $user['email'];
        $dataSearch = $request->all();
        $listRecords = $this->ksnbRepository->getAllNote($dataSearch);
        $searchUrl = route('ViewCpanel::NoteKsnb.listAllNote');
        return view('viewcpanel::noteKsnb.listAllNote', [
            'listRecords' => $listRecords,
            'searchUrl'   => $searchUrl,
            'dataSearch'  => $dataSearch,
        ]);
    }


    /**
    * Api create Note
    * @param Illuminate\Http\Request
    * @return json
    */
    public function saveNote(Request $request) {
        $dataPost = $request->all();
        if (!empty($dataPost['name_note']) && !empty($dataPost['email_note'])) {
            $validator = Validator::make(
                $dataPost, [
                    'name_note' => 'required',
                    'email_note' => 'required',
                    'content'   => 'required',
                    // 'url' => 'required',
                    'title' => 'required',
                ],
                [
                    'name_note.required' => 'Tên nhân viên không để trống',
                    'email_note.required' => 'Email nhân viên không để trống',
                    // 'url.required' => 'Ảnh không để trống',
                    'content.required' => 'Nội dung ghi nhận không để trống',
                    'title.required' => 'Tiêu đề phiếu ghi nhận không để trống',
                ]
            );
        } else {
            $validator = Validator::make(
                $dataPost, [
                    'name_note' => 'required',
                    'email_note' => 'required',
                    'content'   => 'required',
                    'url' => 'required',
                    'title' => 'required',
                    'user_name_note' => 'required',
                    'user_email_note' => 'required'
                ],
                [
                    'name_note.required' => 'Tên nhân viên không để trống',
                    'email_note.required' => 'Email nhân viên không để trống',
                    'url.required' => 'Ảnh không để trống',
                    'content.required' => 'Nội dung ghi nhận không để trống',
                    'title.required' => 'Tiêu đề phiếu ghi nhận không để trống',
                    'user_name_note.required' => 'Tên nhân viên không để trống',
                    'user_email_note.required' => 'Email nhân viên không để trống',
                ]
            );
        }
        log::info('Request data create Note' . print_r($dataPost, true));
        $user = session('user');

        if($validator->fails()) {
            Log::info('createNote validator ' . $validator->errors()->first());
            return response()->json([
                "status" => BaseController::HTTP_BAD_REQUEST,
                "message" => $validator->errors()->first(),
                "data" => [],
                "errors" => $validator->errors()
            ]);
        }

        $dataPost['updated_by'] = $user['email'];
        $dataPost['created_by'] = $user['email'];
        $url = config('routes.ksnb.reportksnb.saveNote');
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['data']['_id'])) {
            return response()->json([
                "status" => BaseController::HTTP_OK,
                "message" => 'Tạo phiếu ghi nhận thành công',
                "data" => [
                    'redirectURL' => route('ViewCpanel::NoteKsnb.detailNote', ['id' => $result->json()['data']['_id']]),
                ]
            ]);
        } else {
            return response()->json([
                "status" => BaseController::HTTP_BAD_REQUEST,
                "message" => 'Có lỗi xảy ra, vui lòng thử lại sau!',
                "data" => []
            ]);
        }
    }


    /**
    * View create Note
    * @param Illuminate\Http\Request
    * @return view
    */
    public function createNote(Request $request)
    {
        $create = $this->ksnbRepository->getAllReport();
        $stores = $this->roleRepository->getAllRoom();
        $listEmails = $this->userCpanelRepo->getAll(['full_name', 'email']);
        $list = [];
        foreach ($listEmails as $value) {
            if (!empty($value['email'])) {
                $list[] = [
                    'label' => $value['full_name'] . ' - ' . $value['email'],
                    'value' => $value['email']
                ];
            }
            
        }
        return view('viewcpanel::noteKsnb.createNote', [
            'stores' => $stores,
            'urlUpload' => route('ViewCpanel::ReportKsnb.uploadImage'),
            'getEmployeesByStoreId' => route('ViewCpanel::ReportKsnb.getEmployeesByStoreId'),
            'getEmailCHTByStoreId' => route('ViewCpanel::ReportKsnb.getEmailCHTByStoreId'),
            'getNameByEmail' => route('ViewCpanel::ReportKsnb.getNameByEmail'),
            'allMailRoll' => route('ViewCpanel::ReportKsnb.allMailRoll'),
            'getUserActive' => route('ViewCpanel::NoteKsnb.getUserActive'),
            'list'     => $list,
        ]);
    }


    /**
    * view detail Note
    * @param Illuminate\Http\Request
    * @param string $id
    * @return view
    */
    public function detailNote(Request $request, $id)
    {
        $detail = $this->ksnbRepository->findNote($id);
        $user =session('user');
        $email = $user['email'];
        if (!$detail) {
           return abort(404);
        }
        $data = [];
        $userCheckRole = $this->roleRepository->getEmailKsnb();
        $data['ksnb'] = $userCheckRole;
        $userCheckRoleNv = $this->groupRepository->getEmailGroupKsnb();
        $data['cancelReportNv'] = $userCheckRoleNv;
        return view('viewcpanel::noteKsnb.detailNote',[
            'detail' => $detail,
            'ksnb'  => $userCheckRole,
            'cancelReportNv' => $userCheckRoleNv,
            'user'          => $email,
        ]);
    }


    public function feedback(Request $request, $id)
    {
        $user =session('user');
        $email = $user['email'];
        $detail = $this->ksnbRepository->findNote($id);
        if (!$detail) {
           return abort(404);
        }
        return view('viewcpanel::noteKsnb.feedback',[
            'detail' => $detail,
            'user'   => $email,
        ]);
    }


    /**
    * View update Note
    * @param Illuminate\Http\Request
    * @param string $id
    * @return view
    */
    public function editNote(Request $request, $id)
    {
        $detail = $this->ksnbRepository->findNote($id);
        $storeId = $detail['store_id'];
        $stores  = $this->roleRepository->getAllRoom();
        $listEmails = $this->userCpanelRepo->getAll(['full_name', 'email']);
        $employees = $this->roleRepository->getMailByRole($storeId);
        $list = [];
        foreach ($listEmails as $value) {
            $list[] = [
                'label' => $value['full_name'] . ' - ' . $value['email'],
                'value' => $value['email']
            ];
        }
        return view('viewcpanel::noteKsnb.updateNote', [
            'detail' => $detail,
            'stores' => $stores,
            'employees' => $employees,
            'urlUpload' => route('ViewCpanel::ReportKsnb.uploadImage'),
            'getEmployeesByStoreId' => route('ViewCpanel::ReportKsnb.getEmployeesByStoreId'),
            'getEmailCHTByStoreId' => route('ViewCpanel::ReportKsnb.getEmailCHTByStoreId'),
            'getNameByEmail' => route('ViewCpanel::ReportKsnb.getNameByEmail'),
            'allMailRoll' => route('ViewCpanel::ReportKsnb.allMailRoll'),
            'getUserActive' => route('ViewCpanel::NoteKsnb.getUserActive'),
            'list' => $list,
        ]);
    }


    /**
    * get User Active
    * @param Illuminate\Http\Request
    * @return json
    */
    public function getUserActive(Request $request)
    {
        $dataPost = $request->all();
        $url = config('routes.ksnb.reportksnb.getUserActive');
        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api

        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return response()->json($result->json());
    }


    /**
    * Api update Note
    * @param Illuminate\Http\Request
    * @param string $id
    * @return json
    */
    public function updateNote(Request $request, $id)
    {
        $dataPost = $request->all();
        log::info('Request data update Note' . print_r($dataPost, true));
        $user = session('user');
        $validator = Validator::make(
            $dataPost, [
                'name_note' => 'required',
                'email_note' => 'required',
                'content'   => 'required',
                // 'url' => 'required',
                'title' => 'required',
            ],
            [
                'name_note.required' => 'Tên nhân viên không để trống',
                'email_note.required' => 'Email nhân viên không để trống',
                // 'url.required' => 'Ảnh không để trống',
                'content.required' => 'Nội dung ghi nhận không để trống',
                'title.required' => 'Tiêu đề phiếu ghi nhận không để trống',
            ]
        );
        if($validator->fails()) {
            Log::info('updateNote validator ' . $validator->errors()->first());
            return response()->json([
                "status" => BaseController::HTTP_BAD_REQUEST,
                "message" => $validator->errors()->first(),
                "data" => [],
                "errors" => $validator->errors()
            ]);
        }
        $dataPost['updated_by'] = $user['email'];
        $dataPost['created_by'] = $user['email'];
        $url = config('routes.ksnb.reportksnb.updateNote') ."/$id";

        Log::info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        if (!empty($result->json()['data']['_id'])) {
            return response()->json([
                "status" => BaseController::HTTP_OK,
                "message" => 'Cập nhật phiếu ghi nhận thành công',
                "data" => [
                    'redirectURL' => route('ViewCpanel::NoteKsnb.detailNote', ['id' => $result->json()['data']['_id']]),
                ]
            ]);
        } else {
            return response()->json([
                "status" => BaseController::HTTP_BAD_REQUEST,
                "message" => 'Có lỗi xảy ra, vui lòng thử lại sau!',
                "data" => []
            ]);
        }
    }


    /**
    * Api update wait confirm Note
    * @param Illuminate\Http\Request
    * @param string $id
    * @return json
    */
    public function waitConfirmNote(Request $request, $id)
    {   
        $user = session('user');
        $dataPost = $request->all();
        Log::info('data request' . print_r($dataPost, true));
        $dataPost['updated_by'] = $user['email'];
        $dataPost['created_by'] = $user['email'];
        $dataPost['urlItem'] = env('CPANEL_NOTE_PATH')  .'?target_url=' . route('ViewCpanel::NoteKsnb.detailNote', ['id' => $id]);

        $url = config('routes.ksnb.reportksnb.waitConfirmNote') . "/$id";
        Log::info('Call Api: ' .$url. ' ' . print_r($dataPost, true));
        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Result Api:' . $url . " " . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == Response::HTTP_OK) {
            $this->ksnbRepository->wlog($id, config('viewcpanel.note_log_action.wait_confrim_note'), $user['email']);
        }
        return response()->json($result->json());
    }

        
    /**
    * Api update not confirm Note
    * @param Illuminate\Http\Request
    * @param string $id
    * @return json
    */
    public function notConfirmNote(Request $request, $id)
    {
        $user = session('user');
        $dataPost = $request->all();
        Log::info('data request' . print_r($dataPost, true));
        $dataPost['updated_by'] = $user['email'];
        $dataPost['created_by'] = $user['email'];
        $dataPost['urlItem'] = env('CPANEL_NOTE_PATH')  . '?target_url=' . route('ViewCpanel::NoteKsnb.detailNote', ['id' => $id]);
        $url = config('routes.ksnb.reportksnb.notConfirmNote') . "/$id";
        Log::info('Call Api: ' .$url. ' ' . print_r($dataPost, true));
        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Result Api:' . $url . " " . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == Response::HTTP_OK) {
            $this->ksnbRepository->wlog($id, config('viewcpanel.note_log_action.not_confrim_note'), $user['email']);
            return redirect()->route('ViewCpanel::NoteKsnb.detailNote', ['id' => $id])->with('success', 'Cập nhật tiến trình thành công');
        } else {
            return redirect()->route('ViewCpanel::NoteKsnb.listAllNote')->with('errors', 'Có lỗi xảy ra, vui lòng thử lại sau!');
        }
    }
    

    /**
    * Api update reconfirm Note
    * @param Illuminate\Http\Request
    * @param string $id
    * @return json
    */
    public function reConfirmNote(Request $request, $id)
    {
        $user = session('user');
        $dataPost = $request->all();
        Log::info('data request' . print_r($dataPost, true));
        $dataPost['updated_by'] = $user['email'];
        $dataPost['created_by'] = $user['email'];
        $dataPost['urlItem'] = env('CPANEL_NOTE_PATH') . '?target_url=' . route('ViewCpanel::NoteKsnb.detailNote', ['id' => $id]);
        $url = config('routes.ksnb.reportksnb.reConfirmNote') . "/$id";
        Log::info('Call Api: ' .$url. ' ' . print_r($dataPost, true));
        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Result Api:' . $url . " " . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == Response::HTTP_OK) {
            $this->ksnbRepository->wlog($id, config('viewcpanel.note_log_action.reconfirm_note'), $user['email']);
        }
        return response()->json($result->json());
    }


    /**
    * Api update confirm Note
    * @param Illuminate\Http\Request
    * @param string $id
    * @return json
    */
    public function confirmNote(Request $request, $id)
    {
        $user = session('user');
        $dataPost = $request->all();
        Log::info('data request' . print_r($dataPost, true));
        $dataPost['updated_by'] = $user['email'];
        $dataPost['created_by'] = $user['email'];
        $dataPost['urlItem'] = env('CPANEL_NOTE_PATH') . '?target_url=' . route('ViewCpanel::NoteKsnb.feedback', ['id' => $id]);
        $url = config('routes.ksnb.reportksnb.confirmNote') . "/$id";
        Log::info('Call Api: ' .$url. ' ' . print_r($dataPost, true));
        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Result Api:' . $url . " " . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == Response::HTTP_OK) {
            $this->ksnbRepository->wlog($id, config('viewcpanel.note_log_action.confirm_note'), $user['email']);
        }
        return response()->json($result->json());
    }


    /**
    * Api update user feedback Note
    * @param Illuminate\Http\Request
    * @param string $id
    * @return json
    */
    public function userFeedback(Request $request, $id)
    {
        $user = session('user');
        $dataPost = $request->all();
        Log::info('data request' . print_r($dataPost, true));
        $validator = Validator::make(
            $dataPost, [
                'comment' => 'required',
            ],
            [
                'comment.required' => 'Ý kiến phản hồi không để trống',
            ]
        );
        if($validator->fails()) {
            Log::info('updateNote validator ' . $validator->errors()->first());
            return response()->json([
                "status" => BaseController::HTTP_BAD_REQUEST,
                "message" => $validator->errors()->first(),
                "data" => [],
                "errors" => $validator->errors()
            ]);
        }
        $dataPost['email_feedback'] = $user['email'];
        $dataPost['urlItem'] = env('CPANEL_NOTE_PATH') . '?target_url=' . route('ViewCpanel::NoteKsnb.detailNote', ['id' => $id]);
        $url = config('routes.ksnb.reportksnb.userFeedback') . "/$id";
        Log::info('Call Api: ' .$url. ' ' . print_r($dataPost, true));
        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Result Api:' . $url . " " . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == Response::HTTP_OK) {
            $this->ksnbRepository->wlog($id, config('viewcpanel.note_log_action.feedback_note'), $user['email']);
        }
        return response()->json($result->json());
    }


    /**
    * Api update ksnb feedback Note
    * @param Illuminate\Http\Request
    * @param string $id
    * @return json
    */
    public function ksnbFeedback(Request $request, $id)
    {
        $user = session('user');
        $dataPost = $request->all();
        Log::info('data request' . print_r($dataPost, true));
        $validator = Validator::make(
            $dataPost, [
                'ksnb_comment' => 'required',
            ],
            [
                'ksnb_comment.required' => 'Ý kiến phản hồi không để trống',
            ]
        );
        if($validator->fails()) {
            Log::info('updateNote validator ' . $validator->errors()->first());
            return response()->json([
                "status" => BaseController::HTTP_BAD_REQUEST,
                "message" => $validator->errors()->first(),
                "data" => [],
                "errors" => $validator->errors()
            ]);
        }
        $dataPost['email_feedback'] = $user['email'];
        $dataPost['urlItem'] = env('CPANEL_NOTE_PATH') . '?target_url=' . route('ViewCpanel::NoteKsnb.feedback', ['id' => $id]);
        $url = config('routes.ksnb.reportksnb.ksnbFeedback') . "/$id";
        Log::info('Call Api: ' .$url. ' ' . print_r($dataPost, true));
        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Result Api:' . $url . " " . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == Response::HTTP_OK) {
            $this->ksnbRepository->wlog($id, config('viewcpanel.note_log_action.feedback_note'), $user['email']);
        }
        return response()->json($result->json());
    }


    /**
    * Api update wait infer Note
    * @param Illuminate\Http\Request
    * @param string $id
    * @return json
    */
    public function waitInferNote(Request $request, $id)
    {
        $user = session('user');
        $dataPost = $request->all();
        Log::info('data request' . print_r($dataPost, true));
        $dataPost['updated_by'] = $user['email'];
        $dataPost['created_by'] = $user['email'];
        $dataPost['urlItem'] = env('CPANEL_NOTE_PATH') . '?target_url=' . route('ViewCpanel::NoteKsnb.detailNote', ['id' => $id]);
        $url = config('routes.ksnb.reportksnb.waitInferNote') . "/$id";
        Log::info('Call Api: ' .$url. ' ' . print_r($dataPost, true));
        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Result Api:' . $url . " " . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == Response::HTTP_OK) {
            $this->ksnbRepository->wlog($id, config('viewcpanel.note_log_action.wait_infer_note'), $user['email']);
            return redirect()->route('ViewCpanel::NoteKsnb.detailNote', ['id' => $id])->with('success', 'Cập nhật tiến trình thành công');
        } else {
            return redirect()->route('ViewCpanel::NoteKsnb.listAllNote')->with('errors', 'Có lỗi xảy ra, vui lòng thử lại sau!');
        }
    }


    /**
    * Api update infer Note
    * @param Illuminate\Http\Request
    * @param string $id
    * @return json
    */
    public function inferNote(Request $request, $id)
    {
        $user = session('user');
        $dataPost = $request->all();
        Log::info('data request' . print_r($dataPost, true));
        $dataPost['updated_by'] = $user['email'];
        $dataPost['created_by'] = $user['email'];
        $dataPost['urlItem'] = env('CPANEL_NOTE_PATH') . '?target_url=' . route('ViewCpanel::NoteKsnb.detailNote', ['id' => $id]);
        $url = config('routes.ksnb.reportksnb.inferNote') . "/$id";
        Log::info('Call Api: ' .$url. ' ' . print_r($dataPost, true));
        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Result Api:' . $url . " " . print_r($result->json(), true));
        if (!empty($result->json()['status']) && $result->json()['status'] == Response::HTTP_OK) {
            $this->ksnbRepository->wlog($id, config('viewcpanel.note_log_action.infer_note'), $user['email']);
        }
        return response()->json($result->json());
    }
}