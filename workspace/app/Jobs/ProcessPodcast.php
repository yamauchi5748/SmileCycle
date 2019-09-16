<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Support\Facades\Log;

class ProcessPodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

     /** @var string view name */
     protected $view;
     /** @var array ビューに割り当てるデータ */
     protected $data;
     /** @var array メールの送信先等の属性 */
     protected $mail;
 
     public function __construct($view, $data, $mail)
     {
         $this->view = $view;
         $this->data = $data;
         $this->mail = $mail;
     }
 
     /**
      * @param Mailer $mailer
      */
     public function handle(Mailer $mailer)
     {
         $mail = $this->mail;
         $mailer->send($this->view, $this->data, function ($message) use ($mail)
         {
            Log::info('テストJob');
            $message->subject($mail['subject'])
                    ->from($mail['from'], $mail['f_name'])
                    ->to($mail['to'], $mail['to_name']);
         });
     }
}
