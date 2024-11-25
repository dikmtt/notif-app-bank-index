<?php

namespace App\Telegram\Commands;

use App\Models\Notification;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class RespondCommand extends Command
{
    protected string $name = 'respond';
    protected string $description = 'Don\'t';

    public function handle()
    {
        $job = DB::table('jobs')->first();
        $created = $job->created_at;
        $allsent = DB::table('jobs')->where('created_at', $created)->delete();
        $created_as_date = date('Y-m-d H:i:s', $created);
        $upd = Notification::where('sent_at', $created_as_date)->update(['is_response' => 1]);
        $this->replyWithMessage([
            'text' => "respond command test",
        ]);
    }
}