<?php

namespace App\Telegram\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class StartCommand extends Command
{
    protected string $name = 'start';
    protected string $description = 'Start Command to get you started';

    public function handle()
    {
        $fallbackUsername = $this->getUpdate()->getMessage()->from->username;
        $username = $this->argument('username', $fallbackUsername);
        $this->replyWithMessage([
            'text' => "Hey, {$username}! Welcome to our bot!",
        ]);
        $this->replyWithMessage([
            'text' => 'Subscribe in order to not miss any notifications by typing the command below:',
        ]);
        $this->replyWithMessage([
            'text' => '/subscribe [access token]',
        ]);
    }
}