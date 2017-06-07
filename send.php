<?php
    session_start();

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

    // Send texts
    $client = new \Twilio\Rest\Client($CONFIG['twilio']['sid'], $CONFIG['twilio']['token']);
    // Send link-back thank you
    if (!isset($_SESSION['thanked'])) {
        foreach($validNumbers as $i => $number_obj) {
            $client->messages->create(
                $validator->formatNumber($number_obj, \libphonenumber\PhoneNumberFormat::E164), // TO:
                [
                    'from' => $CONFIG['twilio']['number'],
                    'body' => 'Thank you for using pickaspy.com!'
                ]
            );
        }
        $_SESSION['thanked'] = true;
    }
    // Use the client to do fun stuff like send text messages!
    foreach($validNumbers as $i => $number_obj) {
        $client->messages->create(
            $validator->formatNumber($number_obj, \libphonenumber\PhoneNumberFormat::E164), // TO:
            [
                'from' => $CONFIG['twilio']['number'],
                'body' => $roles[$i]
            ]
        );
    }

    // Report SESSION id, game, and number of players
    error_log(sprintf('[GAME][%d]: %s %s', count($validNumbers), session_id(), $_POST['gametype']));

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
