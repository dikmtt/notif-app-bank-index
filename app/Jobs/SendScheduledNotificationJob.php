<?php

namespace App\Jobs;

use App\Mail\NotifEmail;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class SendScheduledNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $title;
    public $message;
    public $usr;
    public $type;
    public function __construct($title, $message, $type, $subs)
    {
        $this->usr = $subs;
        $this->title = $title;
        $this->message = $message;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->usr == null) {
            $subs = Subscriber::select('*')->get();
        } else {
            $subs = unserialize($this->usr);
        }
        if($this->type == "telegram") {
            $reply_markup = Keyboard::make()
                ->setResizeKeyboard(true)
                ->setOneTimeKeyboard(true)
                ->row([Keyboard::inlineButton(['text' => 'Respond', 'callback_data' => 'resp'])]);
            $inline_markup = [
                'inline_keyboard' => [
                    [
                        ['text' => 'Respond', 'callback_data' => 'resp']
                    ]
                ]
            ];
            foreach($subs as $s) {
                $response = Telegram::sendMessage([
                    'parse_mode' => 'HTML',
                    'chat_id' => $s->subscriber_id,
                    'text' => '<b>'.$this->title.'</b>'."\n".$this->message,
                    'reply_markup' => json_encode($inline_markup)
                ]);
            }
        } else {
            foreach($subs as $u) {
                Mail::to($u->email)->send(new NotifEmail($this->title, $this->message));
            }
        }
    }
}
