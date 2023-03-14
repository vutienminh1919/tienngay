<?php

namespace Modules\ReportsKsnb\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\MongodbCore\Repositories\Interfaces\KsnbRepositoryInterface as KsnbRepository;
use Modules\MongodbCore\Repositories\KsnbCodeErrorsRepositoryInterface as KsnbCodeErrorsRepository;
use Modules\MongodbCore\Repositories\RoleRepository;
use Modules\MongodbCore\Repositories\Interfaces\UserCpanelRepositoryInterface as userCpanelRepository;
use Modules\MongodbCore\Entities\ReportsKsnb;
use Modules\MongodbCore\Entities\KsnbCodeError;
use DateTime;
use Modules\ReportsKsnb\Service\ApiCall;

class NoteKsnbController extends BaseController
{
    private $ksnbRepository;
    private $roleRepository;
    // private $storeRepository;
    private $userCpanelRepository;
    private $ksnbCodeErrorsRepository;
    // private $ksnbCodeRepo;

    /**
      * @OA\Info(
      *     version="1.0",
      *     title="API VFCPayment"
      * )
      */
      public function __construct(

        KsnbRepository $ksnbRepository,
        RoleRepository $roleRepository,
        UserCpanelRepository $userCpanelRepository,
        KsnbCodeErrorsRepository $ksnbCodeErrorsRepository
    )

    {
        $this->ksnbRepository = $ksnbRepository;
        $this->roleRepository = $roleRepository;
        $this->userCpanelRepo = $userCpanelRepository;
        $this->ksnbCodeErrorsRepository = $ksnbCodeErrorsRepository;
    }

