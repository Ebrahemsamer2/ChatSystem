<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitaab13dcd5c1e736bc99ac1d854c2b856
{
    public static $prefixLengthsPsr4 = array (
        'H' => 
        array (
            'Hashids\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Hashids\\' => 
        array (
            0 => __DIR__ . '/..' . '/hashids/hashids/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitaab13dcd5c1e736bc99ac1d854c2b856::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitaab13dcd5c1e736bc99ac1d854c2b856::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}