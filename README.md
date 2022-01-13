# Laravel Passport OTP Grant

This is a small package for laravel passport otp authentication easy to integrate.

## How to

Following are a few steps you need to follow to make it work.

1. Install this package using the composer

```shell
composer require moeen-basra/laravel-passport-otp-grant
```

2. Implement the `MoeenBasra\OneTimePinGrant\Interfaces\OneTimePinGrantUserInterface` on your desired provider model.

```php

use Illuminate\Foundation\Auth\User as BaseUser;
use MoeenBasra\OneTimePinGrant\Interfaces\OneTimePinGrantUserInterface;

class User extends BaseUser implements OneTimePinGrantUserInterface
{
    //...
    
    /**
     * {@inheritDoc}
     */
    public function validateForPassportOtpGrant(string $mobile_number, string $code)
    {
        if (!OneTimePin::validate($mobile_number, $code)) {
            return null;
        }
        
        return static::firstOrCreate([
            'mobile_number' => $mobile_number
        ]);
    }
}
```

3. This step is optional, add the service provider under the providers array in `confing/app.php`.
```php
   'providers' => [
        //...
        MoeenBasra\OneTimePinGrant\OneTimePinGrantServiceProvider::class,
    ]
```

That's it now you can call the otp login using same params you use for other passport end points

```shell
curl --location --request POST 'https://api.example.com/oauth/token' \
--header 'Content-Type: application/json' \
--header 'Accept: application/json' \
--form 'username="mobile_number"' \
--form 'password="code"' \
--form 'grant_type="otp"' \
--form 'client_id="client_id"' \
--form 'client_secret="client_secret"' \
--form 'scope="*"'
```

## More
You can check out the [Laravel Passport](https://laravel.com/docs/master/passport) official documentation for more details.

## Contributions
You are welcome, you can create a [pull request](https://github.com/qiutuleng/vue-router-modern/pulls).
You will be credited for any contribution.

## Issues
If you are facing any problem feel free to report [here](https://github.com/qiutuleng/vue-router-modern/issues).
