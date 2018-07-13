<?php

require_once('unifi/controller.php');
require_once('config/unifi.php');

$sid = isset($_GET['sid']) ? $_GET['sid'] : '';

if(!$sid){
    die('error');
}

session_id($sid);
session_start();

$macid = isset($_SESSION['macid']) ? $_SESSION['macid'] : '';

if(!$macid){
    die('error');
}

$controller = new Controller();
$controller->sendAuthorization($macid, $unifiMinutes);
echo 'success';