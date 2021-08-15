<?php

declare( strict_types = 1 );

ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

const ROOT_DIR = __DIR__ . "/../";

class DB
{
    const DB_TYPE = 'mysql';
    const DB_HOST = 'localhost:3307';
    const DB_NAME = 'test';
    const DB_USER = 'root';
    const DB_PASS = 'root';

    public static function getDbConnection() : PDO
    {
        static $connection = null;

        if (empty($connection)) {
            $options = [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING];
            $connection = new PDO(self::DB_TYPE . ':host=' . self::DB_HOST . ';dbname=' . self::DB_NAME, self::DB_USER, self::DB_PASS, $options);
        }

        return $connection;
    }
}

// helper
function dd()
{
    $trace = debug_backtrace();
    $args = func_get_args();

    $tracer = "{$trace[0]['file']} in line {$trace[0]['line']}<br>";
    $tracer .= "Called by <b>{$trace[1]['function']}</b>" . (isset($trace[1]['class']) ? " in class <b>{$trace[1]['class']}</b>" : "");

    echo "<pre>";

    echo "<div style='font-size: 1rem;'>$tracer</div>";
//    var_dump( $args );
    print_r( $args );

    echo "</pre>";
    exit();
}
