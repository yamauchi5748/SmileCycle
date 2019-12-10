<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Member;
use App\Models\ChatRoom;
use App\Jobs\MailNotice;

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
        $match = ['is_notification' => 1];
        $interval = $this->option('interval');
        if (!is_null($interval)) {
            $match['notification_interval'] = $interval;
        }
        $members = Member::raw()->aggregate(
            [
                [
                    '$match' => $match
                ],
                [
                    '$set' => [
                        'unread' => 0
                    ]
                ],
                [
                    '$project' => [
                        '_id' => 1,
                        'name' => 1,
                        'mail' => 1,
                        'unread' => 1
                    ]
                ]
            ]
        )->toArray();
        $membersIds = array_column($members, '_id');
        $chatRooms = ChatRoom::raw()->aggregate([])->toArray();
        foreach ($chatRooms as $chatRoom) {
            $in = array_intersect($membersIds, array_column($chatRoom->members->bsonSerialize(), '_id'));
            foreach ($chatRoom->contents as $content) {
                $unreadMembers = array_diff($in, $content->already_read->bsonSerialize());
                foreach ($unreadMembers as $unreadMember) {
                    $members[array_search($unreadMember, $membersIds)]->unread++;
                }
            }
        }
        foreach ($members as $member) {
            if ($member->unread > 0) {
                $job = new MailNotice($member->name, $member->mail, $member->unread);
                dispatch($job);
            }
        }
    }
}
