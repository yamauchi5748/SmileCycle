<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Member;
use App\Models\ChatRoom;

class MailNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:notice {--I|interval=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mail Notification.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $interval = $this->option('interval');
        $members = array_column(Member::raw()->aggregate(
            [
                [
                    '$match' => [
                        'is_notification' => 1,
                        'notification_interval' => $interval
                    ]
                ],
                [
                    '$project' => [
                        '_id' => 1
                    ]
                ]
            ]
        )->toArray(), '_id');
        $chatRooms = ChatRoom::raw()->aggregate([])->toArray();
        foreach ($chatRooms as $chatRoom) {
            // dump($chatRoom->members->get());
            // $in = array_intersect($members, $chatRoom->members);
            // dump($in);
        }
    }
}
