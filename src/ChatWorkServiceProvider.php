<?php

namespace Revolution\Socialite\ChatWork;

use Laravel\Socialite\SocialiteServiceProvider;
use Laravel\Socialite\Facades\Socialite;

class ChatWorkServiceProvider extends SocialiteServiceProvider
{
    /**
     * Bootstrap the service provider.
     *
     * @return void
     */
    public function boot()
    {
        Socialite::extend('chatwork', function ($app) {
            $config = $app['config']['services.chatwork'];

            return Socialite::buildProvider(ChatWorkProvider::class, $config);
        });
    }
}
