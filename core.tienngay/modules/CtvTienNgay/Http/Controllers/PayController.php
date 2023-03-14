<?php

namespace Modules\CtvTienNgay\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\MongodbCore\Entities\Collaborator;
use Modules\MongodbCore\Entities\Lead;
use Modules\MongodbCore\Entities\AccountBank;
use Modules\MongodbCore\Repositories\BannerRepository;

class PayController extends Controller
{

    public function get_all_pay(Request $request)
    {

        //query
        $get_all = Lead::where('ctv_code', $request->id)
            ->orderBy('created_at', 'desc')
            ->where('date_pay', 'exists', true)
            ->when(\request()->datefrom, function ($query) {
                $query->where('date_pay', ">=", request()->datefrom);
            })
            ->when(\request()->dateto, function ($query) {
                $query->where('date_pay', "<=", request()->dateto);
            });
        $total = Lead::where('ctv_code', $request->id)
            ->orderBy('created_at', 'desc')
            ->where('date_pay', 'exists', true)
            ->when(\request()->datefrom, function ($query) {
                $query->where('date_pay', ">=", request()->datefrom);
            })
            ->when(\request()->dateto, function ($query) {
                $query->where('date_pay', "<=", request()->dateto);
            })
            ->count();


        $per_page = 15;
        $page = !empty($request->page) ? $request->page : 1;

        $result = $get_all->offset(($page - 1) * $per_page)->limit($per_page)->get();
        //get account_bank
        if (!empty($result)) {
            foreach ($result as $lead) {
                $account_bank = AccountBank::where('user_id', $lead['ctv_code'])
                    ->orderBy('created_at', 'DESC')
                    ->get();
                $lead['account_bank_core'] = $account_bank[0] ? $account_bank[0] : '';
            }
        }

        if (!empty($result)) {
            $responses = array(
                'status' => Response::HTTP_OK,
                'message' => "Thành công",
                'data' => $result,
                'total' => $total,
                'per_page' => $per_page
            );
            return response()->json($responses);
        } else {
            $responses = array(
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Không có dữ liệu",
            );
            return response()->json($responses);
        }


    }




}
