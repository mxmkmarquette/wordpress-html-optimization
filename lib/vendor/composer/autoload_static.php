<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit249ac84c051a5cb9a48012cb99a879bd
{
    public static $prefixLengthsPsr4 = array (
        'v' => 
        array (
            'voku\\helper\\' => 12,
            'voku\\' => 5,
        ),
        'S' => 
        array (
            'Symfony\\Component\\CssSelector\\' => 30,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'voku\\helper\\' => 
        array (
            0 => __DIR__ . '/..' . '/voku/simple_html_dom/src/voku/helper',
        ),
        'voku\\' => 
        array (
            0 => __DIR__ . '/..' . '/voku/html-min/src/voku',
        ),
        'Symfony\\Component\\CssSelector\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/css-selector',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit249ac84c051a5cb9a48012cb99a879bd::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit249ac84c051a5cb9a48012cb99a879bd::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
