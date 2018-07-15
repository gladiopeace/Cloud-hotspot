<?php
/**
 * @Author: liuyujie
 * @Date:   2016-03-30 16:03:51
 * @Last Modified by:   liuyujie
 * @Last Modified time: 2016-04-12 14:20:21
 */

class Controller{
    private $cookiePath;
    
    function __construct(){
        require(dirname(__FILE__) . '/../config/unifi.php');

        $this->server = $unifiServer;
        $this->user = $unifiUser;
        $this->pass = $unifiPass;
        $this->site = $unifiSite;
        $this->minutes = $unifiMinutes;
    }

    public function sendAuthorization($mac, $expire_mins) {
        //Config
        $server   = $this->server;
        $user     = $this->user;
        $password = $this->pass;
        $site     = $this->site;
        $cookie_file_path = dirname(__FILE__) . '/unifi_cookie';

        // Login
        $data = json_encode(
            array(
                  'username' => $user,
                  'password' => $password,
            )
        );


        // Start Curl for login
        $ch = curl_init();
        // We are posting data
        curl_setopt($ch, CURLOPT_POST, TRUE);
        // Set up cookies
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path);
        // Allow Self Signed Certs
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSLVERSION, '1');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // Login to the UniFi controller
        curl_setopt($ch, CURLOPT_URL, $server . "/api/login");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        curl_close($ch);


        // Send user to authorize and the time allowed
        $data = json_encode(
                            array(
                                  'cmd' => 'authorize-guest',
                                  'mac' => $mac,
                                  'minutes' => $expire_mins,
                                  )
                            );
        $ch = curl_init();
        // We are posting data
        curl_setopt($ch, CURLOPT_POST, TRUE);
        // Set up cookies
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path);
        // Allow Self Signed Certs
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSLVERSION, '1');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // Make the API Call
        curl_setopt($ch, CURLOPT_URL, $server . '/api/s/' . $site . '/cmd/stamgr');
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'json=' . $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_exec($ch);
        curl_close($ch);

        //Logout
        $ch = curl_init();
        // We are posting data
        curl_setopt($ch, CURLOPT_POST, TRUE);
        // Set up cookies
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path);
        // Allow Self Signed Certs
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSLVERSION, '1');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // Make the API Call
        curl_setopt($ch, CURLOPT_URL, $server . '/api/logout');
        curl_exec($ch);
        curl_close($ch);        
    }
}