# Socialite for ChatWork

http://developer.chatwork.com/ja/

## Requirements
- PHP >= 7.2

## Installation
```
composer require revolution/socialite-chatwork
```

### config/services.php

```
    'chatwork' => [
        'client_id'     => env('CHATWORK_CLIENT_ID'),
        'client_secret' => env('CHATWORK_CLIENT_SECRET'),
        'redirect'      => env('CHATWORK_REDIRECT'),
    ],
```

### .env
```
CHATWORK_CLIENT_ID=
CHATWORK_CLIENT_SECRET=
CHATWORK_REDIRECT=
```

## Usage

routes/web.php
```
Route::get('login', 'ChatWorkController@login');
Route::get('callback', 'ChatWorkController@callback');
```

ChatWorkController

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;

class ChatWorkController extends Controller
{
    public function login()
    {
        return Socialite::driver('chatwork')->redirect();
    }

    public function callback()
    {
        $user = Socialite::driver('chatwork')->user();
        dd($user);
    }
}

```

## Scopes

http://developer.chatwork.com/ja/oauth.html#secAppendix

```php
    public function login()
    {
        return Socialite::driver('chatwork')
                        ->setScopes(['users.all:read'])
                        ->redirect();
    }
```

## Demo
https://github.com/kawax/socialite-project

## LICENCE
MIT
Copyright kawax
