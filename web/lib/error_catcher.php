<?php
/**
 * Error catcher.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths
 */

/**
 * Saves a log entry to a file.
 *
 * Appends a new entry to log file.
 *
 * @param string $file File where error occurred
 * @param int $line Line where error occurred
 * @param string $message Error message
 */
function _log_to_file($file, $line, $message) {
    $config = parse_ini_file('config.ini', true);
    $path = $config['log']['file_path'];
    
    $record = "[" . date('c') . ", " . $file . ":" . $line ."]\n" . $message . "\n\n";
    file_put_contents($path, $record, FILE_APPEND | LOCK_EX);
}

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    _log_to_file($errfile, $errline, "Error " . $errno . ": " . $errstr);
    
    //header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error');
    echo "<h2>Internal server error</h2>";
    
    exit;
});

set_exception_handler(function ($exception) {
    _log_to_file(
        $exception->getFile(),
        $exception->getLine(),
        $exception->getMessage() . "\nStack trace:\n" . $exception->getTraceAsString()
    );
    
    //header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error');
    echo "<h2>Internal server error</h2>";
    
    exit;
});
