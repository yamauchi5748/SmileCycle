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
    protected $mail;
 
    public function __construct($room, $chat, $to_member)
    {
        $this->mail = [
            'from'    => env('MAIL_FROM_ADDRESS'),
            'f_name'  => env('MAIL_FROM_NAME'),
            'to'      => $to_member['mail'],
            'to_name' => $to_member['mail'],
            'subject' => 'テストメールです'
        ];

        /**
         * ここに配信用メールアカウントを切り替える処理を追加
         *
         **/

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
