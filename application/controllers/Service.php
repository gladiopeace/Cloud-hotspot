<?php
 if ( !defined('BASEPATH')) exit('No direct script access allowed');
 
 class Service extends CI_Controller {
 
 	public $config;
    public  $redis;
    public function __construct()
 	{
 		parent::__construct();
 		$redis = new Redis();
        $redis->connect('127.0.0.1',6379);
        $this->redis = $redis;
 	}
 	

 	public function start($address,$port){



 			$server = new swoole_websocket_server($address, $port);

			$server->on('open', function($server, $req) {
			    echo "connection open: {$req->fd}\n";
			});

			$server->on('message', function($server, $frame) {
                $redis = $this->redis;
			    echo "received message: {$frame->data}\n";
                $data = json_decode($frame->data);
                if($data->cmd==1){
                    $quene = $redis->lRange('list-key', 0, -1);
                    $message = [
                        'cmd'=>1,
                        'result'=>$quene,//['user_list'=>['ZhangShan','LiSi']]
                    ];
                }elseif($data->cmd==2){
                    $sise = $redis->lSize('list-key');
                    $queneId = $sise+1;
                    $user = [
                        'id'=>$queneId,
                        'uid'=>uniqid(),
                        'username'=> $data->username,
                        'detail'=>[]
                    ];

                    $redis->rPush('list-key', json_encode($user));
                    $message = [
                        'cmd'=>1,
                        'result'=>'',
                    ];

                }elseif($data->cmd==88){
                    $redis->rPop("list-key");
                }


                if(isset($message) && !empty($message))
			        $server->push($frame->fd, json_encode($message));
			});

			$server->on('close', function($server, $fd) {
			    echo "connection close: {$fd}\n";
			});
			$server->start();
 	}

 	public function stop(){
 		 $command = "ps -ef |grep 'php index.php service' |awk '{print $2}'|xargs kill -9";
		 $retval = array();
		 exec($command, $retval, $status);
		 if ($status == 0) {
		   return $retval;
		 }
 	}



     
 }
 
 /* End of file Service.php */
 /* Location: ./application/models/Service.php */