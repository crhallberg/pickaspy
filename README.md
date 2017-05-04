# Pick A Spy

After pulling, run `composer install`.

## Configuration

Configurations for [reCAPTCHA](https://www.google.com/recaptcha/intro/invisible.html) and [Twilio](https://www.twilio.com/) are pulled from two files, `config.js` and `config.php`, in the root folder.

```javascript
const RECAPTCHA_KEY = 'KEY';
```

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

## Thank You

Built using the following tools:

Dev: [Notepad++](https://notepad-plus-plus.org/), [Composer](https://getcomposer.org/), [FileZilla](https://filezilla-project.org/), [GIMP](https://www.gimp.org/)

Back: [Twilio](https://www.twilio.com/), [libphonenumber](https://github.com/googlei18n/libphonenumber) ([php port](https://github.com/giggsey/libphonenumber-for-php))

Front: [Chex](https://crhallberg.com/chex), [Font Awesome](http://fontawesome.io), [Normalize.css](https://github.com/necolas/normalize.css)
