<?php

namespace Modules\MongodbCore\Repositories;


use Illuminate\Database\Eloquent\Model;
use Modules\MongodbCore\Entities\TradeHistory;
use Modules\MongodbCore\Entities\TradeTransfer;
use Modules\MongodbCore\Repositories\Interfaces\TransferRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use MongoDB\BSON\Regex;

class TransferRepository implements TransferRepositoryInterface
{
        /**
     * @var Model
     */
    protected $transferModel;


    public function __construct(TradeTransfer $transferModel) {
       $this->transferModel = $transferModel;
    }

    /**
    * Tạo phiếu điều chuyển
    * @param array $data
    * @return Collection
    */
    public function create($data=[]) {
        if (empty($data)) {
            return false;
        }
        $input = [
            TradeTransfer::REQUESTED_AT          => $data['requested_at'] ?? time(),
            TradeTransfer::CREATED_AT            => time(),
            TradeTransfer::CREATED_BY            => $data['created_by'] ?? "",
            TradeTransfer::TOTAL_ITEMS           => $data['total_items'] ?? "",
            TradeTransfer::TOTAL_AMOUNT          => $data['total_amount'] ?? "",
            TradeTransfer::LIST                  => $data['list'] ?? "",
            TradeTransfer::STORES_EXPORT         => $data['stores_export'] ?? "",
            TradeTransfer::STORES_IMPORT         => $data['stores_import'] ?? "",
            TradeTransfer::LICENSE_EXPORT        => [],
            TradeTransfer::LICENSE_IMPORT        => [],
            TradeTransfer::STATUS                => $data['status'] ?? "",
            TradeTransfer::LOGS                  => [],
        ];
        $create = $this->transferModel->create($input);
        if ($create) {
            return $create;
        }
        return false;
    }

    /**
    * lấy hết phiếu điều chuyển
    * @param array $data
    * @return Collection
    */
    public function getAllTransfer($data=[]) {
        $transfer = $this->transferModel;
        if (!empty($data['start_date'])) {
            $start_date = strtotime($data['start_date'].'00:00:00');
            $transfer = $transfer->where(TradeTransfer::CREATED_AT, '>=', $start_date);
        }
        if (!empty($data['end_date'])) {
            $end_date = strtotime($data['end_date']."23:59:59");
            $transfer = $transfer->where(TradeTransfer::CREATED_AT, '<=', $end_date);
        }
        if (!empty($data['start_request_date'])) {
            $start_request_date = strtotime($data['start_request_date'].'00:00:00');
            $transfer = $transfer->where(TradeTransfer::REQUESTED_AT, '>=', $start_request_date);
        }
        if (!empty($data['end_request_date'])) {
            $end_request_date = strtotime($data['end_request_date']."23:59:59");
            $transfer = $transfer->where(TradeTransfer::REQUESTED_AT, '<=', $end_request_date);
        }
        if (!empty($data['start_date_export'])) {
            $start_date_export = strtotime($data['start_date_export'].'00:00:00');
            $transfer = $transfer->where(TradeTransfer::DATE_EXPORT, '>=', $start_date_export);
        }
        if (!empty($data['end_date_export'])) {
            $end_date_export = strtotime($data['end_date_export']."23:59:59");
            $transfer = $transfer->where(TradeTransfer::DATE_EXPORT, '<=', $end_date_export);
        }
        if (!empty($data['start_date_import'])) {
            $start_date_import = strtotime($data['start_date_import'].'00:00:00');
            $transfer = $transfer->where(TradeTransfer::DATE_IMPORT, '>=', $start_date_import);
        }
        if (!empty($data['end_date_import'])) {
            $end_date_import = strtotime($data['end_date_import']."23:59:59");
            $transfer = $transfer->where(TradeTransfer::DATE_IMPORT, '<=', $end_date_import);
        }
        if (!empty($data['stores_export'])) {
            $transfer = $transfer->where(TradeTransfer::STORES_EXPORT. '.' .'id', $data['stores_export']);
        }
        if (!empty($data['stores_import'])) {
            $transfer = $transfer->where(TradeTransfer::STORES_IMPORT. '.' .'id', $data['stores_import']);
        }
        if (!empty($data['status'])) {
            $transfer = $transfer->where(TradeTransfer::STATUS,  (int)$data['status']);
        }
        return $transfer
        ->where(TradeTransfer::DELETE, '$exists', false)
        ->orderBy(TradeTransfer::CREATED_AT, 'DESC')
        ->paginate(10);
    }

    /**
    * Tìm ra phiếu điều chuyển
    * @param string $id
    * @return Collection
    */
    public function find($id) {
        $result = $this->transferModel->where(TradeTransfer::ID, $id)->find($id);
        if ($result) {
            return $result->toArray();
        }
        return false;
    }

    /**
    * Cập nhật phiếu điều chuyển
    * @param string $id
    * @param array $data
    * @return Collection
    */
    public function update($data=[], $id) {
        if (empty($data)) {
            return false;
        }
        $input = [
            TradeTransfer::REQUESTED_AT          => $data['requested_at'] ?? time(),
            TradeTransfer::UPDATED_BY            => $data['updated_by'] ?? "",
            TradeTransfer::TOTAL_ITEMS           => $data['total_items'] ?? "",
            TradeTransfer::TOTAL_AMOUNT          => $data['total_amount'] ?? "",
            TradeTransfer::LIST                  => $data['list'] ?? "",
            TradeTransfer::STORES_IMPORT         => $data['stores_import'] ?? "",
            TradeTransfer::LICENSE_EXPORT        => [],
            TradeTransfer::LICENSE_IMPORT        => [],
        ];
        $update = $this->transferModel->where(TradeTransfer::ID, $id)->update($input);
        if ($update) {
            return $update;
        }
        return false;
    }

