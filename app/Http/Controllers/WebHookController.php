<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Telegram\Bot\Laravel\Facades\Telegram;

class WebHookController extends Controller
{
    public function setwebhook() {
        Telegram::setWebhook(['url' => env('TELEGRAM_WEBHOOK_URL')]);
        return redirect('settings');
    }

    public function commandhandler() {
            $update = Telegram::commandsHandler(true);
            // Commands handler method returns the Update object.
            // So you can further process $update object
            // to however you want.
            $update2 = Telegram::getWebhookUpdate();
            $isCallback = $update2->getCallbackQuery();
                if($isCallback) {
                    $data = $isCallback->getData();
                    $chatId = $isCallback['message']['chat']['id'];
                    $messId = $isCallback['message']['message_id'];
                    $new_inline_markup = [
                        'inline_keyboard' => [
                            [
                                ['text' => 'Responded!']
                            ]
                        ]
                    ];
                    if($data === "resp") {
                        $text = $isCallback['message']['text'];
                        $title = explode("\n", $text);
                        $job = DB::table('jobs')->where('payload', 'like', '%' . $title[0] . '%')->first();
                        if($job != null) {
                            $created = $job->created_at;
                            $allsent = DB::table('jobs')->where('created_at', $created)->delete();
                            $created_as_date = date('Y-m-d H:i:s', $created);
                            $upd = Notification::where('sent_at', $created_as_date)->update(['is_response' => 1]);
                        }
                        Telegram::sendMessage([
                            'chat_id' => $chatId,
                            'text' => "respond command test",
                        ]);
                    }
                }
        
            return $update;
    }

    public function handle() {
        
    }
}
