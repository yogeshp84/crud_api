<?php
require_once __DIR__ . '/../config/Db.php';
require_once __DIR__ . '/../database/Db.php';
//create db connection
$dbObj = new Db();
$dbObj->connect($config['DB_HOST'],$config['DB_USERNAME'],$config['DB_PASSWORD'],$config['DB_DATABASE']);