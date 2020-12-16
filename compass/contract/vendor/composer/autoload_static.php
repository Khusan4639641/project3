<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita89072494c4c85f08da97285f644080e
{
    public static $prefixLengthsPsr4 = array (
        'Z' => 
        array (
            'Zend\\Escaper\\' => 13,
        ),
        'P' => 
        array (
            'PhpOffice\\PhpWord\\' => 18,
            'PhpOffice\\Common\\' => 17,
        ),
        'I' => 
        array (
            'IRebega\\DocxReplacer\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Zend\\Escaper\\' => 
        array (
            0 => __DIR__ . '/..' . '/zendframework/zend-escaper/src',
        ),
        'PhpOffice\\PhpWord\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpoffice/phpword/src/PhpWord',
        ),
        'PhpOffice\\Common\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpoffice/common/src/Common',
        ),
        'IRebega\\DocxReplacer\\' => 
        array (
            0 => __DIR__ . '/..' . '/irebega/docx-replacer/src',
        ),
    );

    public static $classMap = array (
        'PclZip' => __DIR__ . '/..' . '/pclzip/pclzip/pclzip.lib.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita89072494c4c85f08da97285f644080e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita89072494c4c85f08da97285f644080e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita89072494c4c85f08da97285f644080e::$classMap;

        }, null, ClassLoader::class);
    }
}
