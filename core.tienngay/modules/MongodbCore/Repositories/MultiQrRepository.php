<?php

namespace Modules\MongodbCore\Repositories;


use Illuminate\Database\Eloquent\Model;
use Modules\MongodbCore\Entities\MultiQr;
use Modules\MongodbCore\Repositories\Interfaces\MultiQrRepositoryInterface;
use Illuminate\Support\Collection;

class MultiQrRepository implements MultiQrRepositoryInterface
{

    /**      
     * @var Model      
     */     
     protected $model;

    /**
     * MultiQrRepository constructor.
     *
     * @param MultiQr $model
     */
    public function __construct(MultiQr $model) {
        $this->model = $model;
    }

    /**
     * create the specified resource in storage.
     *
     * @param  array  $data
     * @return Collection
     */
    public function create($data) {
        $insert = [];

        if (isset($data[$this->model::REQUEST_ID])) {
            $insert[$this->model::REQUEST_ID] = $data[$this->model::REQUEST_ID];
        }
        if (isset($data[$this->model::IOS])) {
            $insert[$this->model::IOS] = $data[$this->model::IOS];
        }
        if (isset($data[$this->model::ANDROID])) {
            $insert[$this->model::ANDROID] = $data[$this->model::ANDROID];
        }
        if (isset($data[$this->model::OTHER])) {
            $insert[$this->model::OTHER] = $data[$this->model::OTHER];
        }
        if (!empty($insert)) {
            $insert[$this->model::CREATED_AT] = time();
            $insert[$this->model::DELETED_AT] = NULL;
            $result = $this->model->create($insert);
            return $result["_id"];
        }
        return false;
    }

    /**
     * Find the specified resource in storage.
     *
     * @param  array  $data
     * @return Collection
     */
    public function find($id) {
        $result = $this->model::where($this->model::ID, $id)->where($this->model::DELETED_AT, null)->first();
        return $result;

    }
}
