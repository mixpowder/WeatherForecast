<?php

namespace weatherforecast\command;

class signupCommand{
    
    public $neceArg;
    public $usage;
    public $commandName;
    private $dbManager;

    public function __construct($db) {
        $this->neceArg = 4;
        $this->commandName = "signup";
        $this->usage = "signup <line or discord> <userID or webhookURL> <cityID>";
        $this->dbManager = $db;
    }
    
    /**
     * @param array $data
     * @return bool
     */
    public function execute(array $data): bool{
        $select = $data[1];
        $userID = $data[2];
        $cityID = $data[3];
        if($select === "line" or $select === "discord"){
        $this->dbManager->createUser($select,$userID,$cityID);
            echo "追加することに成功しました\n";
        }else{
            echo "追加することに失敗しました\nline or discord\n";
        }
        return true;
    }
}