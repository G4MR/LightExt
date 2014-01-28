<?php

/**
 * PSR-0 Autoloading Standards
 *
 * A fully-qualified namespace and class must have the following structure \<Vendor Name>\(<Namespace>\)*<Class Name>
 * Each namespace must have a top-level namespace ("Vendor Name").
 * Each namespace can have as many sub-namespaces as it wishes.
 * Each namespace separator is converted to a DIRECTORY_SEPARATOR when loading from the file system.
 * Each _ character in the CLASS NAME is converted to a DIRECTORY_SEPARATOR. The _ character has no special meaning in the namespace.
 * The fully-qualified namespace and class is suffixed with .php when loading from the file system.
 * Alphabetic characters in vendor names, namespaces, and class names may be of any combination of lower case and upper case.
 */
function autoload($className)
{   
    $baseDir   = str_replace('\\', '/', dirname(__DIR__)) . '/Vendor/';
    $className = ltrim($className, '\\');
    $fileName  = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

    if(file_exists($baseDir . DIRECTORY_SEPARATOR . $fileName))
        require $baseDir . DIRECTORY_SEPARATOR . $fileName;
}

spl_autoload_register("autoload");