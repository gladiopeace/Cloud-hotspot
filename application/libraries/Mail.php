<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
 
	class Mail {
	 
	    private $mail; //mail object
	    private $sms; //sms array();
	 
	    public function Mail_init($name,$config){

	        require_once('PHPMailer/class.phpmailer.php');
	 
	        // the true param means it will throw exceptions on errors, which we need to catch
	        $this->mail = new PHPMailer(true);
	                                         // 使用html格式
	        $this->mail->IsSMTP(); // telling the class to use SMTP
	 
	        $this->mail->CharSet = "utf-8";                  // 一定要設定 CharSet 才能正確處理中文
	        $this->mail->SMTPDebug  = 0;                     // enables SMTP debug information
	        $this->mail->SMTPAuth   = true;                  // enable SMTP authentication
	        if($config['ssl']==1){
	        	$this->mail->SMTPSecure = "ssl";   // sets the prefix to the servier
	        }
	                     
	        $this->mail->Host       = $config['smtp_server'];      // sets GMAIL as the SMTP server
	     
	        $this->mail->Port       = $config['smtp_port'];      // set the SMTP port for the GMAIL server
	        $this->mail->Username   = $config['username'];
	        $this->mail->Password   = $config['password'];
	        $this->mail->From =  $config['username'];
	       $this->mail->FromName =$name;
	  

	    }
	 
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

	    public function getbody($type,$_data){
	    	$data = null;
	    	if($type=='active'){

	    		$data = '尊敬的'.$_data['email'].'，您好！
	    						<br>
	                        	<br>
								<br>
								点击链接即可激活您的账号,
								<br>
								<br>
								<a href="'.$_data['url'].'">'.$_data['url'].'</a>
								<br>
								<br>
								为保障您的帐号安全，请在24小时内点击该链接，您也可以将链接复制到浏览器地址栏访问。如果您并未尝试激活邮箱，请忽略本邮件，由此给您带来的不便请谅解。
								<br>								        							
								<br>
								<br>
								本邮件由系统自动发出，请勿直接回复！';

	    	}

	    	if($type=="forget"){


	    		$data='尊敬的用户，您好！
	    				<br>
						<br>
						<br>
						您在访问Cloud-hotspot时点击了“忘记密码”链接，这是一封密码重置确认邮件。<br>
						<br>
						您可以通过点击以下链接重置帐户密码:
						<br>
						<br>
						<a href="'.$_data['url'].'">'.$_data['url'].'</a>
						<br>
						<br>
						为保障您的帐号安全，请在24小时内点击该链接，您也可以将链接复制到浏览器地址栏访问。 若如果您并未尝试修改密码，请忽略本邮件，由此给您带来的不便请谅解。
						<br>
						<br>
						<br>
						本邮件由系统自动发出，请勿直接回复';
	    	}

	    	if($type=="change"){

	    		$data='<body>亲爱的 '.$_data['truename'].'，您好！
	    				<br>
	                    <br>
						<br>
						您申请更换Cloud-hotspot帐号的邮箱账户，请点击 <a target="_blank" href="'.$_data['url'].'">这里</a> 确认,
						<br>
	                    <br>
						如果上面的链接无法点击，您可以复制下面的地址，并粘帖到浏览器的地址栏中访问。
						<br>
	                    <br>
						<a href="'.$_data['url'].'">'.$_data['url'].'</a>
						<br>
	                    <br>
						<br>
						祝您使用愉快！';
	    	}

	    	if($type=="verify"){

	    		$data='<body>尊敬的用户: '.'
	    				<br>	                 
	    				<br>	                 
						您好,感谢使用Cloud-hotspot服务！
						<br>
						验证码:<strong style="color:red;">'.$_data['code'].'</strong>
						<br>	                   
	                    请复制上面的验证码，并返回页面继续之前的步骤。
	                    <br>
						<br>
	                 
						如果您没有申请发送该邮件，请忽略。
						<br>
	                 
						祝您使用愉快！';
	    	}
	    	
	    	return $data;

	    } 



	}