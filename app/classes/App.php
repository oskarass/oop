<?php

namespace App;

class App

{
    public static $db;
    public static $session;

    public function __construct()
    {
        session_start();
        // Inside class, static vriables
        // are accessed with self::$static_variable_name
        self::$db = new \Core\FileDB(DB_FILE);
        self::$session = new \Core\Session();
    }

//    public function __destruct()
//    {
//        self::$db->save();
//    }
}