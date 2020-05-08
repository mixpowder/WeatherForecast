<?php

namespace weatherforecast\command;

class deletelineCommand{
    
    public $neceArg;
    public $usage;
    public $commandName;
    private $dbManager;

    public function __construct($db) {
        $this->neceArg = 2;
        $this->commandName = "deleteline";
        $this->usage = "deleteline <line>";
        $this->dbManager = $db;
    }
    
    /**
     * @param array $data
     * @return bool
     */
    public function execute(array $data): bool{
        $id = --$data[1];
        $send = "";
        if(isset($this->dbManager->getUser()[$id])){
            $this->dbManager->deleteUser($id);
            $send .= "消すことに成功しました"."\n";
        }else{
            $id++;
            $send .= "line {$id}は存在しません"."\n";
        }
        echo $send;
        return true;
    }
}