<?php
    $loader = require(__DIR__ . '/vendor/autoload.php');
    $loader->addPsr4('PickASpy\\', 'src/');

    $CONFIG = require(__DIR__ . '/config.php');

    $BETA = strpos(__DIR__, 'beta') !== false;
    $REMOTE_ADDR = $_SERVER['HTTP_X_FORWARDED_FOR'];

    $validator = new \PickASpy\Validator($CONFIG['recaptchaKey'], $REMOTE_ADDR);

    if (!$validator->validateForm()) {
        header('HTTP/ 406 Invalid Request');
        error_log('Invalid Request');
        return;
    }

    $postNumbers = explode(',', $_POST['numbers']);
    $validNumbers = $validator->validateNumbers($postNumbers);
    if (empty($validNumbers)) {
        header('HTTP/ 406 No valid numbers given');
        error_log('No valid numbers');
        return;
    }

    $count = count($validNumbers);
    $class = '\\PickASpy\\Game\\' . $_POST['gametype'];
    $game = new $class($count);

    $roles = $game->getMessages();
    // error_log("\n");
    // error_log(count($roles));
    // error_log($validator->formatNumber($validNumbers[0], \libphonenumber\PhoneNumberFormat::E164));
    // error_log($roles[0]);
    // error_log("\n");

    // Send texts
    $client = new \Twilio\Rest\Client($CONFIG['twilio']['sid'], $CONFIG['twilio']['token']);
    foreach($validNumbers as $i => $number_obj) {
        // Use the client to do fun stuff like send text messages!
        $client->messages->create(
  /* to: */ $validator->formatNumber($number_obj, \libphonenumber\PhoneNumberFormat::E164),
            [
                'from' => $CONFIG['twilio']['number'],
                'body' => $roles[$i]
            ]
        );
    }

    // Return JSON of valid numbers
    header('Content-Type: application/json');
    $outputFormat = function($number_obj) {
        global $validator;
        return $validator->formatNumber($number_obj, \libphonenumber\PhoneNumberFormat::NATIONAL);
    };
    echo json_encode([
        'numbers' => array_map($outputFormat, $validNumbers),
        'role' => $game->successMessage
    ]);
?>
