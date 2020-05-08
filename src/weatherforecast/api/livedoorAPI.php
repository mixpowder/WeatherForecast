<?php

namespace weatherforecast\api;

class livedoorAPI {
    
    private $URL;
    
    
    public function send(){
        $data = json_decode(file_get_contents($this->URL), TRUE);
        $data = $data["forecasts"];
        //$data = "今日は".$data[0]["telop"]."\n最高気温は".$data[0]["temperature"]["max"]["celsius"]."\n最低気温は".$data[0]["temperature"]["min"]["celsius"];
        return $data;
    }
    
    public function setURL($cityid){
        $this->URL = "http://weather.livedoor.com/forecast/webservice/json/v1?city=".$cityid;
    }
}