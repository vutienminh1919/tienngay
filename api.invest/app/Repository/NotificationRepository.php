<?php


namespace App\Repository;


use App\Models\Notification;
use Carbon\Carbon;

class NotificationRepository extends BaseRepository implements NotificationRepositoryInterface
{
    const UNREAD = 1;
    const READ = 2;

    public function getModel()
    {
        return Notification::class;
    }

    public function get_notification_user_app($id, $limit, $offset)
    {
        return $this->model
            ->where(function ($query) use ($id) {
                return $query->where(Notification::COLUMN_USER_ID, $id);
            })
            ->orderBy(Notification::COLUMN_CREATED_AT, self::DESC)
            ->limit($limit)
            ->offset($offset)
            ->get();
    }

    public function count_unread($id)
    {
        return $this->model
            ->where(Notification::COLUMN_USER_ID, $id)
            ->whereIn(Notification::COLUMN_ACTION, Notification::GROUP_TRANSACTION)
            ->where(Notification::COLUMN_STATUS, self::UNREAD)
            ->count();
    }

    public function get_paginate_notification_user($id)
    {
        return $this->model
            ->where(function ($query) use ($id) {
                return $query->where(Notification::COLUMN_USER_ID, $id);
            })
            ->orderBy(Notification::COLUMN_CREATED_AT, self::DESC)
            ->paginate();
    }

    public function get_notification_user($request, $user)
    {
        $option = !empty($request->option) ? (int)$request->option : Notification::MAILBOX;
        $limit = !empty($request->limit) ? (int)$request->limit : 5;
        $offset = !empty($request->offset) ? (int)$request->offset : 0;
        $model = $this->model;
        $user_id = $request->id;
        $user_created = $user['created_at'];
        if ($option == Notification::TRANSACTION) {
            $model = $model->where(Notification::COLUMN_USER_ID, $user_id);
            $model = $model->whereIn(Notification::COLUMN_ACTION, Notification::GROUP_TRANSACTION);
        } elseif ($option == Notification::MAILBOX) {
            $model = $model->whereIn(Notification::COLUMN_ACTION, Notification::GROUP_MAILBOX)
                ->where(function ($query) use ($user_id, $user_created) {
                    return $query->where(function ($sub) use ($user_created) {
                        return $sub->whereNull(Notification::COLUMN_USER_ID)
                            ->where(Notification::CREATED_AT, '>=', $user_created);
                    })->orWhere(Notification::COLUMN_USER_ID, $user_id);
                });
        } elseif ($option == Notification::PROMOTION) {
            $model = $model->whereIn(Notification::COLUMN_ACTION, Notification::GROUP_PROMOTION)
                ->where(function ($query) use ($user_id, $user_created) {
                    return $query->where(function ($sub) use ($user_created) {
                        return $sub->whereNull(Notification::COLUMN_USER_ID)
                            ->where(Notification::CREATED_AT, '>=', $user_created);
                    })->orWhere(Notification::COLUMN_USER_ID, $user_id);
                });
        }
        return $model
            ->orderBy(Notification::COLUMN_CREATED_AT, self::DESC)
            ->limit($limit)
            ->offset($offset)
            ->get();
    }

    public function get_notification_promotion($request, $user)
    {
        $limit = !empty($request->limit) ? (int)$request->limit : 5;
        $offset = !empty($request->offset) ? (int)$request->offset : 0;
        $banner = !empty($request->banner) ? (int)$request->banner : "";
        $model = $this->model;
        $model = $model->whereIn(Notification::COLUMN_ACTION, Notification::GROUP_PROMOTION);
        if ($banner && $banner == true) {
            $model = $model->where(Notification::COLUMN_BANNER, 1);
        }
        return $model->orderBy(Notification::COLUMN_CREATED_AT, self::DESC)
            ->limit($limit)
            ->offset($offset)
            ->get();
    }

    public function popup()
    {
        $date = Carbon::now();
        $model = $this->model;
        return $model->where(Notification::COLUMN_ACTION, 'popup')
            ->where(Notification::COLUMN_START_DATE, '<=', $date)
            ->where(Notification::COLUMN_END_DATE, '>=', $date)
            ->orderBy(Notification::COLUMN_CREATED_AT, self::DESC)
            ->get();
    }

}
