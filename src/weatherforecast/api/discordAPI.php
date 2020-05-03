<?php

namespace weatherforecast\api;

class discordAPI {
    
    private $getURL;
    private $getData;


    public function __construct() {
        $this->getData = [];
    }
    
    public function send(){
        $options = [
            "http" => [
            'method' => 'POST',
                'header' => 'Content-Type: application/json',
                'content' => json_encode($this->getData),
                ]
        ];
        file_get_contents($this->getURL, false, stream_context_create($options));
    }
    
    
    public function botName(string $name){
        $this->getData["username"] = $name;
    }
    
    public function sendText(string $text){
        $this->getData["content"] = $text;
    }
    
    public function avator(string $avator_url){
        $this->getData["avatar_url"] = $avator_url;
    }
    
    public function setWebhookURL($webhookurl) {
        $this->getURL = $webhookurl;
        
    }
    
    
}