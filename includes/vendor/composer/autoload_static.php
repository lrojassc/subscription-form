<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5723cb7f9b7832e91db5d90acac0a903
{
    public static $files = array (
        '8dd32984d4cd58147cb41bf3844153c3' => __DIR__ . '/..' . '/chargebee/chargebee-php/lib/ChargeBee.php',
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit5723cb7f9b7832e91db5d90acac0a903::$classMap;

        }, null, ClassLoader::class);
    }
}
