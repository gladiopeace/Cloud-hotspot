# Cloud-hotspot
  
  This is an open-source software
  
  Support SMS(Cellphone Message),Member Account,Wechat Wi-Fi For Mikrotik & Ubiquiti Hotspot Portal
  
  Tutorial for ubiquiti network:
  
  1.Install the Cloud-Hotspot https://www.cloudshotspot.com/blog/how-to-install-cloud-hotspot-software-guide.html
  
  2.create a site in cloud hotspot https://www.cloudshotspot.com/blog/create-a-site-for-ubiquitis-devices.html
  
  3.Configure Unifi Controller https://www.cloudshotspot.com/blog/configure-unifi-controller.html
    
  
  

# Requirements
  PHP 5.3 +  & MYSQL 5.x + & Nginx Or Apache

# Install

  How to install? 
	
	 1. Download the project code.
	 Using GIT clone		
	 git clone https://github.com/Youth-Network/Cloud-hotspot.git		
		
	 Download the project zip file.	 	 
	 https://github.com/Youth-Network/Cloud-hotspot/archive/master.zip
			
			
	 2. Upload code to your server.
	    We can use a ftp tool to upload code to your server.			
			
	 3. Install
	    Open your computer browser and type the blow into it:
		http://your-domain-name.com or http://your-server-ip-address
		for example:
		http://www.cloud-hotspot.org 
		http://110.110.110.110	    
	
# Rewrite Rules
	
 Nginx:
  
	  location / {
	    index index.php;
	    if (-f $request_filename/index.php){
		rewrite (.*) $1/index.php;
	    }
	    if (!-f $request_filename){
		rewrite (.*) /index.php;
	    }
	  }
	  
Apache :

	RewriteEngine on  
	RewriteCond $1 !^(index\.php|images|data|install|template|Public|robots\.txt) 
	RewriteRule ^(.*)$ /index.php/$1 [L]
	
	
Screen Short


	
