<?php

// autoload.php @generated by Composer

<<<<<<< HEAD
require_once __DIR__ . '/composer/autoload_real.php';

return ComposerAutoloaderInite4915c559b80e879cabd2b16d9aefab8::getLoader();
=======
if (PHP_VERSION_ID < 50600) {
    if (!headers_sent()) {
        header('HTTP/1.1 500 Internal Server Error');
    }
    $err = 'Composer 2.3.0 dropped support for autoloading on PHP <5.6 and you are running '.PHP_VERSION.', please upgrade PHP or use Composer 2.2 LTS via "composer self-update --2.2". Aborting.'.PHP_EOL;
    if (!ini_get('display_errors')) {
        if (PHP_SAPI === 'cli' || PHP_SAPI === 'phpdbg') {
            fwrite(STDERR, $err);
        } elseif (!headers_sent()) {
            echo $err;
        }
    }
    trigger_error(
        $err,
        E_USER_ERROR
    );
}

require_once __DIR__ . '/composer/autoload_real.php';

return ComposerAutoloaderInita2f89b96e287f80bc6550b24c317414e::getLoader();
>>>>>>> fe6b33acd46739a9bdc01c036610598a520cd20c
