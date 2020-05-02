<?php

namespace weatherforecast\api;

class lineAPI{

    public function __construct($url,$token){
	$this->url = $url;
	$this->headers = array('Content-Type: application/json',
                 	 'Authorization: Bearer '.$token);
    }

	public function UGID($ugid){
		$this->id = $ugid;
	}

	public function Message($message){
		$message = ['type' => 'text','text' => $message];
		$this->body = json_encode(['to' => $this->id,
                          		  'messages'   => [$message]]);  // 複数送る場合は、array($mesg1,$mesg2) とする。

	}

	public function send(){
		$options = array(CURLOPT_URL    => $this->url,
                 CURLOPT_CUSTOMREQUEST  => 'POST',
                 CURLOPT_RETURNTRANSFER => true,
                 CURLOPT_HTTPHEADER     => $this->headers,
                 CURLOPT_POSTFIELDS     => $this->body,
             	 CURLOPT_SSL_VERIFYPEER => false);
		$curl = curl_init();
		curl_setopt_array($curl, $options);
		curl_exec($curl);
		curl_close($curl);
	}

}