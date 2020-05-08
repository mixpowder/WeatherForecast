<?php

namespace weatherforecast\command;

class openlineCommand{
    
    public $neceArg;
    public $usage;
    public $commandName;
    private $dbManager;

    public function __construct($db) {
        $this->neceArg = 2;
        $this->commandName = "openline";
        $this->usage = "openline <line or all>";
        $this->dbManager = $db;
    }
    
    /**
     * @param array $data
     * @return bool
     */
    public function execute(array $data): bool{
        $send = "";
        $userdata = $this->dbManager->getUser();
        if($data[1] === "all"){
            $id = 1;
            foreach($userdata as $value){
                $send .= "line: {$id} 送信先: ".$value["lod"]." userID or webhookURL: ".$value["uow"]." cityID: ".$value["cityid"]."\n";
                $id++;
            }
        }else{
            $id = --$data[1];
            if(isset($userdata[$id])){
                $send .= "送信先: ".$userdata[$id]["lod"]." userID or webhookURL: ".$userdata[$id]["uow"]." cityID: ".$userdata[$id]["cityid"]."\n";
            }else{
                $send .= "そのlineは存在しません"."\n";
            }
        }
        echo $send;
        return true;
    }
}