<?php

namespace App\Service\Investor;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Repository\InvestorRepositoryInterface;
use App\Models\Investor;

class NewInvestor
{

	public function __construct(
		InvestorRepositoryInterface $investor
	) {
		$this->investor_model = $investor;
	}

	public function confirm($data)
	{
		DB::beginTransaction();
		try {
			foreach ($data as $item) {
				$investor = $this->investor_model->findConfirmNew($item);
				if ($investor) {
					$this->investor_model->update($item, [
						Investor::COLUMN_STATUS => Investor::STATUS_ACTIVE,
                        Investor::COLUMN_ACTIVE_AT => Carbon::now(),
					]);

				}
			}
			DB::commit();
			return true;
		} catch (\Exception $e) {
			DB::rollback();
			return false;
		}
	}

	public function block($data)
	{
		DB::beginTransaction();
		try {
			foreach ($data as $item) {
				$investor = $this->investor_model->findConfirmNew($item);
				if ($investor) {
					$this->investor_model->update($item, [
						Investor::COLUMN_STATUS => Investor::STATUS_BLOCK,
                        Investor::COLUMN_ACTIVE_AT => Carbon::now(),
					]);
				}
			}
			DB::commit();
			return true;
		} catch (\Exception $e) {
			DB::rollback();
			return false;
		}
	}

}
