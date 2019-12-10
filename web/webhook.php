<?php
require_once "../telegram/BD.php";
require_once "../telegram/TELEGRAM.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$bd = new \telegram\BD();

$telegram = new \telegram\TELEGRAM();
$telegram->setBD($bd);

$request = file_get_contents("php://input");
$telegram->procesar($request);
