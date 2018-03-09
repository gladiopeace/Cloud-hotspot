<?php 

	if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	class Swoole extends CI_Controller {
	
		public $_config;
	
		public function __construct()
		{
			parent::__construct();
			
		}

		public function Test(){

			$server = new swoole_websocket_server("127.0.0.1", 9502);

			$server->on('open', function($server, $req) {
			    echo "connection open: {$req->fd}\n";
			});

			$server->on('message', function($server, $frame) {
			    echo "received message: {$frame->data}\n";
			    $server->push($frame->fd, json_encode(["hello", "world"]));
			});

			$server->on('close', function($server, $fd) {
			    echo "connection close: {$fd}\n";
			});

			$server->start();
			
		}

	
	}
	
	/* End of file Swoole.php */
	/* Location: ./application/models/Swoole.php */


?>