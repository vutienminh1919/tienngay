<?php


namespace App\Repository;


interface NotificationRepositoryInterface extends BaseRepositoryInterface
{
    public function get_notification_user_app($id, $limit, $offset);

    public function count_unread($id);

    public function get_paginate_notification_user($id);

    public function get_notification_user($request, $user);

    public function get_notification_promotion($request, $user);
}
