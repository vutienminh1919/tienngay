<?php

namespace Modules\MongodbCore\Repositories;

interface KsnbCodeErrorsRepositoryInterface
{
    public function createKsnbErrors($data = []);

    public function updateKsnbErrors($data = [] , $id);

    public function find($id);

    public function getAllKsnbErrors();

    //lấy hết mã lỗi theo nhóm vi phạm;
    public function getCodeByType($type);

    public function getPunishmentByCode($code);

    public function getDisciplineByCode($code);
    public function getDescription($code); 
}
