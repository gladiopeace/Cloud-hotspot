<?php

session_start();


function sendAuthorization($id, $minutes)
{
    $unifiServer = "https://unifi-IP:8443";
    $unifiUser = "UniFi Username";
    $unifiPass = "UniFi Password";

    // Start Curl for login
    $ch = curl_init();
    // We are posting data
    curl_setopt($ch, CURLOPT_POST, TRUE);
    // Set up cookies
    $cookie_file = "/tmp/unifi_cookie";
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
    // Allow Self Signed Certs
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    // Force SSL3 only
    curl_setopt($ch, CURLOPT_SSLVERSION, 3);
    // Login to the UniFi controller
    curl_setopt($ch, CURLOPT_URL, "$unifiServer/login");
    curl_setopt($ch, CURLOPT_POSTFIELDS,
        "login=login&username=$unifiUser&password=$unifiPass");
    // send login command
    curl_exec ($ch);

    // Send user to authorize and the time allowed
    $data = json_encode(array(
        'cmd'=>'authorize-guest',
        'mac'=>$id,
        'minutes'=>$minutes));

    // Send the command to the API
    curl_setopt($ch, CURLOPT_URL, $unifiServer.'/api/cmd/stamgr');
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'json='.$data);
    curl_exec ($ch);

    // Logout of the UniFi Controller
    curl_setopt($ch, CURLOPT_URL, $unifiServer.'/logout');
    curl_exec ($ch);
    curl_close ($ch);
    unset($ch);
}

if ($_SESSION['loggingin'] == "unique key") // Check to see if the form has been posted to
{
	ob_start();
        sendAuthorization($_SESSION['id'], (12*60)); //authorizing user for 12 hours
	ob_end_clean();
	unset($_SESSION['loggingin']);
}

?>
<p>Connecting to the network...</p>
<script>
//allow time for the authorization to go through
setTimeout("location.href='http://www.Google.com'",6000);
</script>
