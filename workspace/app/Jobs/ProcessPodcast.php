<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Mail\Mailer;

class ProcessPodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var string view name */
    protected $view;
    /** @var array ビューに割り当てるデータ */
    protected $data;
    /** @var array メールの送信先等の属性 */
    protected $mail;
 
    public function __construct()
    {
        $mail = [
            'from'    => env('MAIL_FROM_ADDRESS', ''),
            'f_name'  => env('MAIL_FROM_NAME', ''),
            'to'      => env('MAIL_TO_NAME', ''),
            'to_name' => env('MAIL_TO_NAME', ''),
            'subject' => 'テストメールです'
        ];

        $this->view = 'contact.mail';
        $this->data = ['count' => 10];
        $this->mail = $mail;
    }
 
    /**
     * @param Mailer $mailer
     */
    public function handle(Mailer $mailer)
    {
        $mail = $this->mail;
        $mailer->send($this->view, $this->data, function ($message) use ($mail) {
            $message->subject($mail['subject'])
                    ->from($mail['from'], $mail['f_name'])
                    ->to($mail['to'], $mail['to_name']);
        });
    }
}
