<?php

//PHP SCRIPT FOR SIMPLE PORTAL
//REQUIREMENTS:
//curl needs to be enabled (php_curl.dll for widnows)

session_start();

$_SESSION['id'] = $_GET['id'];          //user's mac address
$_SESSION['ap'] = $_GET['ap'];          //AP mac
$_SESSION['ssid'] = $_GET['ssid'];      //ssid the user is on (POST 2.3.2)
$_SESSION['time'] = $_GET['t'];         //time the user attempted a request of the portal
$_SESSION['refURL'] = $_GET['url'];     //url the user attempted to reach
$_SESSION['loggingin'] = "unique key";  //key to use to check if the user used this form or not
					// -- prevents them from simply going to /authorized.php on their own

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Portal Page Example</title>
</head>

<body>
    <form name="login" action="authorized.php" method="post">
    <input id="submit" type="submit" name="submit" value="Connect" />
    </form>
</body>
</html>