    /**
    * Add Quote Document 
    * @param
    * @return json
    */
    public function addQuoteDocument()
    {
        $getAllCodes = $this->ksnbCodeErrorsRepository->getCodesNoQuote();
        Log::channel('reportsksnb')->info("data get all code errors". print_r($getAllCodes, true));
        if ($getAllCodes) {
            foreach ($getAllCodes as $key => $item) {
                $this->ksnbCodeErrorsRepository->addQuoteDocument($item->_id);
            }
        }
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
        ]);
    }


    /**
    * Api create Note
    * @param Illuminate\Http\Request
    * @return json
    */
    public function saveNote(Request $request)
    {   
        $dataRequest = $request->all();
        Log::channel('reportsksnb')->info('request save Note :'  . print_r($dataRequest, true));
        $validator = Validator::make($dataRequest, [
            'content' => 'required',
            'name_note' => 'required',
            'email_note' => 'required',
            // 'url' => 'required',
            'title' => 'required',
        ], [
            'content.required' => 'Nội dung ghi nhận không để trống',
            'name_note.required' => 'Tên nhân viên không để trống',
            'email_note.required' => 'Email nhân viên không để trống',
            // 'url.required' => 'Ảnh không để trống',
            'title.required' => 'Tiêu đề phiếu ghi nhận không để trống',
        ]);
        Log::channel('reportsksnb')->info("validator ". $validator->fails());
        if($validator->fails()) {
            Log::channel('reportsksnb')->info('create Record validator' .$validator->errors()->first());
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $validator->errors()->first(),
            ]);
        }
        if (isset($dataRequest['store_name'])) {
            $storeId = $dataRequest['store_name'];
            $storeName = $this->roleRepository->getStoreName($storeId);
        } else {
            $storeId = '';
            $storeName = '';
        }


        $dataInput = [
            ReportsKsnb::COLUMN_IMAGE_PATH          => !empty($dataRequest['url']) ? $dataRequest['url'] : "",
            ReportsKsnb::COLUMN_STORE_ID            => !empty($storeId) ? $storeId : "",
            ReportsKsnb::COLUMN_STORE_NAME          => !empty($storeName) ? $storeName : "",
            ReportsKsnb::COLUMN_STORE_EMAIL_TPGD    => !empty($dataRequest['email_tpgd']) ? $dataRequest['email_tpgd'] : "",
            ReportsKsnb::COLUMN_USER_NAME           => !empty($dataRequest['user_name']) ? $dataRequest['user_name'] : "",
            ReportsKsnb::COLUMN_USER_EMAIL          => !empty($dataRequest['user_email']) ? $dataRequest['user_email'] : "",
            ReportsKsnb::COLUMN_CREATED_BY          => !empty($dataRequest['created_by']) ? $dataRequest['created_by'] : "",
            ReportsKsnb::COLUMN_ID_ROOM             => !empty($storeId) ? $storeId : "",
            ReportsKsnb::COLUMN_CONTENT             => !empty($dataRequest['content']) ? $dataRequest['content'] : "",
            ReportsKsnb::COLUMN_NAME_NOTE           => !empty($dataRequest['name_note']) ? $dataRequest['name_note'] : "",
            ReportsKsnb::COLUMN_EMAIL_NOTE          => !empty($dataRequest['email_note']) ? $dataRequest['email_note'] : "",
            ReportsKsnb::COLUMN_TITLE               => !empty($dataRequest['title']) ? $dataRequest['title'] : "",
        ];
        Log::channel('reportsksnb')->info("data input ". print_r($dataInput, true));
        $createNote = $this->ksnbRepository->createNote($dataInput);
        Log::channel('reportsksnb')->info('createNote' . print_r($createNote, true));
        if (!$createNote) {
            $response = [
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => BaseController::ERROR,
                BaseController::DATA => $dataInput
            ];
        } else {
            $response = [
                BaseController::STATUS => BaseController::HTTP_OK,
                BaseController::MESSAGE => BaseController::SUCCESS,
                BaseController::DATA => $createNote,
            ];
        }
        Log::channel('reportsksnb')->info('createNote response' . print_r($response, true));
        return response()->json($response);
    }


    /**
    * Api update Note
    * @param Illuminate\Http\Request
    * @param string $id
    * @return json
    */
    public function updateNote(Request $request, $id)
    {   
        $dataRequest = $request->all();
        Log::channel('reportsksnb')->info('request update Note :'  . print_r($dataRequest, true));
        $validator = Validator::make($dataRequest, [
            'content' => 'required',
            'name_note' => 'required',
            'email_note' => 'required',
            // 'url' => 'required',
            'title' => 'required',
        ], [
            'content.required' => 'Nội dung ghi nhận không để trống',
            'name_note.required' => 'Tên nhân viên không để trống',
            'email_note.required' => 'Email nhân viên không để trống',
            // 'url.required' => 'Ảnh không để trống',
            'title.required' => 'Tiêu đề phiếu ghi nhận không để trống',
        ]);
        Log::channel('reportsksnb')->info("validator ". $validator->fails());
        if($validator->fails()) {
            Log::channel('reportsksnb')->info('update Note validator' .$validator->errors()->first());
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $validator->errors()->first(),
            ]);
        }
        if (isset($dataRequest['store_name'])) {
            $storeId = $dataRequest['store_name'];
            $storeName = $this->roleRepository->getStoreName($storeId);
        } else {
            $storeId = '';
            $storeName = '';
        }

        $dataInput = [
            ReportsKsnb::COLUMN_IMAGE_PATH          => !empty($dataRequest['url']) ? $dataRequest['url'] : "",
            ReportsKsnb::COLUMN_STORE_ID            => !empty($storeId) ? $storeId : "",
            ReportsKsnb::COLUMN_STORE_NAME          => !empty($storeName) ? $storeName : "",
            ReportsKsnb::COLUMN_STORE_EMAIL_TPGD    => !empty($dataRequest['email_tpgd']) ? $dataRequest['email_tpgd'] : "",
            ReportsKsnb::COLUMN_USER_NAME           => !empty($dataRequest['user_name']) ? $dataRequest['user_name'] : "",
            ReportsKsnb::COLUMN_USER_EMAIL          => !empty($dataRequest['user_email']) ? $dataRequest['user_email'] : "",
            ReportsKsnb::COLUMN_CREATED_BY          => !empty($dataRequest['created_by']) ? $dataRequest['created_by'] : "",
            ReportsKsnb::COLUMN_ID_ROOM             => !empty($storeId) ? $storeId : "",
            ReportsKsnb::COLUMN_CONTENT             => !empty($dataRequest['content']) ? $dataRequest['content'] : "",
            ReportsKsnb::COLUMN_NAME_NOTE           => !empty($dataRequest['name_note']) ? $dataRequest['name_note'] : "",
            ReportsKsnb::COLUMN_EMAIL_NOTE          => !empty($dataRequest['email_note']) ? $dataRequest['email_note'] : "",
            ReportsKsnb::COLUMN_TITLE               => !empty($dataRequest['title']) ? $dataRequest['title'] : "",
        ];
        Log::channel('reportsksnb')->info("data input ". print_r($dataInput, true));
        $updateNote = $this->ksnbRepository->updateNote($dataInput, $id);
        $detail = $this->ksnbRepository->findNote($id);
        Log::channel('reportsksnb')->info('updateNote' . print_r($updateNote, true));
        if (!$updateNote) {
            $response = [
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => BaseController::ERRORS,
                BaseController::DATA => $dataInput
            ];
        } else {
            $response = [
                BaseController::STATUS => BaseController::HTTP_OK,
                BaseController::MESSAGE => BaseController::SUCCESS,
                BaseController::DATA => $detail,
            ];
        }
        Log::channel('reportsksnb')->info('updateNote response' . print_r($response, true));
        return response()->json($response);
    }

    public function getUserActive(Request $request) {
        $email_note = $request->input('user_email_note');
        if (!empty($email_note) && $user =  $this->userCpanelRepo->getAllEmailActive($email_note)) {
            $response = [
                BaseController::STATUS => BaseController::HTTP_OK,
                BaseController::MESSAGE => BaseController::SUCCESS,
                BaseController::DATA => $user,
            ];
        } else {
            $response = [
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => BaseController::ERRORS,
                BaseController::DATA => [],
            ];
        }
        return response()->json($response);
    }


    /**
    * Api update wait confirm Note
    * @param Illuminate\Http\Request
    * @param string $id
    * @return json
    */
    public function waitConfirmNote(Request $request, $id) {
        $dataRequest = $request->all();
        $detail = $this->ksnbRepository->findNote($id);
        Log::channel('reportsksnb')->info('request data wait confirm :'  . print_r($dataRequest, true));
        $waitConfirm = $this->ksnbRepository->waitConfirmNote($id);
        if (!$waitConfirm) {
            return response()->json([
                BaseController::STATUS => Response::HTTP_BAD_REQUEST,
                BaseController::MESSAGE=> BaseController::ERRORS,
                BaseController::DATA => [],
            ]);
        }
        $emailTBPKSNB = config('reportsksnb.TBPKSNB');
        $listEmailTBPKSNB = [];
        if ($emailTBPKSNB) {
            $listEmailTBPKSNB += $emailTBPKSNB;
        }
        $message = [
            'name_note'     => $detail['name_note'],
            'email_note'    => $detail['email_note'],
            "user_email"    => $listEmailTBPKSNB,
            "store_name"    => !empty($detail['store_name']) ? $detail['store_name'] : "",
            "email_nv"      => !empty($detail['user_email']) ? $detail['user_email'] : "",
            "name_nv"       => !empty($detail['user_name']) ? $detail['user_name'] : "",
            "urlItem"       => $dataRequest['urlItem'],
            "title"         => $detail['title'],
            "content"       => $detail['content'],
            "created_by"    => $detail['created_by'],
        ];
        $result = ApiCall::waitConfirmNote($message);
        Log::info('Api result:' . print_r($result, true));
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
        ]);
    }


    /**
    * Api update not confirm Note
    * @param Illuminate\Http\Request
    * @param string $id
    * @return json
    */
    public function notConfirmNote(Request $request, $id) {
        $dataRequest = $request->all();
        $detail = $this->ksnbRepository->findNote($id);
        Log::channel('reportsksnb')->info('request data not Confirm:' . print_r($dataRequest, true));
        $validator = Validator::make($dataRequest,[
            'reason_not_confirm' => 'required'
        ],[
            'reason_not_confirm.required' => "Lý do không duyệt không được để trống",
        ]);
        $input = [
            ReportsKsnb::COLUMN_REASON_NOT_CONFIRM  => $dataRequest['reason_not_confirm'],
        ];
        $notConfirm = $this->ksnbRepository->notConfirmNote($input, $id);
        if (!$notConfirm) {
            return response()->json([
                BaseController::STATUS => Response::HTTP_BAD_REQUEST,
                BaseController::MESSAGE=> BaseController::ERRORS,
                BaseController::DATA => [],
            ]);
        }
        // $user = $this->userCpanelRepo->findByEmail($detail['user_email']);
        $name = $this->userCpanelRepo->getUserNameByEmail($detail['created_by']);
        $emailTBPKSNB = config('reportsksnb.TBPKSNB');
        $listEmailTBPKSNB = [];
        if ($emailTBPKSNB) {
            $listEmailTBPKSNB += $emailTBPKSNB;
        }
        $message = [
            'name_note'     => $detail['name_note'],
            'email_note'    => $detail['email_note'],
            "user_email"    => $listEmailTBPKSNB,
            "store_name"    => !empty($detail['store_name']) ? $detail['store_name'] : "",
            "email_nv"      => !empty($detail['user_email']) ? $detail['user_email'] : "",
            "name_nv"       => !empty($detail['user_name']) ? $detail['user_name'] : "",
            "urlItem"       => $dataRequest['urlItem'],
            "title"         => $detail['title'],
            "content"       => $detail['content'],
            "created_by"    => $detail['created_by'],
            'reason_not_confirm' => $dataRequest['reason_not_confirm'],
            'name'          => $name[0]['full_name'],
        ];  
        $result = ApiCall::notConfirmNote($message);
        Log::info('Api result:' . print_r($result, true));
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
        ]);
    }

    /**
    * Api update reconfirm Note
    * @param Illuminate\Http\Request
    * @param string $id
    * @return json
    */
    public function reConfirmNote(Request $request, $id) {
        $dataRequest = $request->all();
        $detail = $this->ksnbRepository->findNote($id);
        Log::channel('reportsksnb')->info('request data Reconfirm :'  . print_r($dataRequest, true));
        $waitConfirm = $this->ksnbRepository->waitReConfirmNote($id);
        if (!$waitConfirm) {
            return response()->json([
                BaseController::STATUS => Response::HTTP_BAD_REQUEST,
                BaseController::MESSAGE=> BaseController::ERRORS,
                BaseController::DATA => [],
            ]);
        }
        $emailTBPKSNB = config('reportsksnb.TBPKSNB');
        $listEmailTBPKSNB = [];
        if ($emailTBPKSNB) {
            $listEmailTBPKSNB += $emailTBPKSNB;
        }
        $message = [
            'name_note'     => $detail['name_note'],
            'email_note'    => $detail['email_note'],
            "user_email"    => $listEmailTBPKSNB,
            "store_name"    => !empty($detail['store_name']) ? $detail['store_name'] : "",
            "email_nv"      => !empty($detail['user_email']) ? $detail['user_email'] : "",
            "name_nv"       => !empty($detail['user_name']) ? $detail['user_name'] : "",
            "urlItem"       => $dataRequest['urlItem'],
            "title"         => $detail['title'],
            "content"       => $detail['content'],
            "created_by"    => $detail['created_by'],
        ];
        $result = ApiCall::reConfirmNote($message);
        Log::info('Api result:' . print_r($result, true));
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
        ]);
    }


    /**
    * Api update confirm Note
    * @param Illuminate\Http\Request
    * @param string $id
    * @return json
    */
    public function confirmNote(Request $request, $id) {
        $dataRequest = $request->all();
        $detail = $this->ksnbRepository->findNote($id);
        Log::channel('reportsksnb')->info('request data confirm :'  . print_r($dataRequest, true));
        $confirm = $this->ksnbRepository->confirmNote($id);
        if (!$confirm) {
            return response()->json([
                BaseController::STATUS => Response::HTTP_BAD_REQUEST,
                BaseController::MESSAGE=> BaseController::ERRORS,
                BaseController::DATA => [],
            ]);
        }
        $emailTBPKSNB = config('reportsksnb.TBPKSNB');
        $listEmailTBPKSNB = [];
        if ($emailTBPKSNB) {
            $listEmailTBPKSNB += $emailTBPKSNB;
        }
        foreach ($detail['email_note'] as $item) {
            $name = $this->userCpanelRepo->getUserNameByEmail($item);
            $message = [
                'name_note'     => $detail['name_note'],
                'email_note'    => $detail['email_note'],
                "user_email"    => $listEmailTBPKSNB,
                "store_name"    => !empty($detail['store_name']) ? $detail['store_name'] : "",
                "email_nv"      => !empty($detail['user_email']) ? $detail['user_email'] : "",
                "name_nv"       => !empty($detail['user_name']) ? $detail['user_name'] : "",
                "urlItem"       => $dataRequest['urlItem'],
                "title"         => $detail['title'],
                "content"       => $detail['content'],
                "created_by"    => $detail['created_by'],
                "name"          => $name[0]['full_name'],
                'toEmail'       => $item,
            ];
            $result = ApiCall::confirmNote($message);
            Log::info('Api result:' . print_r($result, true));
        }
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
        ]);
    }


    /**
    * Api update user feedback Note
    * @param Illuminate\Http\Request
    * @param string $id
    * @return json
    */
    public function userFeedback(Request $request, $id) {
        $dataRequest = $request->all();
        $validator = Validator::make($dataRequest, [
            'comment' => 'required',
        ], [
            'comment.required' => 'Phản hồi không được để trống',
        ]);

        if($validator->fails()) {
            Log::channel('reportsksnb')->info('userfeedback validator' .$validator->errors()->first());
            return response()->json([
                BaseController::STATUS => Response::HTTP_BAD_REQUEST,
                BaseController::MESSAGE=>$validator->errors()->first(),
                BaseController::DATA => [],
            ]);
        }
        $detail = $this->ksnbRepository->findNote($id);
        Log::channel('reportsksnb')->info('userfeedback Item :'  . print_r($detail, true));
        $input = [
            ReportsKsnb::COLUMN_PROCESS  => ReportsKsnb::COLUMN_PROCESS_FEEDBACK ,
            ReportsKsnb::COLUMN_COMMENT  => $dataRequest['comment'],
            ReportsKsnb::COLUMN_CREATED_BY  => $dataRequest['email_feedback'],
        ];
        Log::channel('reportsksnb')->info('data input user feedback:' . print_r($input, true));
        $userFeedback = $this->ksnbRepository->userFeedBack($input, $id);
        if (!$userFeedback) {
            return response()->json([
                BaseController::STATUS => Response::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => BaseController::UPDATE_FAIL,
                BaseController::DATA => [],
            ]);
        }

        $emailTBPKSNB = config('reportsksnb.TBPKSNB');
        $listEmailTBPKSNB = [];
        if ($emailTBPKSNB) {
            $listEmailTBPKSNB += $emailTBPKSNB;
        }
        $listEmailTBPKSNB[] = $detail['created_by'];
        $userNameFeedBack = $this->userCpanelRepo->getUserNameByEmail($dataRequest['email_feedback']);
        $message = [
            'name_note'     => $detail['name_note'],
            'email_note'    => $detail['email_note'],
            "user_email"    => $listEmailTBPKSNB,
            "store_name"    => !empty($detail['store_name']) ? $detail['store_name'] : "",
            "email_nv"      => !empty($detail['user_email']) ? $detail['user_email'] : "",
            "name_nv"       => !empty($detail['user_name']) ? $detail['user_name'] : "",
            "urlItem"       => $dataRequest['urlItem'],
            "title"         => $detail['title'],
            "content"       => $detail['content'],
            'comment'       => $dataRequest['comment'],
            'name'          => $userNameFeedBack[0]['full_name'],
        ];
        $result = ApiCall::userFeedbackNote($message);
        Log::info('Api result:' . print_r($result, true));
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
        ]);
    }


    /**
    * Api update ksnb feedback Note
    * @param Illuminate\Http\Request
    * @param string $id
    * @return json
    */
    public function ksnbFeedback(Request $request, $id) {
        $dataRequest = $request->all();
        $detail = $this->ksnbRepository->findNote($id);
        Log::channel('reportsksnb')->info('data request ksnb feedback:' . print_r($dataRequest, true));
        $validator = Validator::make($dataRequest, [
            'ksnb_comment' => 'required',
        ], [
            'ksnb_comment.required' => 'Phản hồi không được để trống',
        ]);
        if($validator->fails()) {
            Log::channel('reportsksnb')->info('ksnbFeedback validator' .$validator->errors()->first());
            return response()->json([
                BaseController::STATUS => Response::HTTP_BAD_REQUEST,
                BaseController::MESSAGE=>$validator->errors()->first(),
                BaseController::DATA => [],
            ]);
        }
        $input = [
            ReportsKsnb::COLUMN_PROCESS  => ReportsKsnb::COLUMN_PROCESS_WAIT_FEEDBACK ,
            ReportsKsnb::COLUMN_KSNB_COMMENT  => $dataRequest['ksnb_comment'],
            ReportsKsnb::COLUMN_CREATED_BY => $dataRequest['email_feedback'],
        ];
        Log::channel('reportsksnb')->info('data input:' . print_r($input, true));
        $ksnbFeedback = $this->ksnbRepository->ksnbFeedback($input, $id);
        Log::channel('reportsksnb')->info('update:' . print_r($ksnbFeedback, true));
        if (!$ksnbFeedback) {
            return response()->json([
                BaseController::STATUS => Response::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => BaseController::UPDATE_FAIL,
                BaseController::DATA => [],
            ]);
        }
        $emailTBPKSNB = config('reportsksnb.TBPKSNB');
        $listEmailTBPKSNB = [];
        if ($emailTBPKSNB) {
            $listEmailTBPKSNB += $emailTBPKSNB;
        }
        $userNameFeedBack = $this->userCpanelRepo->getUserNameByEmail($dataRequest['email_feedback']);
        foreach ($detail['email_note'] as $item) {
            $name = $this->userCpanelRepo->getUserNameByEmail($item);
            $message = [
                'name_note'     => $detail['name_note'],
                'email_note'    => $detail['email_note'],
                "user_email"    => $listEmailTBPKSNB,
                "store_name"    => !empty($detail['store_name']) ? $detail['store_name'] : "",
                "email_nv"      => !empty($detail['user_email']) ? $detail['user_email'] : "",
                "name_nv"       => !empty($detail['user_name']) ? $detail['user_name'] : "",
                "urlItem"       => $dataRequest['urlItem'],
                "title"         => $detail['title'],
                "content"       => $detail['content'],
                "ksnb_comment"  => $dataRequest['ksnb_comment'],
                "name"          => $userNameFeedBack[0]['full_name'],
                'name_nv'       => $name[0]['full_name'],
                'toEmail'       => $item,
            ];
            $result = ApiCall::ksnbFeedbackNote($message);
            Log::info('Api result:' . print_r($result, true));
        }
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
        ]);
    }


    /**
    * Api update wait infer Note
    * @param Illuminate\Http\Request
    * @param string $id
    * @return json
    */
    public function waitInferNote(Request $request, $id) {
        $dataRequest = $request->all();
        $detail = $this->ksnbRepository->findNote($id);
        Log::channel('reportsksnb')->info('data request wait infer:' . print_r($dataRequest, true));
        $waitInfer = $this->ksnbRepository->waitInferNote($id);
        if (!$waitInfer) {
            return response()->json([
                BaseController::STATUS => Response::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => BaseController::UPDATE_FAIL,
                BaseController::DATA => [],
            ]);
        }
        $emailTBPKSNB = config('reportsksnb.TBPKSNB');
        $listEmailTBPKSNB = [];
        if ($emailTBPKSNB) {
            $listEmailTBPKSNB += $emailTBPKSNB;
        }
        $userName = $this->userCpanelRepo->getUserNameByEmail($detail['created_by']);
        $message = [
            'name_note'     => $detail['name_note'],
            'email_note'    => $detail['email_note'],
            "user_email"    => $listEmailTBPKSNB,
            "store_name"    => !empty($detail['store_name']) ? $detail['store_name'] : "",
            "email_nv"      => !empty($detail['user_email']) ? $detail['user_email'] : "",
            "name_nv"       => !empty($detail['user_name']) ? $detail['user_name'] : "",
            "urlItem"       => $dataRequest['urlItem'],
            "title"         => $detail['title'],
            "content"       => $detail['content'],
            'name'          => $userName[0]['full_name'],
        ];
        $result = ApiCall::waitInferNote($message);
        Log::info('Api result:' . print_r($result, true));
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
        ]);
    }


    /**
    * Api update infer Note
    * @param Illuminate\Http\Request
    * @param string $id
    * @return json
    */
    public function inferNote(Request $request, $id) {
        $dataRequest = $request->all();
        $detail = $this->ksnbRepository->findNote($id);
        Log::channel('reportsksnb')->info('data request ksnb feedback:' . print_r($dataRequest, true));
        $validator = Validator::make($dataRequest, [
            'infer' => 'required',
        ], [
            'infer.required' => 'Kết không được để trống',
        ]);
        if($validator->fails()) {
            Log::channel('reportsksnb')->info('infer validator' .$validator->errors()->first());
            return response()->json([
                BaseController::STATUS => Response::HTTP_BAD_REQUEST,
                BaseController::MESSAGE=>$validator->errors()->first(),
                BaseController::DATA => [],
            ]);
        }
        $input = [
            ReportsKsnb::COLUMN_PROCESS  => ReportsKsnb::COLUMN_PROCESS_BLOCK,
            ReportsKsnb::COLUMN_INFER  => $request['infer']
        ];
        Log::channel('reportsksnb')->info('data input:' . print_r($input, true));
        $infer = $this->ksnbRepository->inferNote($input, $id);
        Log::channel('reportsksnb')->info('update:' . print_r($infer, true));
        if (!$infer) {
            return response()->json([
                BaseController::STATUS => Response::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => BaseController::UPDATE_FAIL,
                BaseController::DATA => [],
            ]);
        }
        $emailTBPKSNB = config('reportsksnb.TBPKSNB');
        $listEmailTBPKSNB = [];
        if ($emailTBPKSNB) {
            $listEmailTBPKSNB += $emailTBPKSNB;
        }
        foreach ($detail['email_note'] as $item) {
            $name = $name = $this->userCpanelRepo->getUserNameByEmail($item);
            $message = [
                'name_note'     => $detail['name_note'],
                'email_note'    => $detail['email_note'],
                "user_email"    => $listEmailTBPKSNB,
                "store_name"    => !empty($detail['store_name']) ? $detail['store_name'] : "",
                "email_nv"      => !empty($detail['user_email']) ? $detail['user_email'] : "",
                "name_nv"       => !empty($detail['user_name']) ? $detail['user_name'] : "",
                "urlItem"       => $dataRequest['urlItem'],
                "title"         => $detail['title'],
                "content"       => $detail['content'],
                "infer"         => $dataRequest['infer'],
                "created_by"    => $detail['created_by'],
                'name'          => $name[0]['full_name'],
                'toEmail'       => $item,
            ];
            $result = ApiCall::inferNote($message);
            Log::info('Api result:' . print_r($result, true));
        }
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
        ]);
    }
}