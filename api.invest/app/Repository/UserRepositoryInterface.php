<?php

namespace App\Repository;

interface UserRepositoryInterface extends BaseRepositoryInterface
{

    public function findOneByEmailOrPhone($email);

    public function findOneByPhone($phone);

    public function checkLoginUser($email, $phone, $token_web);

    public function checkLoginUserApp($phone, $token_app);

    public function checkOtp($otp, $phone);

    public function getListTypeNhanVien($filter);

    public function getAllTypeNhanVien();

    public function signin_app($phone);

    public function checkOtpResetPassApp($otp, $phone);

    public function findPhoneUser($phone);

    public function findEmailUser($email);

    public function find_user_by_event($filter);

    public function find_select($id, $select);

    public function get_user_contract_expire();
}
