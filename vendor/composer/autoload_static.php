<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2288e49f9e73410f00e9059cee0bf1bd
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2288e49f9e73410f00e9059cee0bf1bd::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2288e49f9e73410f00e9059cee0bf1bd::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
