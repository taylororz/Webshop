<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8c2c054f07b14347bbe69485055ff7aa
{
    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'PHPGangsta_GoogleAuthenticator' => __DIR__ . '/..' . '/phpgangsta/googleauthenticator/PHPGangsta/GoogleAuthenticator.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit8c2c054f07b14347bbe69485055ff7aa::$classMap;

        }, null, ClassLoader::class);
    }
}
