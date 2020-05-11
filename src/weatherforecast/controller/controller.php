<?php
namespace weatherforecast\controller;

use weatherforecast\command\command;
use weatherforecast\thread\sendThread;
use weatherforecast\database\databaseManager;

class controller{
    
    private $command;
    private $thread;

    public function __construct() {
        $this->checkFile();
        $db = new databaseManager("data/userData/user.db",0);
        $this->command = new command($db);
        $this->thread = new sendThread();
        $this->thread->start();
        echo "\e[96m"."----------------------------------------------\n";
        echo "__        __         _   _               \n\ \      / /__  __ _| |_| |__   ___ _ __ \n \ \ /\ / / _ \/ _` | __| '_ \ / _ \ '__|\n  \ V  V /  __/ (_| | |_| | | |  __/ |   \n   \_/\_/ \___|\__,_|\__|_| |_|\___|_|   \n\n      _____                            _   \n     |  ___|__  _ __ ___  ___ __ _ ___| |_ \n     | |_ / _ \| '__/ _ \/ __/ _` / __| __|\n     |  _| (_) | | |  __/ (_| (_| \__ \ |_ \n     |_|  \___/|_|  \___|\___\__,_|___/\__|\n                                           \n";
        echo "----------------------------------------------\n";
    }
    
    /**
     * @param String $data
     */
    public function command($data){
        $data = explode(" ",$data);
        if(isset($this->command->commandlist[$data[0]])){
            if($this->command->commandlist[$data[0]]["class"]->neceArg === count($data)){
                $this->command->commandlist[$data[0]]["class"]->execute($data);
            }else{
                echo "引数が少ないか多すぎます"."\n";
                echo $this->command->commandlist[$data[0]]["class"]->usage."\n";
            }
        }else{
            echo "コマンドが存在しません"."\n";
        }
    }
    
    public function shutdown(){
        $this->thread->shutdown = true;
        $this->join();
    }

    public function join(){
        $this->thread->join();
    }
    
    public function checkFile(){
        if(!file_exists("data")){
            mkdir("data");
        }
        if(!file_exists("data/userData")){
            mkdir("data/userData");
        }
        if(!file_exists("data/weather")){
            mkdir("data/weather");
        }
        if(!file_exists("data/city")){
            mkdir("data/city");
        }
        file_put_contents("data/city/cityid.txt","北海道地方\n011000：稚内\n012010：旭川\n012020：留萌\n016010：札幌\n016020：岩見沢\n016030：倶知安\n013010：網走\n013020：北見\n013030：紋別\n014010：根室\n014020：釧路\n014030：帯広\n015010：室蘭\n015020：浦河\n017010：函館\n017020：江差\n青森県\n020010：青森\n020020：むつ\n020030：八戸\n岩手県\n030010：盛岡\n030020：宮古\n030030：大船渡\n宮城県\n040010：仙台\n040020：白石\n秋田県\n050010：秋田\n050020：横手\n山形県\n060010：山形\n060020：米沢\n060030：酒田\n060040：新庄\n福島県\n070010：福島\n070020：小名浜\n070030：若松\n東京都\n130010：東京\n130020：大島\n130030：八丈島\n130040：父島\n神奈川県\n140010：横浜\n140020：小田原\n埼玉県\n110010：さいたま\n110020：熊谷\n110030：秩父\n千葉県\n120010：千葉\n120020：銚子\n120030：館山\n茨城県\n080010：水戸\n080020：土浦\n栃木県\n090010：宇都宮\n090020：大田原\n群馬県\n100010：前橋\n100020：みなかみ\n山梨県\n190010：甲府\n190020：河口湖\n新潟県\n150010：新潟\n150020：長岡\n150030：高田\n150040：相川\n長野県\n200010：長野\n200020：松本\n200030：飯田\n富山県\n160010：富山\n160020：伏木\n石川県\n170010：金沢\n170020：輪島\n福井県\n180010：福井\n180020：敦賀\n愛知県\n230010：名古屋\n230020：豊橋\n岐阜県\n210010：岐阜\n210020：高山\n静岡県\n220010：静岡\n220020：網代\n220030：三島\n220040：浜松\n三重県\n240010：津\n240020：尾鷲\n大阪府\n270000：大阪\n兵庫県\n280010：神戸\n280020：豊岡\n京都府\n260010：京都\n260020：舞鶴\n滋賀県\n250010：大津\n250020：彦根\n奈良県\n290010：奈良\n290020：風屋\n和歌山県\n300010：和歌山\n300020：潮岬\n鳥取県\n310010：鳥取\n310020：米子\n島根県\n320010：松江\n320020：浜田\n320030：西郷\n岡山県\n330010：岡山\n330020：津山\n広島県\n340010：広島\n340020：庄原\n山口県\n350010：下関\n350020：山口\n350030：柳井\n350040：萩\n徳島県\n360010：徳島\n360020：日和佐\n香川県\n370000：高松\n愛媛県\n380010：松山\n380020：新居浜\n380030：宇和島\n高知県\n390010：高知\n390020：室戸岬\n390030：清水\n福岡県\n400010：福岡\n400020：八幡\n400030：飯塚\n400040：久留米\n大分県\n440010：大分\n440020：中津\n440030：日田\n440040：佐伯\n長崎県\n420010：長崎\n420020：佐世保\n420030：厳原\n420040：福江\n佐賀県\n410010：佐賀\n410020：伊万里\n熊本県\n430010：熊本\n430020：阿蘇乙姫\n430030：牛深\n430040：人吉\n宮崎県\n450010：宮崎\n450020：延岡\n450030：都城\n450040：高千穂\n鹿児島県\n460010：鹿児島\n460020：鹿屋\n460030：種子島\n460040：名瀬\n沖縄県\n471010：那覇\n471020：名護\n471030：久米島\n472000：南大東\n473000：宮古島\n474010：石垣島\n474020：与那国島");
        $line = "";
        foreach(file("data/city/cityid.txt",FILE_IGNORE_NEW_LINES) as $value){
            if(mb_substr($value,-1) == "県" or mb_substr($value,-2) == "地方"){
                touch("data/city/".$value);
                if(isset($pre)){
                    file_put_contents("data/city/".$pre,$line);
                    $line = "";
                }
                $pre = $value;
            }else{
                $line .= $value."\n";
            }
        }
        file_put_contents("data/city/".$pre,$line);
        copy("data/city/北海道地方","data/city/北海道");
    }   
}