<?php


namespace Modules\AssetLocation\Http\Service;


use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Modules\AssetLocation\Http\Repository\AccountVsetRepository;
use Modules\AssetLocation\Http\Repository\BaseRepository;
use Modules\AssetLocation\Model\Account_vset;

class AccountVsetService extends BaseService
{
    protected $accountVsetRepository;
    protected $vset;

    public function __construct(AccountVsetRepository $accountVsetRepository,
                                Vsetcomgps $vsetcomgps)
    {
        $this->accountVsetRepository = $accountVsetRepository;
        $this->vset = $vsetcomgps;
    }

    public function auth()
    {
        $data = $this->vset->auth();
        if ($data) {
            $vset = $this->accountVsetRepository->findOne([Account_vset::APP_ID => env('VSET_APPID')]);
            if ($vset) {
                $this->accountVsetRepository->update($vset['_id'], [Account_vset::ACCESS_TOKEN => $data->accessToken, Account_vset::UPDATED_AT => Carbon::now()->unix()]);
            } else {
                $this->accountVsetRepository->create([
                    Account_vset::APP_ID => env('VSET_APPID'),
                    Account_vset::ACCESS_TOKEN => $data->accessToken,
                    Account_vset::KEY => env('VSET_KEY'),
                    Account_vset::CREATED_AT => Carbon::now()->unix()
                ]);
            }
        } else {
            $message_new = 'Thời gian: ' . Carbon::now() . "\n" .
                'Client: ' . env('APP_ENV') . "\n" .
                'Nội dung: ' . '"<b>' . 'Không kết nối được với VSET' . '</b>"';
            Telegram::send($message_new);
        }
        return $data;
    }
}
