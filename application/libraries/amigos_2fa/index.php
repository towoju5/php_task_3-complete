<?php

use Da\TwoFA\Manager;
use Da\TwoFA\Service\QrCodeDataUriGeneratorService;
use Da\TwoFA\Service\TOTPSecretKeyUriGeneratorService;

require_once 'vendor/autoload.php';

class Amigos
{
    public static function getCode()
    {
        $manager = new Manager();
        $secretKey = $manager->generateSecretKey();

        // first we need to create our time-based one time password secret uri
        $totpUri = (new TOTPSecretKeyUriGeneratorService('your-company', "johndoe@example.com", $secretKey))->run();
        $uri = (new QrCodeDataUriGeneratorService($totpUri))->run();

        return [
            "secret" => $secretKey,
            "qrcode" => $uri,
        ];
    }

    public static function verify($key, $secret)
    {
        $manager = new Manager();
        $valid = $manager->verify($key, $secret);
        return $valid;
    }
}
