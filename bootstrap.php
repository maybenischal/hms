<?php

require_once "vendor/autoload.php";
require_once __DIR__ . "/helpers.php";

use App\Database\Connection;

$config = [
    'dbname' => 'hms_db',
    'user' => 'root', 
    'password' => 'password',
    'host' => '127.0.0.1'
];

$db = new Connection($config);