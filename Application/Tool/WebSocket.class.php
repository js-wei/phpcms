<?php
Class WebSocket {
    var $master;  // 连接 server 的 client
    var $sockets = array(); // 不同状态的 socket 管理
    var $handshake = false; // 判断是否握手
    function __construct($address, $port){
        // 建立一个 socket 套接字
        $this->master = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)   
            or die("socket_create() failed");
        socket_set_option($this->master, SOL_SOCKET, SO_REUSEADDR, 1)  
            or die("socket_option() failed");
        socket_bind($this->master, $address, $port)                    
            or die("socket_bind() failed");
        socket_listen($this->master, 2)                               
            or die("socket_listen() failed");
        $this->sockets[] = $this->master;
        // debug
        echo("Master socket  : ".$this->master."\n");
        while(true) {
            //自动选择来消息的 socket 如果是握手 自动选择主机
            $write = NULL;
            $except = NULL;
            socket_select($this->sockets, $write, $except, NULL);
            foreach ($this->sockets as $socket) {
                //连接主机的 client 
                if ($socket == $this->master){
                    $client = socket_accept($this->master);
                    if ($client < 0) {
                        // debug
                        echo "socket_accept() failed";
                        continue;
                    } else {
                        //connect($client);
                        array_push($this->sockets, $client);
                        echo "connect client\n";
                    }
                } else {
                    $bytes = @socket_recv($socket,$buffer,2048,0);
                    if($bytes == 0) return;
                    if (!$this->handshake) {
                        // 如果没有握手，先握手回应
                        $this->doHandShake($socket, $buffer);
                        //echo "shakeHands\n";
                    } else {
                        // 如果已经握手，直接接受数据，并处理
                        $buffer = $this->decode($buffer);
                        $this->send($socket, $buffer); 
                        //echo "send file\n";
                    }
                }
            }
        }
    }

	// 返回数据
	public function send($client, $msg){
		$msg = $this->frame($msg);
		socket_write($client, $msg, strlen($msg));
	}
	// 解析数据帧
	private function decode($buffer)  {
		$len = $masks = $data = $decoded = null;
		$len = ord($buffer[1]) & 127;
		if ($len === 126)  {
			$masks = substr($buffer, 4, 4);
			$data = substr($buffer, 8);
		} else if ($len === 127)  {
			$masks = substr($buffer, 10, 4);
			$data = substr($buffer, 14);
		} else  {
			$masks = substr($buffer, 2, 4);
			$data = substr($buffer, 6);
		}
		for ($index = 0; $index < strlen($data); $index++) {
			$decoded .= $data[$index] ^ $masks[$index % 4];
		}
		return $decoded;
	}
	// 返回帧信息处理
	private function frame($s) {
		$a = str_split($s, 125);
		if (count($a) == 1) {
			return "\x81" . chr(strlen($a[0])) . $a[0];
		}
		$ns = "";
		foreach ($a as $o) {
			$ns .= "\x81" . chr(strlen($o)) . $o;
		}
		return $ns;
	}
	//如果已经握手，直接接受数据，并处理
	private function dohandshake($socket, $req){
		// 获取加密key
		$acceptKey = $this->encry($req);
		$upgrade = "HTTP/1.1 101 Switching Protocols\r\n" .
				   "Upgrade: websocket\r\n" .
				   "Connection: Upgrade\r\n" .
				   "Sec-WebSocket-Accept: " . $acceptKey . "\r\n" .
				   "\r\n";
		// 写入socket
		socket_write(socket,$upgrade.chr(0), strlen($upgrade.chr(0)));
		// 标记握手已经成功，下次接受数据采用数据帧格式
		$this->handshake = true;
	}
	//提取 Sec-WebSocket-Key 信息
	private function getKey($req) {
		$key = null;
		if (preg_match("/Sec-WebSocket-Key: (.*)\r\n/", $req, $match)) { 
			$key = $match[1]; 
		}
		return $key;
	}
	//解密加密key
	private function encry($req){
		$key = $this->getKey($req);
		$mask = "258EAFA5-E914-47DA-95CA-C5AB0DC85B11";
		return base64_encode(sha1($key . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11', true));
	}
}
