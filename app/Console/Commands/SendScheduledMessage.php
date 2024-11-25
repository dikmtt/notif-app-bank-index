<?php

namespace App\Console\Commands;

use App\Http\Controllers\MessageController;
use App\Jobs\SendScheduledNotificationJob;
use App\Models\Notification;
use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Models\Subscriber;
use Carbon\Carbon;

class SendScheduledMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:scheduledmessage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Scheduled Message';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $not = Notification::with('message')
        ->whereBetween('sent_at', ['2024-01-01 01:00:00', now()->startOfMinute()])
        ->update(['is_response' => 0]);
        $notifs = Notification::with('message')
                ->where('scheduled_at', '>=', Carbon::now()->toDateTimeString())
                ->whereNull('is_response')->get();
        foreach($notifs as $n) {
            $messtitle = $n->message->subject;
            $messcontent = $n->message->content;
            $messtype = $n->channel_type;
            $messsa = Carbon::parse($n->scheduled_at);
            $subs = $n->users_sent_to;
            SendScheduledNotificationJob::dispatch($messtitle, $messcontent, $messtype, $subs)->onQueue('default')->delay($messsa);
        }

        
        //}
    }
}
