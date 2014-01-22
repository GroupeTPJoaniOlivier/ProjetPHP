<?php

error_reporting(E_ALL);

session_start();

$app = require __DIR__ . '/../app/app.php';
$app->run();
