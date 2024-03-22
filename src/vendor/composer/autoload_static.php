<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb6cb68375b51c0dbfa3e6f61471450ef
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Test\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Test\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb6cb68375b51c0dbfa3e6f61471450ef::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb6cb68375b51c0dbfa3e6f61471450ef::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb6cb68375b51c0dbfa3e6f61471450ef::$classMap;

        }, null, ClassLoader::class);
    }
}