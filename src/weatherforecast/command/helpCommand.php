<?php

namespace weatherforecast\command;

class helpCommand{
    
    public $neceArg;
    public $usage;
    public $commandName;
    private $dbManager;

    public function __construct($db) {
        $this->neceArg = 1;
        $this->usage = "help";
        $this->commandName = "help";
        $this->dbManager = $db;
    }
    
    /**
     * @param array $data
     * @return bool
     */
    public function execute(array $data): bool{
        $list = (new command($this->dbManager))->commandlist;
        echo '------------------help---------------------'."\n";
        foreach($list as $key => $value){
            echo $value["class"]->usage."\n";
        }
        echo "stop\n";
        echo '-------------------------------------------'."\n";
        return true;
    }
}