    /**
    * Cập nhật lý do hủy
    * @param string $id
    * @param string $code
    * @return Collection
    */
    public function updateReasonCancel($code, $id) {
        $result = [];
        $result[TradeTransfer::REASON_CANCEL] = $code;
        $result[TradeTransfer::STATUS] = TradeTransfer::STATUS_CANCEL;
        $update = $this->transferModel->where(TradeTransfer::ID, $id)->update($result);
        if ($update) {
            return $update;
        }
        return false;
    }

    /**
    * Xóa mềm phiếu điều chuyển bằng việc update trường delete
    * @param string $id
    * @return Collection
    */
    public function deleteItem($id) {
        $result = [];
        $result[TradeTransfer::DELETE] = TradeTransfer::DELETED;
        $update = $this->transferModel->where(TradeTransfer::ID, $id)->update($result);
        if ($update) {
            return $update;
        }
        return false;
    }

    public function confirmExport($data = []) {
        $result = [
            TradeTransfer::STATUS => TradeTransfer::STATUS_WAIT_IMPORT,
            TradeTransfer::LICENSE_EXPORT => $data['url'] ?? [],
            TradeTransfer::EXPORT_BY    => $data['export_by'] ?? "",
            TradeTransfer::DATE_EXPORT => time(),
        ];
        $update = $this->transferModel->where(TradeTransfer::ID, $data['id'])->update($result);
        if ($update) {
            return $update;
        }
        return false;
    }

    public function confirmImport($data = []) {
        $result = [
            TradeTransfer::STATUS => TradeTransfer::STATUS_COMPLETE,
            TradeTransfer::LICENSE_IMPORT => $data['url'] ?? [],
            TradeTransfer::IMPORT_BY    => $data['import_by'] ?? "",
            TradeTransfer::DATE_IMPORT => time(),
        ];
        $update = $this->transferModel->where(TradeTransfer::ID, $data['id'])->update($result);
        if ($update) {
            return $update;
        }
        return false;
    }

    public function wlog($id, $action, $email) {
        $log = [
            'action'        => $action ?? "",
            'created_by'    => $email ?? "",
            'created_at'    => time(),
        ];
        $push = $this->transferModel->where(TradeTransfer::ID, $id)
        ->push(TradeTransfer::LOGS, $log);
        if ($push) {
            return $push;
        }
        return false;
    }

    public function confirmCreate($data = []) {
        $result = [];
        $result[TradeTransfer::STATUS] = TradeTransfer::STATUS_WAIT_EXPORT;
        $update = $this->transferModel->where(TradeTransfer::ID, $data['id'])->update($result);
        if ($update) {
            return $update;
        }
        return false;

    }


    public function getItemExportByStoreId($store_id)
    {
        $result = $this->transferModel::where(TradeTransfer::STORES_EXPORT . '.' . TradeTransfer::STORES_ID, $store_id)
            ->where(TradeTransfer::STATUS, TradeTransfer::STATUS_COMPLETE)
            ->get();
        return $result->toArray();

    }
    public function getItemImportByStoreId($store_id)
    {
        $result = $this->transferModel::where(TradeTransfer::STORES_IMPORT . '.' . TradeTransfer::STORES_ID, $store_id)
            ->where(TradeTransfer::STATUS, TradeTransfer::STATUS_COMPLETE)
            ->get();
        return $result->toArray();

    }

    public function getallItemExportCompleted()
    {
        $condition = [];
        $condition ['status'] = TradeTransfer::STATUS_COMPLETE;
        $group = $this->transferModel::raw(function ($collection) use ($condition) {
            return $collection->aggregate([
                ['$unwind' => '$list'],
                ['$match' => (object)$condition
                ],
                ['$group' =>
                    [
                        "_id" => '$list.code_item',
                        "quantity_export_transfer" => ['$sum' => '$list.amount'],
                    ]
                ],
                ['$project' =>
                    [
                        'quantity_export_transfer' => '$quantity_export_transfer',
                    ]
                ],

            ]);
        });
        return $group;
    }

    public function getExportAllItembyStoreIdCompleted()
    {
        $condition = [];
        $condition ['status'] =  TradeTransfer::STATUS_COMPLETE;
        $group = $this->transferModel::raw(function ($collection) use($condition) {
            return $collection->aggregate([
                ['$unwind' => '$list'],
                    ['$match' => (object)$condition
                    ],
                ['$group' =>
                    [
                        "_id" => '$stores_export.id',
                        "quantity_export_transfer" => ['$sum' => '$list.amount'],
                    ]
                ],
                ['$project' =>
                    [
                        'quantity_export_transfer' => 1,
                    ]
                ],

            ]);
        });
        return $group;

    }

    public function getImportAllItembyStoreIdCompleted()
    {
        $condition = [];
        $condition ['status'] =  TradeTransfer::STATUS_COMPLETE;
        $group = $this->transferModel::raw(function ($collection) use($condition) {
            return $collection->aggregate([
                ['$unwind' => '$list'],
                    ['$match' => (object)$condition
                    ],
                ['$group' =>
                    [
                        "_id" => '$stores_import.id',
                        "quantity_import_transfer" => ['$sum' => '$list.amount'],
                    ]
                ],
                ['$project' =>
                    [
                        'quantity_import_transfer' => 1,
                    ]
                ],

            ]);
        });
        return $group;

    }

}
