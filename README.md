# Pick A Spy

After pulling, run `composer install`.

## Config

Configurations for [reCAPTCHA](https://www.google.com/recaptcha/intro/invisible.html) and [Twilio](https://www.twilio.com/) are pulled from a file `config.php` in the root folder.

```php
<?php
    return [
        'recaptchaKey' => '',
        'twilio' => [
            'sid' => '',
            'token' => '',
            'number' => '+15555555555'
        ]
    ];
```
