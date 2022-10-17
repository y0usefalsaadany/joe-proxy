<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfeb85d49914922ee45e7273e45aff273
{
    public static $prefixLengthsPsr4 = array (
        'Y' => 
        array (
            'Yousefpackage\\Visits\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Yousefpackage\\Visits\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInitfeb85d49914922ee45e7273e45aff273::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitfeb85d49914922ee45e7273e45aff273::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitfeb85d49914922ee45e7273e45aff273::$classMap;

        }, null, ClassLoader::class);
    }
}