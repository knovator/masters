<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit44c8a905d918946eeff1de8e89165481
{
    public static $prefixLengthsPsr4 = array (
        'K' => 
        array (
            'Knovators\\Masters\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Knovators\\Masters\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit44c8a905d918946eeff1de8e89165481::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit44c8a905d918946eeff1de8e89165481::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
