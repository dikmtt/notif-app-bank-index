<?php

namespace App\Telegram\Commands;

use Telegram\Bot\Commands\Command;
use App\Models\Subscriber;

class SubscribeCommand extends Command
{
    protected string $name = 'subscribe';
    protected string $description = 'Subscribe';
    protected string $pattern = '{sub_token}';

    public function handle()
    {
        $enteredToken = $this->argument('sub_token');
        if($enteredToken == env('SUBSCRIBER_TOKEN')) {
            $fallbackUsername = $this->getUpdate()->getMessage()->from->username;
            $fallbackFirstname = $this->getUpdate()->getMessage()->from->first_name;
            $fallbackLastname = $this->getUpdate()->getMessage()->from->last_name;
            $fallbackId = $this->getUpdate()->getMessage()->from->id;
            $username = $this->argument('username', $fallbackUsername);
            $fname = $this->argument('username', $fallbackFirstname);
            $lname = $this->argument('username', $fallbackLastname);
            $name = "{$fname} {$lname}";
            $id = $this->argument('username', $fallbackId);
            $this->replyWithMessage([
                'text' => "Thanks for subscribing, {$username} aka {$name} (added to the database)",
            ]);
            $this->replyWithMessage([
                'text' => "Your user ID: {$id}",
            ]);
            $sub = Subscriber::create([
                'subscriber_id' => $id,
                'username' => $username,
                'name' => $name
            ]);
        } else {
            $this->replyWithMessage([
                'text' => "Sorry, the access token is incorrect! Please try again or contact IT",
            ]);
        }
    }
}