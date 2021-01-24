<?php
/**
 * Autoloader.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths
 */
spl_autoload_register(function ($class_name) {
    $pieces = explode('\\', $class_name);

    // Stops if requested class is not in the \Mitopaths package
    if (array_shift($pieces) != 'Mitopaths') {
        return;
    }

    $path = __DIR__ . '/' . implode('/', $pieces) . '.php';
    if (is_readable($path)) {
        include_once $path;
    }
});
