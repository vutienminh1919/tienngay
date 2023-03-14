<?php

namespace Modules\PaymentGateway\Http\Controllers;

use Modules\PaymentGateway\Http\Controllers\BaseController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Modules\MysqlCore\Repositories\Interfaces\MoMoAppRepositoryInterface;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MoMoAppController extends BaseController
{

    /**
     * @OA\Info(
     *     version="1.0",
     *     title="API Momo Payment"
     * )
     */
    private $momoAppRepository;

    public function __construct(MoMoAppRepositoryInterface $momoAppRepository) {
       $this->momoAppRepository = $momoAppRepository;
    }

    /**
     * @OA\Post(
     *     path="/paymentgateway/momo/getBillInfo",
     *     tags={"paymentgateway"},
     *     operationId="update",
     *     summary="create bill information of contract and save transaction",
     *     description="create bill information of contract from api.tienngay/view_payment/getPaymentInfo api ",
     *     @OA\RequestBody(
     *         description="",
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="requestId",type="string"),
     *                  @OA\Property(property="reference1",type="string"),
     *                  @OA\Property(property="paymentOption",type="number")
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="get data successfully",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="get data failed",
     *     ),
     *     security={
     *         {"api_key": {}}
     *     },
     * )
     */
    public function getBillInfo(Request $request) {
        if (config('paymentgateway.momoCrypto')) {
            $requestData = json_decode($this->decryptDataMomo($request->getContent())["data"], true);
        } else {
            $requestData = $request->all();
        }
        $contractId = !empty($requestData["reference1"]) ? $requestData["reference1"] : "";
        $requestId = !empty($requestData["requestId"]) ? $requestData["requestId"] : "";
        Log::channel('momo')->info('momo requested: ' . print_r($requestData, true));
        $validator = Validator::make($requestData, [
            'requestId' => 'required|string|max:50',
            'reference1' => 'required|string|max:50',
        ]);
        if ($validator->fails()) {
            Log::channel('momo')->info('validate error: ' . print_r($validator->errors(), true));
            $response = [
                'requestId' => $requestId,
                'reference1' => $contractId,
                'resultCode' => config('paymentgateway.momoResultCode.INVALID_REFERENCE1'),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $validator->errors()->first()
            ];
            Log::channel('momo')->info('momo bill info: ' . print_r($response, true));
            if (config('paymentgateway.momoCrypto')) {
                return $this->encryptDataMoMo($response);
            } else {
                return response()->json($response);
            }
        }

        //call api
        $detainPaymentData = $this->callApiGetPaymentInfo($contractId);
        // call api failed
        if ($detainPaymentData["status"] != Response::HTTP_OK) {
            $response = [
                'requestId' => $requestId,
                'reference1' => $contractId,
                'resultCode' => config('paymentgateway.momoResultCode.DATA_NOT_FOUND'),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => __('PaymentGateway::messages.get_data_failed')
            ];
            if (config('paymentgateway.momoCrypto')) {
                return $this->encryptDataMoMo($response);
            } else {
                return response()->json($response);
            }

        }
        if ($detainPaymentData["tong_tien_tat_toan"] <= 0) {
            $response = [
                'requestId' => $requestId,
                'reference1' => $contractId,
                'resultCode' => config('paymentgateway.momoResultCode.DATA_NOT_FOUND'),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => __('PaymentGateway::messages.get_data_failed')
            ];
            if (config('paymentgateway.momoCrypto')) {
                return $this->encryptDataMoMo($response);
            } else {
                return response()->json($response);
            }
        }

        if (
            !empty($detainPaymentData["contractDB"]["status"]) 
            && $detainPaymentData["contractDB"]["status"] == config('paymentgateway.CONTRACT_COMPLETED')
        ) {
            $response = [
                'requestId' => $requestId,
                'reference1' => $contractId,
                'resultCode' => config('paymentgateway.momoResultCode.CONTRACT_COMPLETED'),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => __('PaymentGateway::messages.contract_has_been_completed')
            ];
            if (config('paymentgateway.momoCrypto')) {
                return $this->encryptDataMoMo($response);
            } else {
                return response()->json($response);
            }
        }


        //create response
        $response = $this->createBill($detainPaymentData, $requestData);

        Log::channel('momo')->info('momo bill info: ' . print_r($response, true));
        if (config('paymentgateway.momoCrypto')) {
            return $this->encryptDataMoMo($response);
        } else {
            return response()->json($response);
        }

    }

    /**
     * payment contract request to Api server.
     *
     * @param  Array  $data
     * @return Colection
     */
    protected function callApiPaymentContract($data) {
        $url = $this->getApiUrl('transaction/auto_payment_contract');

        $dataPost = array(
            "amount_total" => $data['total_amount'],
            "valid_amount" => $data['total_amount'],
            "penalty_pay" => $data['late_fee'],
            "total" => $data['paid_amount'],
            "valid_amount" => $data['total_amount'],
            "type_payment" => config('paymentgateway.CONTRACT_TYPE_PAYMENT_TERM'), // 1: thanh toán lãi kỳ, 2: gia hạn, 3: cơ cấu, 4: thanh toán hợp đồng đã thanh lý tài sản.
            "note" => "MoMoApp - Thanh toán lãi kỳ",
            "code_contract" => $data['contract_code'],
            "payment_method" => $data['epayment_code'],// 1:tiền mặt, 2: ck, 3: momoApp
            "type_pt" => config('paymentgateway.CONTRACT_TYPE_TERM'), //3 tat toan. 4 thanh toan ky lai. 5 gia han hop dong
            "date_pay" => $data['paid_date'],
            "created_by" => "MoMo",
            "code_transaction_bank" => $data['transactionId'],
            "discounted_fee" => abs($data['discounted_fee']),
            "total_deductible" => abs($data['discounted_fee']),
        );
        Log::channel('momo')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);

        Log::channel('momo')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return $result;
    }

    /**
     * payment final settlement contract request to Api server.
     *
     * @param  Array  $data
     * @return Colection
     */
    protected function callApiPaymentFinalSettlement($data) {
        $url = $this->getApiUrl('transaction/auto_payment_contract');

        $dataPost = array(
            "amount_total" => $data['total_amount'],
            "valid_amount" => $data['total_amount'],
            "penalty_pay" => $data['late_fee'],
            "total" => $data['paid_amount'],
            "valid_amount" => $data['total_amount'],
            "type_payment" => config('paymentgateway.CONTRACT_TYPE_PAYMENT_TERM'), // 1: thanh toán lãi kỳ, 2: gia hạn, 3: cơ cấu, 4: thanh toán hợp đồng đã thanh lý tài sản.
            "note" => "MoMoApp - Tất toán HĐ",
            "code_contract" => $data['contract_code'],
            "payment_method" => $data['epayment_code'],// 1:tiền mặt, 2: ck, 3: momoApp
            "type_pt" => config('paymentgateway.CONTRACT_TYPE_FINAL_SETTLEMENT'), //3 tat toan. 4 thanh toan ky lai. 5 gia han hop dong
            "date_pay" => $data['paid_date'],
            "created_by" => "MoMo",
            "code_transaction_bank" => $data['transactionId'],
            "discounted_fee" => abs($data['discounted_fee']),
            "total_deductible" => abs($data['discounted_fee']),
        );
        Log::channel('momo')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));
        //call api
        $result = Http::asForm()->post($url, $dataPost);

        Log::channel('momo')->info('Result Api: ' . $url . ' ' . print_r($result->json(), true));
        return $result;
    }

    protected function countdownToLastTerm($contractData) {
    	$lastTerm = last($contractData["data"]);
    	$targetDate = $lastTerm["ngay_ky_tra"];
    	$currentDate = time();
    	$timeLeft = $targetDate - $currentDate;

    	return floor($timeLeft / (24*60*60)) + 1; //convert value to date
    }

    /**
    * Get dua date at current term
    * @param  Array  $contractData
    * @return String
    */
    protected function getDueDateTerm($contractData) {
        $currentTerm = [];
        foreach ($contractData["data"] as $key => $value) {
            if ($value["status"] == 1) {
                if (empty($currentTerm)) {
                    $currentTerm = $value;
                } else {
                    if ($currentTerm["ky_tra"] >  $value["ky_tra"]) {
                        $currentTerm = $value;
                    }
                }
            }
        }
        if (empty($currentTerm)) {
            $targetDate = time();
        } else {
            $targetDate = $currentTerm["ngay_ky_tra"];
        }

        return date('d/m/Y', $targetDate);
    }

    /**
    * Get dua date at final term
    * @param  Array  $contractData
    * @return String
    */
    protected function getDueDateFinalTerm($contractData) {
        $lastTerm = last($contractData["data"]);
        $targetDate = $lastTerm["ngay_ky_tra"];
        return date('d/m/Y', $targetDate);
    }

    protected function createBill($detainPaymentData, $requestData = null) {
        $contractData = $detainPaymentData["contractDB"];
        //$paymentOption = config('paymentgateway.PAYMENT_TERM'); // defaul thanh toán kỳ
        
        if ($detainPaymentData["tong_tien_thanh_toan"] >= $detainPaymentData["tong_tien_tat_toan"]) {
            $paymentOption = config('paymentgateway.FINAL_SETTLEMENT');
        } else {
            $paymentOption = config('paymentgateway.PAYMENT_TERM');
        }
    	$timeLeft = $this->countdownToLastTerm($contractData);
    	$billInfo = [];

    	if($timeLeft <= 5 || $paymentOption == config('paymentgateway.FINAL_SETTLEMENT')) {
    	// range of last term date - 5days or payment option is final settlement

            $paymentOption = config('paymentgateway.FINAL_SETTLEMENT'); //if timeLeft <= 5
    		$billInfo = $this->getFinalSettlementMoney($detainPaymentData);
    	} else {
            if (round($detainPaymentData["tong_tien_thanh_toan"]) > 0) {
                 // non-performing loan or payment at current term
                $billInfo = $this->getRemainingUnpaidAtCurrentTerm($detainPaymentData);
            } else {
                //get payment at next term
                $billInfo = $this->getRemainingUnpaidAtNextTerm($detainPaymentData);

                if ($billInfo["total"]["value"] > $detainPaymentData["tong_tien_tat_toan"]) {
                    $paymentOption = config('paymentgateway.FINAL_SETTLEMENT');
                    $billInfo = $this->getFinalSettlementMoney($detainPaymentData);
                }
            }

    	}
        if ($requestData == null) {
            if ($paymentOption == config('paymentgateway.FINAL_SETTLEMENT')) {
                $billInfo["dueDate"] = $this->getDueDateFinalTerm($contractData);
            } else {
                $billInfo["dueDate"] = $this->getDueDateTerm($contractData);
            }
            return $billInfo;
        }

        $contractId = $requestData["reference1"];
        $requestId = $requestData["requestId"];

        $dataSave = [];
        $dataSave['request_check_bill'] = $requestId;
        $dataSave['contract_id'] = $contractId;
        $dataSave['contract_code'] = $contractData["code_contract"];
        $dataSave['contract_code_disbursement'] = $contractData["code_contract_disbursement"];
        $dataSave['contract_store_id'] = $contractData["store"]["id"];
        $dataSave['contract_store_name'] = $contractData["store"]["name"];
        $dataSave['payment_option'] = $paymentOption;
        $dataSave['total_amount'] = $billInfo["total"]["value"];
        $dataSave['name'] = $contractData["customer_infor"]["customer_name"];
        $dataSave['email'] = $contractData["customer_infor"]["customer_email"];
        $dataSave['mobile'] = $contractData["customer_infor"]["customer_phone_number"];
        $dataSave['identity_card'] = $contractData["customer_infor"]["customer_identify"];
        $dataSave['debt_amount'] = !empty($billInfo["details"]["debt_amount"]) ? $billInfo["details"]["debt_amount"]["value"]: 0;
        $dataSave['late_fee'] = !empty($billInfo["details"]["late_fee"]) ? $billInfo["details"]["late_fee"]["value"]: 0;
        $dataSave['actual_unpaid_fee'] = !empty($billInfo["details"]["actual_unpaid_fee"]) ? $billInfo["details"]["actual_unpaid_fee"]["value"]: 0;
        $dataSave['early_repayment_charge'] = !empty($billInfo["details"]["early_repayment_charge"]) ? $billInfo["details"]["early_repayment_charge"]["value"]: 0;
        $dataSave['cost_incurred'] = !empty($billInfo["details"]["cost_incurred"]) ? $billInfo["details"]["cost_incurred"]["value"]: 0;
        $dataSave['unpaid_money'] = !empty($billInfo["details"]["unpaid_money"]) ? $billInfo["details"]["unpaid_money"]["value"]: 0;
        $dataSave['balance_prev_term'] = !empty($billInfo["details"]["balance_prev_term"]) ? $billInfo["details"]["balance_prev_term"]["value"]: 0;
        $dataSave['excess_payment'] = !empty($billInfo["details"]["excess_payment"]) ? $billInfo["details"]["excess_payment"]["value"]: 0;
        $dataSave['next_payment_amount'] = !empty($billInfo["details"]["next_payment_amount"]) ? $billInfo["details"]["next_payment_amount"]["value"]: 0;
        $dataSave['discounted_fee'] = !empty($billInfo["details"]["discounted_fee"]) ? $billInfo["details"]["discounted_fee"]["value"]: 0;

        // Save Data
        $transactionSaved = $this->momoAppRepository->store($dataSave);

        // Create Response
    	$response = [];
    	$response["requestId"] = $requestId;
        $response["reference1"] = $contractId;
        $response["transactionId"] = str_pad($transactionSaved->id, 10, "0", STR_PAD_LEFT);
        $response["status"] = Response::HTTP_OK;
        $response["message"] = __('PaymentGateway::messages.get_data_success');
    	$response["resultCode"] = config('paymentgateway.momoResultCode.SUCCESS');
    	$response["totalAmount"] = $billInfo["total"]["value"];
    	$response["description"] = $billInfo["total"]["description"];
        if ($paymentOption == config('paymentgateway.FINAL_SETTLEMENT')) {
            $response["dueDate"] = $this->getDueDateFinalTerm($contractData);
        } else {
            $response["dueDate"] = $this->getDueDateTerm($contractData);
        }
    	$response["accountInfo"] = [];
    	$response["accountInfo"]["name"] = $contractData["customer_infor"]["customer_name"];
    	$response["accountInfo"]["email"] = $contractData["customer_infor"]["customer_email"];
    	$response["accountInfo"]["mobile"] = $this->hideNumberOfPhone($contractData["customer_infor"]["customer_phone_number"]);
        $response["timeLeft"] = $timeLeft;
    	return $response;
    }

    // Calculate momo fee 0.6% + 12000
    protected function transactionFee($paidAmount) {
        if (is_numeric($paidAmount) && $paidAmount > 0) {
            return ($paidAmount*0.006 + 12000);
        }
        return 0;
    }

    protected function getFinalSettlementMoney($detainPaymentData) {
    	$finalSettlement1 = $detainPaymentData["dataTatToanPart1"];
    	$contractDB = $detainPaymentData["contractDB"];
    	$debtData = $detainPaymentData["debtData"];
    	// Số dư nợ còn lại
    	$debtAmount = !empty($finalSettlement1["du_no_con_lai"]) ? $finalSettlement1["du_no_con_lai"] : 0;
    	// Tiền phí thực tế chưa thanh toán
    	$actualUnpaidFee = !empty($finalSettlement1["phi_chua_tra_den_thoi_diem_hien_tai"]) ? $finalSettlement1["phi_chua_tra_den_thoi_diem_hien_tai"] : 0;
    	// Tiền phí phát sinh
 	 	$costIncurred = !empty($contractDB["phi_phat_sinh"]) ? $contractDB["phi_phat_sinh"] : 0;
 	 	// Phí phạt chậm trả
 	 	$lateFee = !empty($contractDB["penalty_pay"]) ? $contractDB["penalty_pay"] : 0;
 	 	// Tổng phí phạt còn lại
  		$totalPenaltyOther = !empty($contractDB["tong_penalty_con_lai"]) ? $contractDB["tong_penalty_con_lai"] : 0;
  		// Phí tất toán trước hạn
  		$earlyRepaymentCharge = !empty($debtData["phi_thanh_toan_truoc_han"]) ? $debtData["phi_thanh_toan_truoc_han"] : 0;
  		// Tiền còn thiếu ở kỳ đã được gạch nợ(Sau 18/4/2021: Số tiền để được gạch nợ phải >= tổng số tiền kỳ -12k và <= tổng số tiền kỳ)
  		$unpaidMoney = !empty($contractDB["tien_chua_tra_ky_thanh_toan"]) ? $contractDB["tien_chua_tra_ky_thanh_toan"] : 0;
  		// Số dư của kỳ trước
  		$balanceOfPreviousTerm = !empty($contractDB["tien_du_ky_truoc"]) ? $contractDB["tien_du_ky_truoc"] : 0;
  		// Tiền dư khi thanh toán
  		$excessPayment = !empty($contractDB["tien_thua_thanh_toan"]) ? $contractDB["tien_thua_thanh_toan"] : 0;
        $discountedFee = !empty($detainPaymentData["giam_tru_tat_toan"]) ? $detainPaymentData["giam_tru_tat_toan"] : 0;
        $finalSettlementMoney = $detainPaymentData["tong_tien_tat_toan"];

       	$result = [
       		'total' => [
				'value' => round($finalSettlementMoney),
				'description' => __('PaymentGateway::messages.final_settlement_monney')
			],
			'details' => [
				'debt_amount' => [
					'value' => ceil($debtAmount),
					'description' => __('PaymentGateway::messages.debt_amount')
				],
	       		'late_fee' => [
					'value' => ceil($lateFee),
					'description' => __('PaymentGateway::messages.late_fee')
				],
	       		'actual_unpaid_fee'	=> [
					'value' => ceil($actualUnpaidFee),
					'description' => __('PaymentGateway::messages.actual_unpaid_fee')
				],
	       		'early_repayment_charge' => [
					'value' => ceil($earlyRepaymentCharge),
					'description' => __('PaymentGateway::messages.early_repayment_charge')
				],
	       		'cost_incurred' => [
					'value' => ceil($costIncurred),
					'description' => __('PaymentGateway::messages.cost_incurred')
				],
	       		'unpaid_money' => [
					'value' => ceil($unpaidMoney),
					'description' => __('PaymentGateway::messages.unpaid_money_of_the_previous_term')
				],
	       		'balance_prev_term' => [
					'value' => ceil(-$balanceOfPreviousTerm),
					'description' => __('PaymentGateway::messages.balance_of_previous_term')
				],
                'excess_payment' => [
                    'value' => ceil(-$excessPayment),
                    'description' => __('PaymentGateway::messages.excess_payment')
                ],
	       		'discounted_fee' => [
					'value' => -$discountedFee,
					'description' => __('PaymentGateway::messages.discounted_fee_final_settlement')
				],
			]

       	];
        return $result;
    }

    protected function getRemainingUnpaidAtCurrentTerm($detainPaymentData) {
    	$data = $detainPaymentData["contractDB"];
    	$total = !empty($detainPaymentData["tong_tien_thanh_toan"]) ? $detainPaymentData["tong_tien_thanh_toan"] : 0;
    	$lateFee = !empty($data["penalty_pay"]) ? $data["penalty_pay"] : 0;
    	$costIncurred = !empty($data["phi_phat_sinh"]) ? $data["phi_phat_sinh"] : 0;
        $discountedFee = !empty($detainPaymentData["giam_tru_thanh_toan"]) ? $detainPaymentData["giam_tru_thanh_toan"] : 0;
    	$result = [
			'total' => [
				'value' => round($total),
				'description' => __('PaymentGateway::messages.total_payment_of_the_current_term')
			],
			'details' => [
				'late_fee' => [
					'value' => ceil($lateFee),
					'description' => __('PaymentGateway::messages.late_fee')
				],
				'cost_incurred' => [
					'value' => ceil($costIncurred),
					'description' => __('PaymentGateway::messages.cost_incurred')
				],
                'discounted_fee' => [
                    'value' => -$discountedFee,
                    'description' => __('PaymentGateway::messages.discounted_fee_payment_term')
                ],
			]
		];

		return $result;

    }

    protected function getRemainingUnpaidAtNextTerm($detainPaymentData) {
        $contractData = $detainPaymentData["contractDB"];
    	$nextTerm = [];

    	// Get Infomation of next term
    	foreach ($contractData["data"] as $key => $value) {
    		if ($value["status"] == 1) {
    			if (empty($nextTerm)) {
    				$nextTerm = $value;
    			} else {
    				if ($nextTerm["ky_tra"] >  $value["ky_tra"]) {
    					$nextTerm = $value;
    				}
    			}
    		}
    	}

    	if (empty($nextTerm)) {

            // if the next term's infomation is empty, return final settlement infomation
    		return $this->getFinalSettlementMoney($detainPaymentData);
    	}

    	$fee_delay_pay=(!empty($contract->fee_delay_pay)) ? $contract->fee_delay_pay :

    	// Tiền phí chậm trả mà kh đã thanh toán.
    	$paidLateFee = (!empty($nextTerm["tien_phi_cham_tra_1ky_da_tra"])) ? (float)$nextTerm["tien_phi_cham_tra_1ky_da_tra"] :  0;
    	// Phí chậm trả hiện tại
		$currentLateFee = (!empty($nextTerm["fee_delay_pay"])) ? $nextTerm["fee_delay_pay"] : 0;
		// Số tiền thanh toán của kỳ tiếp theo
		$paymentAmount = (float)$nextTerm["tien_tra_1_ky"];

		// Tiền thừa khi thanh toán ở kỳ trước.
		$excessPayment =  (float)$nextTerm["da_thanh_toan"] + $paidLateFee;

        $discountedFee = !empty($detainPaymentData["giam_tru_thanh_toan"]) ? $detainPaymentData["giam_tru_thanh_toan"] : 0;

		// Dư nợ còn lại của kỳ
		$debtAmount = ceil($paymentAmount + $currentLateFee - $excessPayment - $discountedFee);

		$result = [
			'total' => [
				'value' => round($debtAmount),
				'description' => __('PaymentGateway::messages.total_payment_of_the_next_term')
			],
			'details' => [
				'next_payment_amount' => [
					'value' => ceil($paymentAmount),
					'description' => __('PaymentGateway::messages.payment_amount_of_the_next_term')
				],
				'late_fee' => [
					'value' => ceil($currentLateFee),
					'description' => __('PaymentGateway::messages.current_late_fee')
				],
				'excess_payment' => [
					'value' => ceil(-$excessPayment),
					'description' => __('PaymentGateway::messages.excess_payment')
				],
                'discounted_fee' => [
                    'value' => -$discountedFee,
                    'description' => __('PaymentGateway::messages.discounted_fee_payment_term')
                ],
			]
		];

		return $result;
    }

    /**
     * @OA\Post(
     *     path="/paymentgateway/momo/notifyPaymentResult",
     *     tags={"paymentgateway"},
     *     operationId="update",
     *     summary="update transaction status",
     *     description="get transaction status from patner momo and update data to epayment_transaction table",
     *     @OA\RequestBody(
     *         description="",
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="requestId",type="string"),
     *                  @OA\Property(property="transactionId",type="string"),
     *                  @OA\Property(property="reference1",type="string"),
     *                  @OA\Property(property="amount",type="number"),
     *                  @OA\Property(property="date",type="string")
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="get data successfully",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="get data failed",
     *     ),
     *     security={
     *         {"api_key": {}}
     *     },
     * )
     */
    public function notifyPaymentResult(Request $request) {
        if (config('paymentgateway.momoCrypto')) {
            $reqData = json_decode($this->decryptDataMomo($request->getContent())["data"], true);
        } else {
            $reqData = $request->all();
        }
        Log::channel('momo')->info('momo notify payment requested: ' . print_r($reqData, true));
        $transactionId = $reqData['reference1']; // Tien ngay transaction id
        $requestId = $reqData['requestId'];
        $momoTransactionId = $reqData['transactionId'];
        $transactionDate = $reqData['date'];
        $attributes = [];
        $attributes['requestId'] = $requestId;
        $attributes['transactionId'] = (int) $momoTransactionId; // MoMo transaction id
        $attributes['amount'] = $reqData['amount'];

        $validator = Validator::make($reqData, [
            'requestId' => 'required|string|max:50',
            'reference1' => 'required|string|max:50',
            'transactionId' => 'required|string|max:50',
            'amount' => 'required|numeric',
            'date' => 'required|string|max:50',
        ]);
        if ($validator->fails()) {
            Log::channel('momo')->info('validate error: ' . print_r($validator->errors(), true));
            $response = [
                'requestId' => $requestId,
                'transactionId' => $momoTransactionId,
                'reference1' => $transactionId,
                'resultCode' => config('paymentgateway.momoResultCode.INVALID_REFERENCE1'),
                'status' => Response::HTTP_OK,
                'message' => $validator->errors()->first(),
            ];
            Log::channel('momo')->info('momo notify payment -> response: ' . print_r($response, true));
            if (config('paymentgateway.momoCrypto')) {
                return $this->encryptDataMoMo($response);
            } else {
                return response()->json($response);
            }
        }
        try {
            $date = new DateTime($transactionDate);
        } catch (Exception $e) {
            Log::channel('momo')->info('validate error: ' . print_r($e, true));
            $response = [
                'requestId' => $requestId,
                'transactionId' => $momoTransactionId,
                'reference1' => $transactionId,
                'date'  => $transactionDate,
                'resultCode' => config('paymentgateway.momoResultCode.INVALID_REFERENCE1'),
                'status' => Response::HTTP_OK,
                'message' => __('PaymentGateway::messages.date_format_is_not_correct'),
            ];
            Log::channel('momo')->info('momo notify payment -> response: ' . print_r($response, true));
            if (config('paymentgateway.momoCrypto')) {
                return $this->encryptDataMoMo($response);
            } else {
                return response()->json($response);
            }
        }
        $attributes['date'] = $date->format('Y-m-d H:i:s');
        $attributes['transaction_fee'] = $this->transactionFee($reqData['amount']);
        // update transaction
        $update = $this->momoAppRepository->update($attributes, $transactionId);

        Log::channel('momo')->info('momo notify payment -> update: ' . print_r($update, true));
        if ($update) {

            if ($update["payment_option"] == config('paymentgateway.PAYMENT_TERM')) {
                $resultCallPaymentApi = $this->callApiPaymentContract($update);
            } else {
                $resultCallPaymentApi = $this->callApiPaymentFinalSettlement($update);
            }
            $this->callApiRefreshContractInfo($update["contract_id"]);
            Log::channel('momo')->info('api.tienngay create transaction_id: ' . print_r($resultCallPaymentApi->json(), true));
            if(!empty($resultCallPaymentApi) && $resultCallPaymentApi['status'] == Response::HTTP_OK) {

                $resultApi['contract_transaction_id'] = $resultCallPaymentApi['transaction_id']['$oid'];
                $resultApi['contract_status'] = config('paymentgateway.CONTRACT_STATUS_SUCCESS');
                // update contract_transaction_id;
                $update = $this->momoAppRepository->updateContractTransactionId($resultApi, $transactionId);
            } else {

                // gạch nợ thất bại
                $resultApi['contract_transaction_id'] = !empty($resultCallPaymentApi['transaction_id']) ? $resultCallPaymentApi['transaction_id']['$oid'] : "";
                if (empty($resultCallPaymentApi['transaction_id'])) {
                    $resultApi['contract_status'] = config('paymentgateway.CONTRACT_STATUS_FAILED');
                } else {
                    // Trạng thái chờ duyệt
                    $resultApi['contract_status'] = config('paymentgateway.CONTRACT_STATUS_PENDING');
                }
                
                $update = $this->momoAppRepository->updateContractTransactionId($resultApi, $transactionId);
            }

            if ($update["payment_option"] == config('paymentgateway.PAYMENT_TERM')) {
                $message = __('PaymentGateway::messages.payment_term_success');
            } else {
                $message = __('PaymentGateway::messages.payment_final_settlement_success');
            }

            $response = [
                'requestId' => $requestId,
                'transactionId' => $momoTransactionId,
                'reference1' => $transactionId,
                'resultCode' => config('paymentgateway.momoResultCode.SUCCESS'),
                'status' => Response::HTTP_OK,
                'message' => $message,
            ];
            Log::channel('momo')->info('momo notify payment -> response: ' . print_r($response, true));
            if (config('paymentgateway.momoCrypto')) {
                return $this->encryptDataMoMo($response);
            } else {
                return response()->json($response);
            }
        } else {
            $response = [
                'requestId' => $requestId,
                'transactionId' => $momoTransactionId,
                'reference1' => $transactionId,
                'resultCode' => config('paymentgateway.momoResultCode.DATA_NOT_FOUND'),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => "Error",
            ];
            Log::channel('momo')->info('momo notify payment -> response: ' . print_r($response, true));
            if (config('paymentgateway.momoCrypto')) {
                return $this->encryptDataMoMo($response);
            } else {
                return response()->json($response);
            }
        }
    }

    /**
     * @OA\Post(
     *     path="/paymentgateway/momo/listTransactionByMonth",
     *     tags={"paymentgateway"},
     *     operationId="listTransactionByMonth",
     *     summary="get list data",
     *     description="get transaction list from epayment_transaction table by range time",
     *     @OA\RequestBody(
     *         description="",
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="time",type="string"),
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="get data successfully",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="get data failed",
     *     ),
     *     security={
     *         {"api_key": {}}
     *     },
     * )
     */
    public function listTransactionByMonth(Request $request) {
        $time = $request->input('time'); // Tien ngay transaction id
        $data =  $this->momoAppRepository->getListByMonth($time);
        Log::channel('momo')->info('search transaction by month: ' . $time);
        return response()->json([
            'data' => $data,
            'status' => Response::HTTP_OK,
            'message' => __('PaymentGateway::messages.get_data_success')
        ]);
        return response()->json($response);
    }

    /**
     * @OA\Post(
     *     path="/paymentgateway/momo/searchTransactions",
     *     tags={"paymentgateway"},
     *     operationId="search",
     *     summary="search transaction",
     *     description="get transaction list from epayment_transaction table by special condition",
     *     @OA\RequestBody(
     *         description="",
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                   @OA\Property(property="confirmed",type="number"),
     *                   @OA\Property(property="contract_code_disbursement",type="string"),
     *                   @OA\Property(property="contract_transaction_id",type="string"),
     *                   @OA\Property(property="transactionId",type="string"),
     *                   @OA\Property(property="start_date",type="string"),
     *                   @OA\Property(property="end_date",type="string"),
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="get data successfully",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="get data failed",
     *     ),
     *     security={
     *         {"api_key": {}}
     *     },
     * )
     */
    public function searchTransactions(Request $request) {
        $conditions = $request->all();
        Log::channel('momo')->info('search transaction by special conditions: ' . print_r($conditions, true));
        $data =  $this->momoAppRepository->searchByConditions($conditions);
        return response()->json([
            'data' => $data,
            'status' => Response::HTTP_OK,
            'message' => __('PaymentGateway::messages.get_data_success')
        ]);
        return response()->json($response);
    }

    /**
     * @OA\Post(
     *     path="/paymentgateway/momo/getContractList",
     *     tags={"paymentgateway"},
     *     operationId="search",
     *     summary="search contract list by client info",
     *     description="get contract list from contract table by special condition",
     *     @OA\RequestBody(
     *         description="",
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                   @OA\Property(property="requestId",type="number"),
     *                   @OA\Property(property="reference1",type="string"),
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="get data successfully",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="get data failed",
     *     ),
     *     security={
     *         {"api_key": {}}
     *     },
     * )
     */
    public function getContractList(Request $request) {
        if (config('paymentgateway.momoCrypto')) {
            $requestData = json_decode($this->decryptDataMomo($request->getContent())["data"], true);
        } else {
            $requestData = $request->all();
        }
        Log::channel('momo')->info('momo getContractList requested: ' . print_r($requestData, true));
        $requestId = !empty($requestData["requestId"]) ? $requestData["requestId"] : "";
        $customerInfo = !empty($requestData["reference1"]) ? $requestData["reference1"] : "";
        $validator = Validator::make($requestData, [
            'requestId' => 'required|string|max:50',
            'reference1' => 'required|string|max:50',
        ]);
        if ($validator->fails()) {
            Log::channel('momo')->info('validate error: ' . print_r($validator->errors(), true));
            $response = [
                'requestId' => $requestId,
                'reference1' => $customerInfo,
                'resultCode' => config('paymentgateway.momoResultCode.INVALID_REFERENCE1'),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $validator->errors()->first()
            ];
            Log::channel('momo')->info('momo getContractList response: ' . print_r($response, true));
            if (config('paymentgateway.momoCrypto')) {
                return $this->encryptDataMoMo($response);
            } else {
                return response()->json($response);
            }
        }
        //call api
        $contractList = $this->callApiFindContractByCustomerInfo($customerInfo);
        
        // call api failed or result not found
        if ($contractList["status"] != Response::HTTP_OK || empty($contractList["data"])) {
            $response = [
                'requestId' => $requestId,
                'reference1' => $customerInfo,
                'resultCode' => config('paymentgateway.momoResultCode.DATA_NOT_FOUND'),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => __('PaymentGateway::messages.get_data_failed')
            ];
            Log::channel('momo')->info('momo getContractList response: ' . print_r($response, true));
            if (config('paymentgateway.momoCrypto')) {
                return $this->encryptDataMoMo($response);
            } else {
                return response()->json($response);
            }

        }

        $responseContractList = [];
        foreach ($contractList["data"] as $contract) {
            $hasTransactionInProcess = $this->momoAppRepository->checkTransactionInProcess($contract['_id']['$oid']);
            Log::channel('momo')->info('hasTransactionInProcess: ' . print_r($hasTransactionInProcess, true));
            if ($hasTransactionInProcess > 0) {
                continue;
            }
            $isComplatedContract = $this->momoAppRepository->isComplatedContract($contract['_id']['$oid']);
            if ($isComplatedContract) {
                Log::channel('momo')->info('isComplatedContract: ' . print_r($contract['_id']['$oid'], true));
                continue;
            }
            $arr = [];
            $arr['contractId'] = $contract['_id']['$oid'];
            $arr['contractCode'] = $contract['code_contract_disbursement'];
            $arr['name'] = $contract["customer_infor"]["customer_name"];
            $arr['email'] = $contract["customer_infor"]["customer_email"];
            $arr['mobile'] = $this->hideNumberOfPhone($contract["customer_infor"]["customer_phone_number"]);
            $arr['timeLeft'] = $this->countdownToLastTerm($contract);

            $detainPaymentData = $this->callApiGetPaymentInfo($contract['_id']['$oid']);
            // call api failed
            if ($detainPaymentData["status"] != Response::HTTP_OK) {
                Log::channel('momo')->info('getPaymentInfo failed: ' . print_r($contract['_id']['$oid'], true));
                continue;
            } else {
                //create response
                $result = $this->createBill($detainPaymentData);
                $arr['totalAmount'] = $result["total"]["value"];
                $time = str_replace("/","-",$result['dueDate']);
                $endDate = new DateTime($time);
                $arr['endDate'] = $endDate->format('d/m/Y');
            }
            if ($arr['totalAmount'] <= 0) {
                Log::channel('momo')->info('totalAmount is 0 failed: ' . print_r($contract['_id']['$oid'], true));
                continue;
            }
            $responseContractList[] = $arr;

        }
        if (empty($responseContractList)) {
            $response = [
                'requestId' => $requestId,
                'reference1' => $customerInfo,
                'resultCode' => config('paymentgateway.momoResultCode.DATA_NOT_FOUND'),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => __('PaymentGateway::messages.get_data_failed')
            ];

            Log::channel('momo')->info('momo getContractList response: ' . print_r($response, true));
            if (config('paymentgateway.momoCrypto')) {
                return $this->encryptDataMoMo($response);
            } else {
                return response()->json($response);
            }
        }
        //create response
        $response = [
            'requestId' => $requestId,
            'reference1' => $customerInfo,
            'resultCode' => config('paymentgateway.momoResultCode.SUCCESS'),
            'status' => Response::HTTP_OK,
            'message' => __('PaymentGateway::messages.get_data_success'),
            'contractList' => $responseContractList,
        ];

        Log::channel('momo')->info('momo getContractList response: ' . print_r($response, true));
        if (config('paymentgateway.momoCrypto')) {
            return $this->encryptDataMoMo($response);
        } else {
            return response()->json($response);
        }
    }

    /**
     * Get contract list from Api server.
     *
     * @param  string  $customerInfo
     * @return Colection
     */
    protected function callApiFindContractByCustomerInfo($customerInfo) {
        $url = $this->getApiUrl('contract/find_contract_by_customer_info');

        $dataPost = array(
            'customer_info' => $customerInfo,
        );
        //call api
        Log::channel('momo')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));

        $response = Http::asForm()->post($url, $dataPost);

        Log::channel('momo')->info('Result Api: ' . $url . ' ' . print_r($response->json(), true));
        return $response;
    }

    /**
     * Check Transaction status
     * Momo will use this API to get final status of payment
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Post(
     *     path="/paymentgateway/momo/checkTransactionStatus",
     *     tags={"paymentgateway"},
     *     operationId="search",
     *     summary="Check Transaction status",
     *     description="Momo will use this API to get final status of payment",
     *     @OA\RequestBody(
     *         description="",
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="application/xml",
     *              @OA\Schema(
     *                  @OA\Property(
     *                       'requestId' => (string)
     *                       'transactionId' => (string) Momo's transaction Id
     *                   )
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="get data successfully",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="get data failed",
     *     ),
     *     security={
     *         {"api_key": {}}
     *     },
     * )
     */
    public function checkTransactionStatus(Request $request) {
        if (config('paymentgateway.momoCrypto')) {
            $requestData = json_decode($this->decryptDataMomo($request->getContent())["data"], true);
        } else {
            $requestData = $request->all();
        }
        Log::channel('momo')->info('momo checkTransactionStatus requested: ' . print_r($requestData, true));
        $requestId = !empty($requestData["requestId"]) ? $requestData["requestId"] : "";
        $transactionId = !empty($requestData["transactionId"]) ? $requestData["transactionId"] : "";
        $validator = Validator::make($requestData, [
            'requestId' => 'required|string|max:50',
            'transactionId' => 'required|string|max:50',
        ]);
        if ($validator->fails()) {
            Log::channel('momo')->info('validate error: ' . print_r($validator->errors(), true));
            $response = [
                'requestId' => $requestId,
                'referenceId' => $transactionId,
                'resultCode' => config('paymentgateway.momoResultCode.INVALID_REFERENCE1'),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $validator->errors()->first()
            ];
            Log::channel('momo')->info('momo checkTransactionStatus response: ' . print_r($response, true));
            if (config('paymentgateway.momoCrypto')) {
                return $this->encryptDataMoMo($response);
            } else {
                return response()->json($response);
            }
        }
        //call api
        $result = $this->momoAppRepository->isStatusSuccess($transactionId);

        if (!$result) {
            Log::channel('momo')->info('TransactionId does not in-process: ' . $transactionId);
            $response = [
                'requestId' => $requestId,
                'referenceId' => $transactionId,
                'resultCode' => config('paymentgateway.momoResultCode.DATA_NOT_FOUND'),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => __('PaymentGateway::messages.transaction_not_found')
            ];
            Log::channel('momo')->info('momo checkTransactionStatus response: ' . print_r($response, true));
            if (config('paymentgateway.momoCrypto')) {
                return $this->encryptDataMoMo($response);
            } else {
                return response()->json($response);
            }
        }
        //create response
        $response = [
            'requestId' => $requestId,
            'referenceId' => $transactionId,
            'resultCode' => config('paymentgateway.momoResultCode.SUCCESS'),
            'status' => Response::HTTP_OK,
            'message' => __('PaymentGateway::messages.transaction_has_been_processed'),
        ];

        Log::channel('momo')->info('momo checkTransactionStatus response: ' . print_r($response, true));
        if (config('paymentgateway.momoCrypto')) {
            return $this->encryptDataMoMo($response);
        } else {
            return response()->json($response);
        }
    }

    /**
     * confirm transactions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *     path="/paymentgateway/momo/autoConfirm",
     *     tags={"paymentgateway"},
     *     operationId="autoConfirm",
     *     summary="confrim transactions",
     *     description="confrim transactions from epayment_transactions table",
     *     @OA\RequestBody(
     *         description="",
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="application/xml",
     *              @OA\Schema(
     *                  @OA\Property(
     *                       'ids' => (array)
     *                   )
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="get data successfully",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="get data failed",
     *     ),
     *     security={
     *         {"api_key": {}}
     *     },
     * )
     */
    public function autoConfirm (Request $request) {
        $requestData = $request->all();
        Log::channel('momo')->info('momo checkTransactionStatus requested: ' . print_r($requestData, true));
        $validator = Validator::make($requestData, [
            'ids' => 'required|array|min:1',
        ]);
        if ($validator->fails()) {
            Log::channel('momo')->info('autoConfirm validate error: ' . print_r($validator->errors(), true));
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $validator->errors()->first()
            ]);
            return response()->json($response);
        }
        if (empty($requestData["ids"])) {
            Log::channel('momo')->info('autoConfirm ids is empty');
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => __('PaymentGateway::messages.transaction_not_found')
            ]);
            return response()->json($response);
        }

        $result = $this->momoAppRepository->autoConfirm($requestData["ids"]);

        if (!$result) {
            Log::channel('momo')->info('autoConfirm update failed');
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => __('PaymentGateway::messages.update_data_failed')
            ]);
            return response()->json($response);
        }
        return response()->json([
            'data' => $result,
            'status' => Response::HTTP_OK,
            'message' => __('PaymentGateway::messages.update_data_success')
        ]);
        return response()->json($response);
    }

    /**
    * Hide numbers of a phone number
    */
    protected function hideNumberOfPhone($phone) {
        $phoneNumber = str_replace(substr($phone, 4,5), '*****', $phone);
        return $phoneNumber;
    }
}
