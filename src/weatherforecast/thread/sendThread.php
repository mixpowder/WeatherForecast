<?php

namespace weatherforecast\thread;

require 'src/weatherforecast/api/lineAPI.php';
require 'src/weatherforecast/api/discordAPI.php';
require 'src/weatherforecast/api/livedoorAPI.php';
use weatherforecast\api\lineAPI;
use weatherforecast\api\discordAPI;
use weatherforecast\api\livedoorAPI;

class sendThread extends \Thread{
    
    public $shutdown = false;

    public function run () {
        $lineapi = new lineAPI('https://api.line.me/v2/bot/message/push','LNvNL/LM8Kee+XK6YmuNgJl2kFQ5s4SKhQW2DpQO9nR1ZchaCSFIUxXyq1Qxsuxee7k4Ck07QqOIQVFV3b3yOGLIFdVM2i/mvnAgqNJVO9HYmi2eCecV857UkjA74Wp/oglXjod1SBTEBMLLMvn9+gdB04t89/1O/w1cDnyilFU=');
        $discordapi = new discordAPI();
        $discordapi->botName("天気予報Bot");
        $discordapi->avator("http://mix.starfree.jp/icon.ico");
        $livedoorapi = new livedoorAPI();
        date_default_timezone_set('Asia/Tokyo');
        while(true){
            if($this->shutdown){
                break;
            }
            if(date("G:i") == "11:30"){
                $data = [];
                foreach (file("user.txt", FILE_IGNORE_NEW_LINES) as $value) {
                    $data[] = explode(": ",$value);
                }
                $id = 0;
                foreach($data as $user){
                    if(count($user) == 3){
                        $livedoorapi->setURL($user[2]);
                        $weather = $livedoorapi->send();
                        if($user[0] == "line"){
                            $lineapi->UGID($user[1]);
                            $lineapi->sendText($weather);
                            $lineapi->send();
                        }elseif($user[0] == "discord"){
                            $discordapi->setWebhookURL($user[1]);
                            $discordapi->sendText($weather);
                            $discordapi->send();
                        }else{
                            echo "送信設定がおかしいです\nLINEかdiscordにしてください\nおかしいline: {$id}\n";
                        }
                        $id++;
                    }else{
                        echo "入力されているデータがおかしい箇所があります\n修正が必要なline: {$id}\n";
                    }
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