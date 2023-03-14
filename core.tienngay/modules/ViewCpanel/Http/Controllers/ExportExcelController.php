<?php

namespace Modules\ViewCpanel\Http\Controllers;

use Modules\ViewCpanel\Http\Controllers\BaseController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\Log;
use Modules\MongodbCore\Repositories\Interfaces\StoreRepositoryInterface as StoreRepository;

class ExportExcelController extends BaseController
{
    /**
    * Modules\MongodbCore\Repositories\StoreRepository
    */
    private $storeRepo;

    public function __construct(
        StoreRepository $storeRepository
    ) {
        $this->storeRepo = $storeRepository;
       $this->middleware('tokenIsValid');
    }


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function exportAllLead(Request $request)
    {   
        $dataGet = $request->all();
        $url = config('routes.api.exportAllLead');
        Log::info('Call Api: ' . $url . ' ' . print_r($dataGet, true));
        //call api
        $results = Http::asForm()->withHeaders(['Authorization' => $dataGet['access_token']])->post($url, $dataGet);
        Log::info('Result Api: ' . $url . ' ' . print_r($results->json(), true));
        $stores = $this->storeRepo->getAll();
        return view('viewcpanel::exportExcel.exportAllLead', [
            'results' => $results->json(),
            'filterUrl' => "",
            'stores' => $stores
        ]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function exportGic_plt(Request $request)
    {   
        $dataGet = $request->all();
        $url = config('routes.api.exportGicPlt');
        Log::info('Call Api: ' . $url . ' ' . print_r($dataGet, true));
        //call api
        $dataGet['selectField'] = [
            'contract_info.code_contract',
            'contract_info.code_contract_disbursement',
            'contract_info.loan_infor.amount_money',
            'contract_info.loan_infor.code_GIC_plt',
            'contract_info.code_contract',
            'contract_info.customer_infor.customer_BOD',
            'contract_info.created_by',
            'contract_info.chan_bao_hiem',
            'contract_info.store',
            'store',
            'gic_code',
            'gic_info.thongTinNguoiDuocBaoHiem_CaNhan_Ten',
            'gic_info.thongTinNguoiDuocBaoHiem_CaNhan_Email',
            'gic_info.thongTinNguoiDuocBaoHiem_CaNhan_SoDienThoai',
            'gic_info.thongTinNguoiDuocBaoHiem_CaNhan_SoCMND',
            'gic_info.thongTinNguoiDuocBaoHiem_CaNhan_DiaChi',
            'gic_info.noiDungBaoHiem_GiaTriKhoanVay',
            'gic_info.noiDungBaoHiem_PhiBaoHiem_VAT',
            'gic_info.noiDungBaoHiem_NgayHieuLucBaoHiem',
            'gic_info.noiDungBaoHiem_NgayHieuLucBaoHiemDen',
            'gic_info.thongTinChung_TrangThaiHdId',
            'created_at',
            'gic_info.TrangThaiHdId',
        ];
        $dataGet['export'] = true;
        $results = Http::asForm()->withHeaders(['Authorization' => $dataGet['access_token']])->post($url, $dataGet);
        Log::info('Result Api: ' . $url . ' ' . print_r($results->json(), true));
        $stores = $this->storeRepo->getAll();
        $tcvStores = $this->storeRepo->getTcvStores();
        $tcvDbStores = $this->storeRepo->getTcvDbStores();
        $tcvHcmStores = $this->storeRepo->getTcvHcmStores();
        return view('viewcpanel::exportExcel.exportGicPlt', [
            'results' => $results->json(),
            'filterUrl' => "",
            'stores' => $stores,
            'tcvStores' => $tcvStores,
            'tcvDbStores' => $tcvDbStores,
            'tcvHcmStores' => $tcvHcmStores,
        ]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function exportGic(Request $request)
    {   
        $dataGet = $request->all();
        $url = config('routes.api.exportGic');
        //call api
        $dataGet['selectField'] = [
            'contract_info.code_contract',
            'contract_info.code_contract_disbursement',
            'contract_info.loan_infor.amount_money',
            'contract_info.loan_infor.code_GIC_plt',
            'contract_info.code_contract',
            'contract_info.customer_infor.customer_BOD',
            'contract_info.created_by',
            'contract_info.chan_bao_hiem',
            'contract_info.store',
            'store',
            'gic_code',
            'gic_info.thongTinNguoiDuocBaoHiem_CaNhan_Ten',
            'gic_info.thongTinNguoiDuocBaoHiem_CaNhan_Email',
            'gic_info.thongTinNguoiDuocBaoHiem_CaNhan_SoDienThoai',
            'gic_info.thongTinNguoiDuocBaoHiem_CaNhan_SoCMND',
            'gic_info.thongTinNguoiDuocBaoHiem_CaNhan_DiaChi',
            'gic_info.noiDungBaoHiem_GiaTriKhoanVay',
            'gic_info.noiDungBaoHiem_PhiBaoHiem_VAT',
            'gic_info.noiDungBaoHiem_NgayHieuLucBaoHiem',
            'gic_info.noiDungBaoHiem_NgayHieuLucBaoHiemDen',
            'gic_info.thongTinChung_TrangThaiHdId',
            'created_at',
            'gic_info.TrangThaiHdId',
        ];
        $dataGet['export'] = true;
        Log::info('Call Api: ' . $url . ' ' . print_r($dataGet, true));
        $results = Http::asForm()->withHeaders(['Authorization' => $dataGet['access_token']])->post($url, $dataGet);
        Log::info('Result Api: ' . $url . ' ' . print_r($results->json(), true));
        $stores = $this->storeRepo->getAll();
        $tcvStores = $this->storeRepo->getTcvStores();
        $tcvDbStores = $this->storeRepo->getTcvDbStores();
        $tcvHcmStores = $this->storeRepo->getTcvHcmStores();
        return view('viewcpanel::exportExcel.exportGic', [
            'results' => $results->json(),
            'filterUrl' => "",
            'stores' => $stores,
            'tcvStores' => $tcvStores,
            'tcvDbStores' => $tcvDbStores,
            'tcvHcmStores' => $tcvHcmStores,
        ]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function exportGicEasy(Request $request)
    {   
        $dataGet = $request->all();
        $url = config('routes.api.exportGicEasy');
        //call api
        $dataGet['selectField'] = [
            'contract_info.code_contract',
            'contract_info.code_contract_disbursement',
            'contract_info.loan_infor.amount_money',
            'contract_info.loan_infor.code_GIC_easy',
            'contract_info.code_contract',
            'contract_info.customer_infor.customer_BOD',
            'contract_info.created_by',
            'contract_info.chan_bao_hiem',
            'contract_info.store',
            'store',
            'gic_code',
            'gic_info.thongTinNguoiDuocBaoHiem_CaNhan_Ten',
            'gic_info.thongTinNguoiDuocBaoHiem_CaNhan_Email',
            'gic_info.thongTinNguoiDuocBaoHiem_CaNhan_SoDienThoai',
            'gic_info.thongTinNguoiDuocBaoHiem_CaNhan_SoCMND',
            'gic_info.thongTinNguoiDuocBaoHiem_CaNhan_DiaChi',
            'gic_info.noiDungBaoHiem_GiaTriKhoanVay',
            'gic_info.noiDungBaoHiem_PhiBaoHiem_VAT',
            'gic_info.noiDungBaoHiem_NgayHieuLucBaoHiem',
            'gic_info.noiDungBaoHiem_NgayHieuLucBaoHiemDen',
            'gic_info.thongTinChung_TrangThaiHdId',
            'created_at',
            'gic_info.TrangThaiHdId',
        ];
        $dataGet['export'] = true;
        Log::info('Call Api: ' . $url . ' ' . print_r($dataGet, true));
        $results = Http::asForm()->withHeaders(['Authorization' => $dataGet['access_token']])->post($url, $dataGet);
        Log::info('Result Api: ' . $url . ' ' . print_r($results->json(), true));
        $stores = $this->storeRepo->getAll();
        $tcvStores = $this->storeRepo->getTcvStores();
        $tcvDbStores = $this->storeRepo->getTcvDbStores();
        $tcvHcmStores = $this->storeRepo->getTcvHcmStores();
        return view('viewcpanel::exportExcel.exportGicEasy', [
            'results' => $results->json(),
            'filterUrl' => "",
            'stores' => $stores,
            'tcvStores' => $tcvStores,
            'tcvDbStores' => $tcvDbStores,
            'tcvHcmStores' => $tcvHcmStores,
        ]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function exportMicTnds(Request $request)
    {   
        $dataGet = $request->all();
        $url = config('routes.api.exportMicTnds');
        $dataGet['export'] = true;
        Log::info('Call Api: ' . $url . ' ' . print_r($dataGet, true));
        $results = Http::asForm()->withHeaders(['Authorization' => $dataGet['access_token']])->post($url, $dataGet);
        Log::info('Result Api: ' . $url . ' ' . print_r($results->json(), true));
        $stores = $this->storeRepo->getAll();
        $tcvStores = $this->storeRepo->getTcvStores();
        $tcvDbStores = $this->storeRepo->getTcvDbStores();
        $tcvHcmStores = $this->storeRepo->getTcvHcmStores();
        return view('viewcpanel::exportExcel.exportMicTnds', [
            'results' => $results->json(),
            'filterUrl' => "",
            'stores' => $stores,
            'tcvStores' => $tcvStores,
            'tcvDbStores' => $tcvDbStores,
            'tcvHcmStores' => $tcvHcmStores,
        ]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function exportMic(Request $request)
    {   
        $dataGet = $request->all();
        $url = config('routes.api.exportMic');
        $dataGet['export'] = true;
        $dataGet['selectField'] = [
            'code_contract_disbursement',
            'mic_gcn',
            'contract_info.customer_infor.customer_name',
            'contract_info.customer_infor.customer_identify',
            'contract_info.customer_infor.customer_phone_number',
            'contract_info.customer_infor.customer_email',
            'contract_info.current_address',
            'contract_info.loan_infor.amount_money',
            'contract_info.loan_infor.amount_MIC',
            'NGAY_HL',
            'NGAY_KT',
            'store',
            'mic_fee',
            'created_at',
            'created_by',
            'status',
            'contract_info.chan_bao_hiem'
        ];
        Log::info('Call Api: ' . $url . ' ' . print_r($dataGet, true));
        $results = Http::asForm()->withHeaders(['Authorization' => $dataGet['access_token']])->post($url, $dataGet);
        Log::info('Result Api: ' . $url . ' ' . print_r($results->json(), true));
        $stores = $this->storeRepo->getAll();
        $tcvStores = $this->storeRepo->getTcvStores();
        $tcvDbStores = $this->storeRepo->getTcvDbStores();
        $tcvHcmStores = $this->storeRepo->getTcvHcmStores();
        return view('viewcpanel::exportExcel.exportMic', [
            'results' => $results->json(),
            'filterUrl' => "",
            'stores' => $stores,
            'tcvStores' => $tcvStores,
            'tcvDbStores' => $tcvDbStores,
            'tcvHcmStores' => $tcvHcmStores,
        ]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function exportContractTnds(Request $request)
    {   
        $dataGet = $request->all();
        $url = config('routes.api.exportContractTnds');
        $dataGet['export'] = true;
        $dataGet['selectField'] = [
            'contract_info.code_contract_disbursement',
            'contract_info.loan_infor.amount_money',
            'contract_info.customer_infor.customer_name',
            'contract_info.customer_infor.customer_BOD',
            'contract_info.customer_infor.customer_email',
            'contract_info.customer_infor.customer_phone_number',
            'contract_info.loan_infor.bao_hiem_tnds.type_tnds',
            'contract_info.loan_infor.bao_hiem_tnds.price_tnds',
            'contract_info.customer_infor.customer_identify',
            'contract_info.current_address',
            'contract_info.store',
            'data.NGAY_HL',
            'data.NGAY_KT',
            'created_at',
            'contract_info.created_by',
            'store',
            'data.response',
            'contract_info.chan_bao_hiem'
        ];
        Log::info('Call Api: ' . $url . ' ' . print_r($dataGet, true));
        $results = Http::asForm()->withHeaders(['Authorization' => $dataGet['access_token']])->post($url, $dataGet);
        Log::info('Result Api: ' . $url . ' ' . print_r($results->json(), true));
        $stores = $this->storeRepo->getAll();
        $tcvStores = $this->storeRepo->getTcvStores();
        $tcvDbStores = $this->storeRepo->getTcvDbStores();
        $tcvHcmStores = $this->storeRepo->getTcvHcmStores();
        return view('viewcpanel::exportExcel.exportContractTnds', [
            'results' => $results->json(),
            'filterUrl' => "",
            'stores' => $stores,
            'tcvStores' => $tcvStores,
            'tcvDbStores' => $tcvDbStores,
            'tcvHcmStores' => $tcvHcmStores,
            'type' => !empty($dataGet['type_tnds']) ? $dataGet['type_tnds'] : null
        ]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function exportVbiUtv(Request $request)
    {   
        $dataGet = $request->all();
        $url = config('routes.api.exportVbiUtv');
        $dataGet['export'] = true;
        $dataGet['selectField'] = [
            'contract_info.code_contract_disbursement',
            'contract_info.loan_infor.amount_money',
            'contract_info.customer_infor.customer_name',
            'contract_info.customer_infor.customer_BOD',
            'contract_info.customer_infor.customer_email',
            'contract_info.customer_infor.customer_phone_number',
            'contract_info.customer_infor.customer_identify',
            'contract_info.current_address',
            'contract_info.chan_bao_hiem',
            'type',
            'fee',
            'NGAY_HL',
            'NGAY_KT',
            'created_at',
            'created_by',
            'contract_info.store',
            'vbi_utv.response_code',
            'vbi_utv.so_id_vbi',
            'goi_bh'
        ];
        Log::info('Call Api: ' . $url . ' ' . print_r($dataGet, true));
        $results = Http::asForm()->withHeaders(['Authorization' => $dataGet['access_token']])->post($url, $dataGet);
        Log::info('Result Api: ' . $url . ' ' . print_r($results->json(), true));
        $stores = $this->storeRepo->getAll();
        $tcvStores = $this->storeRepo->getTcvStores();
        $tcvDbStores = $this->storeRepo->getTcvDbStores();
        $tcvHcmStores = $this->storeRepo->getTcvHcmStores();
        return view('viewcpanel::exportExcel.exportVbiUtv', [
            'results' => $results->json(),
            'filterUrl' => "",
            'stores' => $stores,
            'tcvStores' => $tcvStores,
            'tcvDbStores' => $tcvDbStores,
            'tcvHcmStores' => $tcvHcmStores
        ]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function exportVbiSxh(Request $request)
    {   
        $dataGet = $request->all();
        $url = config('routes.api.exportVbiSxh');
        $dataGet['export'] = true;
        $dataGet['selectField'] = [
            'contract_info.code_contract_disbursement',
            'contract_info.loan_infor.amount_money',
            'contract_info.customer_infor.customer_name',
            'contract_info.customer_infor.customer_BOD',
            'contract_info.customer_infor.customer_email',
            'contract_info.customer_infor.customer_phone_number',
            'contract_info.customer_infor.customer_identify',
            'contract_info.current_address',
            'contract_info.chan_bao_hiem',
            'type',
            'fee',
            'NGAY_HL',
            'NGAY_KT',
            'created_at',
            'created_by',
            'contract_info.store',
            'vbi_sxh.response_code',
            'vbi_sxh.so_id_vbi',
            'goi_bh'
        ];
        Log::info('Call Api: ' . $url . ' ' . print_r($dataGet, true));
        $results = Http::asForm()->withHeaders(['Authorization' => $dataGet['access_token']])->post($url, $dataGet);
        Log::info('Result Api: ' . $url . ' ' . print_r($results->json(), true));
        $stores = $this->storeRepo->getAll();
        $tcvStores = $this->storeRepo->getTcvStores();
        $tcvDbStores = $this->storeRepo->getTcvDbStores();
        $tcvHcmStores = $this->storeRepo->getTcvHcmStores();
        return view('viewcpanel::exportExcel.exportVbiSxh', [
            'results' => $results->json(),
            'filterUrl' => "",
            'stores' => $stores,
            'tcvStores' => $tcvStores,
            'tcvDbStores' => $tcvDbStores,
            'tcvHcmStores' => $tcvHcmStores,
        ]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function exportVbiSxhBn(Request $request)
    {   
        $dataGet = $request->all();
        $url = config('routes.api.exportVbiSxhBn');
        $dataGet['export'] = true;
        $dataGet['selectField'] = [
            'customer_info.customer_name',
            'vbi_sxh.so_id_vbi',
            'customer_info.email',
            'customer_info.customer_phone',
            'customer_info.cmt',
            'customer_info.address',
            'contract_info.chan_bao_hiem',
            'contract_info.store',
            'type',
            'fee',
            'NGAY_HL',
            'NGAY_KT',
            'created_at',
            'created_by',
            'vbi_sxh.response_code',
            'vbi_sxh.so_id_vbi',
            'goi_bh',
            'store'
        ];
        Log::info('Call Api: ' . $url . ' ' . print_r($dataGet, true));
        $results = Http::asForm()->withHeaders(['Authorization' => $dataGet['access_token']])->post($url, $dataGet);
        Log::info('Result Api: ' . $url . ' ' . print_r($results->json(), true));
        $stores = $this->storeRepo->getAll();
        $tcvStores = $this->storeRepo->getTcvStores();
        $tcvDbStores = $this->storeRepo->getTcvDbStores();
        $tcvHcmStores = $this->storeRepo->getTcvHcmStores();
        return view('viewcpanel::exportExcel.exportVbiSxhBn', [
            'results' => $results->json(),
            'filterUrl' => "",
            'stores' => $stores,
            'tcvStores' => $tcvStores,
            'tcvDbStores' => $tcvDbStores,
            'tcvHcmStores' => $tcvHcmStores,
        ]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function exportVbiUtvBn(Request $request)
    {   
        $dataGet = $request->all();
        $url = config('routes.api.exportVbiUtvBn');
        $dataGet['export'] = true;
        $dataGet['selectField'] = [
            'customer_info.customer_name',
            'vbi_utv.so_id_vbi',
            'customer_info.email',
            'customer_info.customer_phone',
            'customer_info.cmt',
            'customer_info.address',
            'contract_info.chan_bao_hiem',
            'contract_info.store',
            'type',
            'fee',
            'NGAY_HL',
            'NGAY_KT',
            'created_at',
            'created_by',
            'vbi_utv.response_code',
            'vbi_utv.so_id_vbi',
            'goi_bh',
            'store'
        ];
        Log::info('Call Api: ' . $url . ' ' . print_r($dataGet, true));
        $results = Http::asForm()->withHeaders(['Authorization' => $dataGet['access_token']])->post($url, $dataGet);
        Log::info('Result Api: ' . $url . ' ' . print_r($results->json(), true));
        $stores = $this->storeRepo->getAll();
        $tcvStores = $this->storeRepo->getTcvStores();
        $tcvDbStores = $this->storeRepo->getTcvDbStores();
        $tcvHcmStores = $this->storeRepo->getTcvHcmStores();
        return view('viewcpanel::exportExcel.exportVbiUtvBn', [
            'results' => $results->json(),
            'filterUrl' => "",
            'stores' => $stores,
            'tcvStores' => $tcvStores,
            'tcvDbStores' => $tcvDbStores,
            'tcvHcmStores' => $tcvHcmStores,
        ]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function exportVbiTnds(Request $request)
    {   
        $dataGet = $request->all();
        $url = config('routes.api.exportVbiTnds');
        $dataGet['export'] = true;
        $dataGet['selectField'] = [
            'customer_info.customer_name',
            'vbi_tnds.so_id_vbi',
            'customer_info.email',
            'customer_info.customer_phone',
            'customer_info.cmt',
            'customer_info.address',
            'contract_info.chan_bao_hiem',
            'contract_info.store',
            'type',
            'fee',
            'NGAY_HL',
            'NGAY_KT',
            'created_at',
            'created_by',
            'vbi_tnds.response_code',
            'code',
            'store'
        ];
        Log::info('Call Api: ' . $url . ' ' . print_r($dataGet, true));
        $results = Http::asForm()->withHeaders(['Authorization' => $dataGet['access_token']])->post($url, $dataGet);
        Log::info('Result Api: ' . $url . ' ' . print_r($results->json(), true));
        $stores = $this->storeRepo->getAll();
        $tcvStores = $this->storeRepo->getTcvStores();
        $tcvDbStores = $this->storeRepo->getTcvDbStores();
        $tcvHcmStores = $this->storeRepo->getTcvHcmStores();
        return view('viewcpanel::exportExcel.exportVbiTnds', [
            'results' => $results->json(),
            'filterUrl' => "",
            'stores' => $stores,
            'tcvStores' => $tcvStores,
            'tcvDbStores' => $tcvDbStores,
            'tcvHcmStores' => $tcvHcmStores,
        ]);
    }
}
