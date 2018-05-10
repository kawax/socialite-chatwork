<?php

namespace Revolution\Socialite\ChatWork;

use Laravel\Socialite\SocialiteServiceProvider;
use Laravel\Socialite\Contracts\Factory;
use Laravel\Socialite\Facades\Socialite;

class ChatWorkServiceProvider extends SocialiteServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

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
