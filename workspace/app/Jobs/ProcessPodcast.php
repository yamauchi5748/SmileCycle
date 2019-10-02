<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Mail\Mailer;
use App\Models\Member;
use App\Models\ChatRoom;

class ProcessPodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var string view name */
    protected $view;
    /** @var array ビューに割り当てるデータ */
    protected $data;
    /** @var array メールの送信先等の属性 */
    protected $mails = [];
 
    public function __construct($chat_room_id, $chat)
    {
        /* ルーム情報を取得 */
        $room = head(ChatRoom::raw()->aggregate([
            [
                '$match' => [
                    '_id' => $chat_room_id
                ]
            ],
            [
                '$project' => [
                    '_id' => 0,
                    'group_name' => 1,
                    'members' => 1,
                ]
            ]
        ])->toArray());

        $to_members = $room['members'];
        
        /* ルーム会員に送信するメール情報をセット */
        foreach ($to_members as $to_member) {
            $to_member = head(Member::raw()->aggregate([
                [
                    '$match' => [
                        '_id' => $to_member->_id
                    ]
                ],
                [
                    '$project' => [
                        'name' => 1,
                        'mail' => 1
                    ]
                ]
            ])->toArray());
            
            $mail = [
                'from'    => env('MAIL_FROM_ADDRESS'),
                'f_name'  => env('MAIL_FROM_NAME'),
                'to'      => $to_member['mail'],
                'to_name' => $to_member['mail'],
                'subject' => 'テストメールです'
            ];

            $this->mails[] = $mail;

            /**
             * ここに配信用メールアカウントを切り替える処理を追加
             * 
             * **/
        }

        /* メール本文を表示するbladeを設定 */
        $this->view = 'contact.mail';

        /**
         * bladeで扱うデータを記述
         * @string sender_name: 送信者
         * @string room_name: ルーム名
         *  
         **/
        $this->data = [
            'room_name' => $room['group_name'],
            'sender_name' => $chat['sender_name']
        ];
    }
 
    /**
     * @param Mailer $mailer
     */
    public function handle(Mailer $mailer)
    {   
        /* 設定された会員分メール送信ジョブを実行 */
        foreach ($this->mails as $mail) {
            $mailer->send($this->view, $this->data, function ($message) use ($mail) {
                $message->subject($mail['subject'])
                        ->from($mail['from'], $mail['f_name'])
                        ->to($mail['to'], $mail['to_name']);
            });
        }
    }
}
