<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdb007e8d2255c84d9c382b5d6136aa4c
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Tools\\' => 6,
        ),
        'A' => 
        array (
            'APP\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Tools\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
        'APP\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'APP\\Controller\\GestionClientController' => __DIR__ . '/../..' . '/src/Controller/GestionClientController.php',
        'APP\\Controller\\IdentificationController' => __DIR__ . '/../..' . '/src/Controller/IdentificationController.php',
        'APP\\Entity\\Client' => __DIR__ . '/../..' . '/src/Entity/Client.php',
        'APP\\Entity\\Commande' => __DIR__ . '/../..' . '/src/Entity/Commande.php',
        'APP\\Model\\GestionClientModel' => __DIR__ . '/../..' . '/src/Model/GestionClientModel.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitdb007e8d2255c84d9c382b5d6136aa4c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitdb007e8d2255c84d9c382b5d6136aa4c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitdb007e8d2255c84d9c382b5d6136aa4c::$classMap;

        }, null, ClassLoader::class);
    }
}
