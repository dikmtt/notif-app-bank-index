<?php

namespace App\Providers;

use App\Models\Subscriber;
use BeyondCode\Mailbox\Facades\Mailbox;
use BeyondCode\Mailbox\InboundEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Telegram\Bot\Laravel\Facades\Telegram;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if($this->app->environment('production') || $this->app->environment('staging')) {
            URL::forceScheme('https');
        }
        Mailbox::to(env('MAIL_TEST'), function(InboundEmail $email) {
            //handling here
            $subject = $email->subject();
            $content = $email->text();
            Log::info("Email subject: {$subject} content: {$content}");
        });
    }
}
