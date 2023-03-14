<?php

namespace App\Console\Commands;

use App\Models\Device;
use App\Models\Event;
use App\Models\Notification;
use App\Models\User;
use App\Repository\NotificationRepository;
use App\Repository\UserRepository;
use App\Service\Firebase;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CronPushEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:push {--repeat= }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'push event ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Firebase $firebase,
                                UserRepository $userRepository,
                                NotificationRepository $notificationRepository)
    {
        parent::__construct();
        $this->firebase = $firebase;
        $this->userRepository = $userRepository;
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $repeat = $this->option('repeat');
        $event = Event::where(Event::STATUS, Event::ACTIVE);
        if ($repeat == Event::WEEKLY) {
            $event = $event
                ->where(Event::REPEAT, Event::WEEKLY)
                ->where(Event::DAY, Carbon::now()->dayOfWeekIso)
                ->where(Event::HOUR, Carbon::now()->hour)
                ->get();
        } elseif ($repeat == Event::DAILY) {
            $event = $event
                ->where(Event::REPEAT, Event::DAILY)
                ->where(Event::HOUR, Carbon::now()->hour)
                ->get();
        } elseif ($repeat == Event::ANNUAL) {
            $event = $event
                ->where(Event::REPEAT, Event::ANNUAL)
                ->where(Event::EVENT_DAY, Carbon::now()->format('Y-m-d'))
                ->where(Event::HOUR, Carbon::now()->hour)
                ->get();
        } elseif ($repeat == Event::MONTHLY) {
            if (Carbon::now()->day == Event::DAY_ONE_BY_MONTH) {
                $event = $event
                    ->where(Event::REPEAT, Event::MONTHLY)
                    ->where(Event::HOUR, Carbon::now()->hour)
                    ->get();
            } elseif (Carbon::now()->day == Event::SIXTEENTH_DAY_OF_THE_MONTH) {
                $event = $event
                    ->where(Event::REPEAT, Event::MONTHLY)
                    ->where(Event::MONTH, Event::TWO_TIMES_A_MONTH)
                    ->where(Event::HOUR, Carbon::now()->hour)
                    ->get();
            }
        }
        echo json_encode($event) . "\n";
        foreach ($event as $item) {
            if ($item['repeat'] == Event::ANNUAL) {
                $this->notificationRepository->create([
                    Notification::COLUMN_ACTION => 'event',
                    Notification::COLUMN_STATUS => Notification::UNREAD,
                    Notification::COLUMN_NOTE => $item['title'],
                    Notification::COLUMN_TITLE => $item['title'],
                    Notification::COLUMN_MESSAGE => $item['long_description'],
                    Notification::COLUMN_CREATED_BY => 'system',
                    Notification::COLUMN_IMAGE => $item['image'] ?? null
                ]);
            }
            $filter['object'] = $item['object'];
            $users = $this->userRepository->find_user_by_event($filter);
            foreach ($users as $user) {
                $device = Device::whereIn('user_id', $user)->pluck('device_token')->toArray();
                $this->firebase->setTitle($item['title']);
                $this->firebase->setMessage($item['short_description']);
                $this->firebase->setImage($item['image']);
                $message = $this->firebase->getMessage();
                $this->firebase->setType('notification');
                $data = $this->firebase->getData();
                $result = $this->firebase->sendMultiple($device, $message, $data);
                echo $result . "\n";
            }
        }
        return 0;
    }

    public function convert_day_name($dayOfWeek)
    {
        $arr = [
            'Monday' => 2,
            'Tuesday' => 3,
            'Wednesday' => 4,
            'Thursday' => 5,
            'Friday' => 6,
            'Saturday' => 7,
            'Sunday' => 8,
        ];
        return $arr[$dayOfWeek];
    }

    public function convert_hour($time)
    {
        if ($time <= 12) {
            $hour = 'AM';
        } else {
            $hour = 'PM';
        }
        return $hour;
    }

    public function convert_obj($object)
    {
        $data = [];
        if (!empty($object)) {
            $arr = explode(',', $object);
            foreach ($arr as $item) {
                if ($item == 1) {
                    $data['investment_status'] = [2];
                }
            }
        }
        return $data;
    }
}
