$unifi=new unifiapi("username","password","https://0.0.0.0:8443","default","4.6.0");
$unifi->login();
$unifi->authorize_guest("mac adress",60)
Abow is demo for ubiquiti TEST