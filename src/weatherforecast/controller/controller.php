<?php
namespace weatherforecast\controller;

use weatherforecast\command\command;
use weatherforecast\thread\sendThread;
use weatherforecast\database\databaseManager;

class controller{
    
    private $command;
    private $thread;

    public function __construct() {
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
}