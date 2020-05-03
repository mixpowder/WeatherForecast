<?php

namespace weatherforecast\thread;

require 'src/weatherforecast/api/lineAPI.php';
require 'src/weatherforecast/api/discordAPI.php';
use weatherforecast\api\lineAPI;
use weatherforecast\api\discordAPI;

class sendThread extends \Thread{
    
    public $shutdown = false;

    public function run () {
        $lineapi = new lineAPI('https://api.line.me/v2/bot/message/push','LNvNL/LM8Kee+XK6YmuNgJl2kFQ5s4SKhQW2DpQO9nR1ZchaCSFIUxXyq1Qxsuxee7k4Ck07QqOIQVFV3b3yOGLIFdVM2i/mvnAgqNJVO9HYmi2eCecV857UkjA74Wp/oglXjod1SBTEBMLLMvn9+gdB04t89/1O/w1cDnyilFU=');
        $discordapi = new discordAPI();
        date_default_timezone_set('Asia/Tokyo');
        while(true){
            if($this->shutdown){
                break;
            }
            if(date("G:i") == "23:24"){
                $data = [];
                foreach (file("user.txt", FILE_IGNORE_NEW_LINES) as $value) {
                    $data[] = explode(": ",$value);
                }
                $id = 0;
                foreach($data as $user){
                    if($user[0] == "line"){
                        $lineapi->UGID($user[1]);
                        $lineapi->sendText("a");
                        $lineapi->send();
                    }elseif($user[0] == "discord"){
                        $discordapi->setWebhookURL($user[1]);
                        $discordapi->sendText("a");
                        $discordapi->send();
                    }else{
                        echo "送信設定がおかしいです\nLINEかdiscordにしてください\nおかしいline: {$id}"."\n";
                    }
                    $id++;
                }
                echo "時間になったため送信しました"."\n";
            }
            sleep(59);
        }
    }

    public function isGarbage(): bool {
        
    }

    public function offsetExists($offset): bool {
        
    }

    public function offsetGet($offset) {
        
    }

    public function offsetSet($offset, $value): void {
        
    }

    public function offsetUnset($offset): void {
        
    }

    public function setGarbage(): void {
        
    }
}