<?php

namespace App\Http\Controllers;

use App\Mail\NotifEmail;
use App\Models\EmailQuery;
use App\Models\Subscriber;
use BeyondCode\Mailbox\Drivers\Mailgun;
use BeyondCode\Mailbox\Facades\Mailbox;
use BeyondCode\Mailbox\InboundEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\Log;

class NotifEmailController extends Controller
{
    public function send() {
        $message = "yee haw";
        $mess2 = "haw yee";
        Mail::to(env('MAIL_TEST'))->send(new NotifEmail($message, $mess2));
        return "sent";
    }

    public function createDriver() {
        Mailbox::createMailgunDriver();
        return route('home');
    }

    public function handlemailgun(Request $request) {
        //Log::info($request->getContent());
        $email = InboundEmail::fromMessage($request->get('body-mime'));
        $queries = EmailQuery::select('*')->get();
        $queryAvailable = false;
        $subject = $email->subject();
        $content = $email->text();
        $recip = $email->to();
        foreach($queries as $q) {
            if(str_contains($subject, $q->querystring)) {
                $queryAvailable = true;
                break;
            }
        }
        //Log::info("Email: $subject, $content");
        //});
            foreach($recip as $r) {
                if($queryAvailable) {
                    $user = Subscriber::select('*')->where('subscriber_id', '=', $q->targetsubid)->first();
                } else {
                    $user = Subscriber::select('*')->where('email', '=', $r)->first();
                }
                if($user != null) {
                    //send to telegram
                    $response = Telegram::sendMessage([
                        'parse_mode' => 'HTML',
                        'chat_id' => $user->subscriber_id,
                        'text' => '<b>'.$subject.'</b>'."\n".$content
                    ]);
                }
            }
            return "test";
    }
}
