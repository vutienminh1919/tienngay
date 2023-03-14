<?php


namespace App\Service;


use App\Models\Event;
use App\Repository\EventRepository;
use Illuminate\Support\Facades\Validator;

class EventService extends BaseService
{
    protected $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function create($request)
    {
        $data = [
            Event::EVENT => $request->event,
            Event::SLUG => slugify($request->event),
            Event::TITLE => $request->title,
            Event::STATUS => 'active',
            Event::SHORT_DESCRIPTION => $request->short_description,
            Event::LONG_DESCRIPTION => $request->long_description,
            Event::DAY => $request->day,
            Event::HOUR => $request->hour,
            Event::MONTH => $request->month,
            Event::OBJECT => $request->object,
            Event::REPEAT => $request->repeat,
            Event::COLUMN_CREATED_BY => current_user()->email,
            Event::EVENT_DAY => $request->date,
            Event::IMAGE => $request->image,
        ];
        $this->eventRepository->create($data);
    }

    public function list($request)
    {
        return $this->eventRepository->list($request);
    }

    public function validate_create($request)
    {
        $validate = Validator::make($request->all(), [
            'event' => 'required',
            'title' => 'required',
            'short_description' => 'required',
            'long_description' => 'required',
            'object' => 'required',
            'repeat' => 'required',
            'image' => 'required'
        ], [
            'event.required' => 'Sự kiện không được để trống',
            'title.required' => 'Tiêu đề không được để trống',
            'short_description.required' => 'Mô tả ngắn không được để trống',
            'long_description.required' => 'Mô tả đầy đủ không được để trống',
            'object.required' => 'Đối tượng không được để trống',
            'repeat.required' => 'Lặp lại không được để trống',
            'image.required' => 'Hình ảnh không để trống'
        ]);
        return $validate;
    }

    public function check_create($request)
    {
        $message = [];
        if (!empty($request->repeat)) {
            if (empty($request->hour)) {
                $message[] = "Khung giờ không để trống";
            }
        }
        if ($request->repeat == 2) {
            if (empty($request->day)) {
                $message[] = "Ngày trong tuần không để trống";
            }

        } elseif ($request->repeat == 3) {
            if (empty($request->month)) {
                $message[] = "Số lần chạy trong tháng không để trống";
            }
        } elseif ($request->repeat == 4) {
            if (empty($request->date)) {
                $message[] = "Ngày thông báo không để trống";
            }
        }
        return $message;
    }

    public function update_status($request)
    {
        $event = $this->eventRepository->find($request->id);
        if ($event['status'] == 'active') {
            $this->eventRepository->update($request->id, ['status' => 'block']);
        } else {
            $this->eventRepository->update($request->id, ['status' => 'active']);
        }
        return $event;
    }

    public function show($id)
    {
        return $this->eventRepository->find($id);
    }

    public function update($request)
    {
        $data = [
            Event::EVENT => $request->event,
            Event::SLUG => slugify($request->event),
            Event::TITLE => $request->title,
            Event::SHORT_DESCRIPTION => $request->short_description,
            Event::LONG_DESCRIPTION => $request->long_description,
            Event::DAY => $request->day,
            Event::HOUR => $request->hour,
            Event::MONTH => $request->month,
            Event::OBJECT => $request->object,
            Event::REPEAT => $request->repeat,
            Event::EVENT_DAY => $request->date,
            Event::COLUMN_UPDATED_BY => current_user()->email,
            Event::IMAGE => $request->image,
        ];
        $this->eventRepository->update($request->id, $data);
    }
}
