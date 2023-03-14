<?php

namespace Modules\MongodbCore\Repositories\Interfaces;

interface KsnbRepositoryInterface
{

    public function createReport($data = []);

    public function updateReport($data =[], $id);

    public function getAllReport();

    public function find($id);


    //update tiến trình khi sau duyệt
    public function update_confrim($data=[], $id);

    //update tiến trình khi ko duyệt
    public function updateNotConfrim($data=[], $id);

    //update lại tiến trình sau khi gửi duyệt lại lân nữa
    public function updateReConfrim($data = [], $id);

    public function updateFeedBack($data=[], $id);

    public function updateInfer($data=[], $id);

    public function get_email_ksnb($user);

    public function updateWaitConfrim($data=[], $id);

    public function updateKsnbFeedback($data=[], $id);

    public function updateWaitInfer($data=[], $id);

    public function createNote($data = []);

    public function updateNote($data = [], $id);

    public function getAllNote();

    public function findNote($id);

    public function waitConfirmNote($id);

    public function notConfirmNote($data, $id);

    public function confirmNote($id);

    public function userFeedBack($data, $id);

    public function ksnbFeedback($data, $id);

    public function waitInferNote($id);

    public function inferNote($data, $id);

    public function waitReConfirmNote($id);

    public function sendCeo($data, $id);

    public function ceoNotConfirm($data, $id);

    public function ceoConfirm($data, $id);

}
