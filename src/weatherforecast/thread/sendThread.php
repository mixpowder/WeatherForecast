<?php

namespace weatherforecast\thread;

require 'src/weatherforecast/api/lineAPI.php';
require 'src/weatherforecast/api/discordAPI.php';
require 'src/weatherforecast/api/livedoorAPI.php';
//require 'src/weatherforecast/database/databaseManager.php';
use weatherforecast\api\lineAPI;
use weatherforecast\api\discordAPI;
use weatherforecast\api\livedoorAPI;
use weatherforecast\database\databaseManager;

class sendThread extends \Thread{
    
    public $shutdown = false;
    
    public function __construct() {
        foreach(file("data/userData/setting.txt",FILE_SKIP_EMPTY_LINES) as $value){
            $this->linebot = explode(": ",$value)[1];
        }
    }

    public function run () {
        $udbManager = new databaseManager("data/userData/user.db",0);
        $wdbManager = new databaseManager("data/weather/date.db",1);
        $lineapi = new lineAPI('https://api.line.me/v2/bot/message/push', $this->linebot);
        $discordapi = new discordAPI();
        $discordapi->botName("天気予報Bot");
        $livedoorapi = new livedoorAPI();
        date_default_timezone_set('Asia/Tokyo');
        while(!$this->shutdown){
            $this->setTemperature($udbManager,$livedoorapi,$wdbManager);
            $this->checkDate($udbManager,$livedoorapi,$lineapi,$discordapi,$wdbManager);
            for($d = 1;$d <= 59; $d++){
                if($this->shutdown){
                    break;
                }else{
                    sleep(1);
                }
            }
        }
    }
    
    /**
     * @param databaseManager $udbManager
     * @param livedoorAPI $livedoorapi
     * @param databaseManager $wdbManager
     */
    private function setTemperature($udbManager,$livedoorapi,$wdbManager){
        if(date("i") / 60 === 0){
            foreach($udbManager->getUser() as $user){
                if(count($user) === 4){
                    $livedoorapi->setURL($user["cityid"]);
                    $weather = $livedoorapi->send();
                    if(!($weather === NULL)){
                        foreach($weather as $tem){
                            $wdbManager->setTemperature($tem["date"],$tem["telop"],$tem["temperature"]["max"]["celsius"],$tem["temperature"]["min"]["celsius"],$user["cityid"]);
                        }
                    }
                }
            }
        }else{
        }
    }
    
    /**
     * 
     * @param databaseManager $udbManager
     * @param livedoorAPI $livedoorapi
     * @param lineAPI $lineapi
     * @param discordAPI $discordapi
     * @param databaseManager $wdbManager
     */
    private function checkDate($udbManager,$livedoorapi,$lineapi,$discordapi,$wdbManager){
        if(date("G:i") == "6:00"){
            $id = 1;
            foreach($udbManager->getUser() as $user){
                if(count($user) === 4){
                    $weather = $wdbManager->getTemperature(date("Y-m-d"),$user["cityid"]);
                    $weather = "今日は".$weather["weather"]."\n最高気温は".$weather["max"]."\n最低気温は".$weather["min"];
                    if($user["lod"] === "line"){
                        $lineapi->UGID($user["uow"]);
                        $lineapi->sendText($weather);
                        $lineapi->send();
                    }elseif($user["lod"] === "discord"){
                        $discordapi->setWebhookURL($user["uow"]);
                        $discordapi->sendText($weather);
                        $discordapi->send();
                    }else{
                            echo "送信設定がおかしいです\nLINEかdiscordにしてください\nおかしいline: {$id}\n確認方法 openconfig {$id}\n";
                    }
                        $id++;
                }else{
                    echo "入力されているデータがおかしい箇所があります\n修正が必要なline: {$id}\n確認方法 openconfig {$id}\n";
                }
            }
            echo "時間になったため送信しました"."\n";
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