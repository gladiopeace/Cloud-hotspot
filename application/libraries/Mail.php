<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
 
	class Mail {
	 
	    private $mail; //mail object
	    private $sms; //sms array();
	 

	    public function send_mail($to, $to_name, $subject, $body){

	        try{
	            $this->mail->AddAddress($to, $to_name);
	            $this->mail->IsHTML(true); 
	            $this->mail->Subject = $subject;
	            $this->mail->Body    = $body;
	 
	            $this->mail->Send();
	            //echo "Message Sent OK</p>\n";
	 
	        } catch (phpmailerException $e) {
	           	//echo $e->errorMessage(); //Pretty error messages from PHPMailer
	        } catch (Exception $e) {
	          	//echo $e->getMessage(); //Boring error messages from anything else!
	        }
	    }

	    public function body($type,$data){

	    	
	    } 





	}