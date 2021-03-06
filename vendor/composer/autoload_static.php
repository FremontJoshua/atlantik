<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc7b9e6bd4c08b81fada1828ffaac387c
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Models\\' => 7,
        ),
        'K' => 
        array (
            'Kernel\\' => 7,
        ),
        'C' => 
        array (
            'Controllers\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/Models',
        ),
        'Kernel\\' => 
        array (
            0 => __DIR__ . '/../..' . '/kernel',
        ),
        'Controllers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/Controllers',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc7b9e6bd4c08b81fada1828ffaac387c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc7b9e6bd4c08b81fada1828ffaac387c::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
