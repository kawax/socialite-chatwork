<?php

namespace Revolution\Socialite\ChatWork;

use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;

class ChatWorkProvider extends AbstractProvider implements ProviderInterface
{
    /**
     * The scopes being requested.
     *
     * @var array
     */
    protected $scopes = [
        'users.all:read',
        'rooms.all:read_write',
        'contacts.all:read_write',
    ];

    /**
     * The separating character for the requested scopes.
     *
     * @var string
     */
    protected $scopeSeparator = ' ';

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        $url = 'https://www.chatwork.com/packages/oauth2/login.php';

        return $this->buildAuthUrlFromBase($url, $state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return 'https://oauth.chatwork.com/token';
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenFields($code)
    {
        return parent::getTokenFields($code) + ['grant_type' => 'authorization_code'];
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()
                         ->get('https://api.chatwork.com/v2/me', [
                             'headers' => [
                                 'Authorization' => 'Bearer ' . $token,
                             ],
                         ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id'       => $user['account_id'],
            'nickname' => $user['name'],
            'name'     => $user['name'],
            'email'    => $user['mail'],
            'avatar'   => $user['avatar_image_url'],
        ]);
    }
}
