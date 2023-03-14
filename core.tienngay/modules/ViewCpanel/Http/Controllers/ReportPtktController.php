<?php

namespace Modules\ViewCpanel\Http\Controllers;


use Modules\MongodbCore\Repositories\TransactionRepository;

class ReportPtktController extends BaseController
{
    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;

    }


}
