<?php

namespace Revolution\Socialite\ChatWork;

use Laravel\Socialite\SocialiteServiceProvider;
use Laravel\Socialite\Contracts\Factory;

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
        $socialite = $this->app->make(Factory::class);

        $socialite->extend('chatwork', function ($app) use ($socialite) {
            $config = $this->app['config']['services.chatwork'];

            return $socialite->buildProvider(ChatWorkProvider::class, $config);
        });
    }
}
