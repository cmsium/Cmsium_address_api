<?php
ob_start();
header('Access-Control-Allow-Origin: *');
require 'config/init_libs.php';
require REQUIRES;

$router = Router::getInstance();
$router->executeAction($_SERVER['REQUEST_URI']);
ob_flush();