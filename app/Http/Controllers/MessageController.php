<?php

namespace App\Http\Controllers;

use App\Jobs\SendScheduledNotificationJob;
use App\Mail\NotifEmail;
use App\Models\EmailQuery;
use App\Models\Message;
use App\Models\Notification;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    public function newmessage() {
        return view('newmessage');
    }

    public function savemessage(Request $req) {
        $message = Message::create([
            'subject' => $req->title,
            'content' => $req->content
        ]);
        return redirect('home');
    }

    public function sendmenu() {
        return view('sendmenu');
    }

    public function sendmessage() {
        $messages = Message::select('*')->get();
        return view('sendmessage', ['mess' => $messages]);
    }

    public function sendmessage2() {
        $messages = Message::select('*')->get();
        $users = Subscriber::select('*')->get();
        return view('sendmessage2', ['mess' => $messages, 'users' => $users]);
    }
    
    public function sendmessagep(Request $req) {
        $mess = Message::find($req->message);
        $sch = $req->scheduled;
        $scheduled_at = DateTime::createFromFormat('Y-m-d\TH:i', $sch);
        $subs1 = new Collection();
        if($req->send_to == "all") {
            $subs1 = Subscriber::select('*')->get();
            $usr = null;
        } else {
            foreach($req->recips as $s) {
                $sub = Subscriber::select('*')->where('subscriber_id', $s)->first();
                $subs1->push($sub);
            }
        }
            if($req->channel == "telegram") {
                $subs = $subs1;
            }
            else {
                $remove = null;
                $subs = $subs1->filter(function ($value, $key) use($remove){
                    return $value['email']!=$remove;
                });
            }
        if($req->send_to == "certain") {
            $usr = serialize($subs);
        }
        //if category is green then send message once
        //if category is red then call the scheduler Artisan::call('command"name') maybe
        if($req->channel == "telegram") {
            if($req->category == "green") {
                foreach($subs as $s) {
                    $response = Telegram::sendMessage([
                        'parse_mode' => 'HTML',
                        'chat_id' => $s->subscriber_id,
                        'text' => '<b>'.$mess->subject.'</b>'."\n".$mess->content
                    ]);
                }
                $scheduled_at = null;
                $this->newRecord($req, $scheduled_at, $usr);
                if($req->recur == 1) {
                    Artisan::call('send:scheduledmessage');
                }
            } else {
                $this->newRecord($req, $scheduled_at, $usr);
                if($scheduled_at != null) {
                    Artisan::call('send:scheduledmessage');
                } else {
                    foreach($subs as $s) {
                        $response = Telegram::sendMessage([
                            'parse_mode' => 'HTML',
                            'chat_id' => $s->subscriber_id,
                            'text' => '<b>'.$mess->subject.'</b>'."\n".$mess->content
                        ]);
                    }
                    if($req->recur == 1) {
                        Artisan::call('send:scheduledmessage');
                    }
                }
            }
        } else {
            //email stuff here
            //scan through all the users emails in the users table
            //then mail each user
            if($req->category == "green") {
                foreach($subs as $s) {
                    Mail::to($s->email)->send(new NotifEmail($mess->subject, $mess->content));
                }
                $scheduled_at = null;
                $this->newRecord($req, $scheduled_at, $usr);
            } else {
                $this->newRecord($req, $scheduled_at, $usr);
                if($scheduled_at != null) {
                    Artisan::call('send:scheduledmessage');
                } else {
                    foreach($subs as $s) {
                        Mail::to($s->email)->send(new NotifEmail($mess->subject, $mess->content));
                    }
                }
            }
        }
        return redirect('home');
    }

    public function newRecord(Request $req, $scheduled, $usr) {
        if($req->interval <= 1 || $req->interval == null || $req->recur == '0') {
            $iterations = 1;
        } else {
            $iterations = $req->interval;
        }
        $time = $scheduled;
        for($i = 0; $i < $iterations; $i++) {
            $notif = Notification::create([
                'sender_id' => Auth::user()->id,
                'channel_type' => $req->channel,
                'message_id' => $req->message,
                'category' => $req->category,
                'sent_at' => Carbon::now()->toDateTimeString(),
                'is_recurring' => $req->recur,
                'duration' => $req->duration,
                'interval' => $req->interval,
                'scheduled_at' => $time,
                'users_sent_to' => $usr,
                //'is_response' => $req->resp
            ]);
            if($req->duration != null) {
                if($scheduled == null) { $time = $time ?: Carbon::now(); }
                if($time != null) {
                    $time->modify("+{$req->duration} minutes");
                }
            }
        }
    }

    public function getDateAttribute($value) {
        return Carbon::parse($value)->format('Y-m-d\TH:i');
    }

    public function sendMessageSep(String $title, String $content) {
        $subs = Subscriber::select('*')->get();
        foreach($subs as $s) {
            $response = Telegram::sendMessage([
                'parse_mode' => 'HTML',
                'chat_id' => $s->subscriber_id,
                'text' => '<b>'.$title.'</b>'."\n".$content
            ]);
        }
    }

    public function deleteOldNotifs() {
        Notification::whereDate('created_at', '<=', now()->subDays(7))->delete();
    }

    public function loadMessageList() {
        $mess = Message::select('*')->get();
        return view('messagelist', ['message' => $mess]);
    }

    public function editMessage($id) {
        $mess = Message::select('*')->where('id', $id)->get();
        return view('editmessage', ['message' => $mess]);
    }

    public function updateMessage(Request $request) {
        $mess = Message::select('*')->where('id', $request->id)
                ->update(['subject' => $request->subject,
                        'content' => $request->content]);
        return redirect()->route('messagelist');
    }

    public function deleteMessage($id) {
        $mess = Message::select('*')->where('id', $id)->delete();
        return redirect()->route('messagelist');
    }

    public function clearNotifHistory() {
        $notif = Notification::truncate();
        return redirect()->route('settings');
    }

    public function querylist() {
        $queries = EmailQuery::with('sub')->select('*')->get();
        return view('querylist', ['query' => $queries]);
    }

    public function addquery() {
        $subs = Subscriber::select('*')->get();
        return view('addsendquery', ['subs' => $subs]);
    }

    public function savequery(Request $req) {
        $query = EmailQuery::create([
            'querystring' => $req->string,
            'targetsubid' => $req->target
        ]);
        return redirect()->route('querylist');
    }

    public function deleteQuery($id) {
        $user = EmailQuery::select('*')->where('id', $id)->delete();
        return redirect()->route('querylist');
    }

    public function notifhistory() {
        $notifs = Notification::with('message')->select('*')->groupBy('sent_at')->orderBy('sent_at', 'desc')->simplePaginate(10);
        return view('notifhistory', ['notifs' => $notifs]);
    }

    public function filternotifs(Request $req) {
        //dd($req);
        $notif = Notification::with('message')->select('*');
        if($req->sent_time == "week") {
            $notif->whereDate('sent_at', Carbon::now()->subDays(7));
        } else if ($req->sent_time == "month") {
            $notif->whereMonth('sent_at', Carbon::now()->month);
        } else if($req->sent_time == "custom") {
            $notif->whereBetween('sent_at', [$req->startdate, $req->enddate]);
        }
        if($req->channel == "telegram") {
            $notif->where(['channel_type' => 'telegram']);
        } else if ($req->channel == "email") {
            $notif->where(['channel_type' => 'email']);
        }
        if($req->type == "red") {
            $notif->where(['category' => 'red']);
        } else if ($req->type == "green") {
            $notif->where(['category' => 'green']);
        }
        if($req->recur == "yes") {
            $notif->where(['is_recurring' => '1']);
        } else if ($req->recur == "no") {
            $notif->where(['is_recurring' => '0']);
        }
        //$notif->groupBy('sent_at')->orderBy('sent_at', 'desc')->simplePaginate(10);
        $notifs = $notif->groupBy('sent_at')->orderBy('sent_at', 'desc')->simplePaginate(10);

        $notifs->appends($req->all());
        //dd($notifs);
        return view('notifhistory', ['notifs' => $notifs]);
    }

    public function findmessage(Request $req) {
        //dd($req);
        if($req->search_by == "title") {
            $search = 'subject';
        } else {
            $search = 'content';
        }
        $mess = Message::select('*')->where($search, 'like', "%".$req->strq."%")->get();
        return view('messagelist', ['message' => $mess]);
    }

}
