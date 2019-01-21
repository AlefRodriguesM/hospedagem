<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit70f9d53e5983e45f06c516f522cad8c8
{
    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'Balloonmkt\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Balloonmkt\\' => 
        array (
            0 => __DIR__ . '/..' . '/balloonmkt/php-classes/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit70f9d53e5983e45f06c516f522cad8c8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit70f9d53e5983e45f06c516f522cad8c8::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
