<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit45bd5bdf687915e95c8e0e01e6c7cbac
{
    public static $files = array (
        'a9ed0d27b5a698798a89181429f162c5' => __DIR__ . '/..' . '/khanamiryan/qrcode-detector-decoder/lib/Common/customFunctions.php',
        '5255c38a0faeba867671b61dfda6d864' => __DIR__ . '/..' . '/paragonie/random_compat/lib/random.php',
    );

    public static $prefixLengthsPsr4 = array (
        'Z' => 
        array (
            'Zxing\\' => 6,
        ),
        'P' => 
        array (
            'ParagonIE\\ConstantTime\\' => 23,
        ),
        'D' => 
        array (
            'Da\\TwoFA\\' => 9,
            'Da\\QrCode\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Zxing\\' => 
        array (
            0 => __DIR__ . '/..' . '/khanamiryan/qrcode-detector-decoder/lib',
        ),
        'ParagonIE\\ConstantTime\\' => 
        array (
            0 => __DIR__ . '/..' . '/paragonie/constant_time_encoding/src',
        ),
        'Da\\TwoFA\\' => 
        array (
            0 => __DIR__ . '/..' . '/2amigos/2fa-library/src',
        ),
        'Da\\QrCode\\' => 
        array (
            0 => __DIR__ . '/..' . '/2amigos/qrcode-library/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'B' => 
        array (
            'BaconQrCode' => 
            array (
                0 => __DIR__ . '/..' . '/bacon/bacon-qr-code/src',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit45bd5bdf687915e95c8e0e01e6c7cbac::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit45bd5bdf687915e95c8e0e01e6c7cbac::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit45bd5bdf687915e95c8e0e01e6c7cbac::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit45bd5bdf687915e95c8e0e01e6c7cbac::$classMap;

        }, null, ClassLoader::class);
    }
}