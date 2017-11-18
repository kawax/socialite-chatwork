<?php

namespace Tests;

use Mockery as m;
use PHPUnit\Framework\TestCase;

use Illuminate\Http\Request;
use Laravel\Socialite\SocialiteManager;

use Revolution\Socialite\ChatWork\ChatWorkProvider;

class SocialiteTest extends TestCase
{
    /**
     * @var SocialiteManager
     */
    protected $socialite;

    public function setUp()
    {
        parent::setUp();

        $app = ['request' => Request::create('foo')];

        $this->socialite = new SocialiteManager($app);

        $this->socialite->extend('chatwork', function ($app) {
            return $this->socialite->buildProvider(ChatWorkProvider::class, [
                'client_id'     => 'test',
                'client_secret' => 'test',
                'redirect'      => 'https://localhost',
            ]);
        });
    }

    public function tearDown()
    {
        m::close();
    }

    public function testInstance()
    {
        $provider = $this->socialite->driver('chatwork');

        $this->assertInstanceOf(ChatWorkProvider::class, $provider);
    }

    public function testRedirect()
    {
        $request = Request::create('foo');
        $request->setLaravelSession($session = m::mock('Illuminate\Contracts\Session\Session'));
        $session->shouldReceive('put')->once();

        $provider = new ChatWorkProvider($request, 'client_id', 'client_secret', 'redirect');
        $response = $provider->redirect();

        $this->assertStringStartsWith('https://www.chatwork.com/packages/oauth2/login.php', $response->getTargetUrl());
    }
}
