<?php
use App\Core\App;
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/private/App/init.php';
date_default_timezone_set("Asia/Jakarta");
ob_start();
session_start();
$dotenv = new Dotenv\Dotenv('./');
$dotenv->load();
$app = new App;
$app->route();
ob_end_flush();
