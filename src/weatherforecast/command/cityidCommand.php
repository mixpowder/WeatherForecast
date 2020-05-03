<?php

namespace weatherforecast\command;

class cityidCommand{
    
    public $neceArg;
    public $usage;
    public $commandName;


    public function __construct() {
        $this->neceArg = 2;
        $this->commandName = "cityid";
        $this->usage = "cityid <Prefecture name or all>";
    }
    
    /**
     * @param array $data
     * @return bool
     */
    public function execute(array $data): bool{
        if(file_exists("data/".$data[1])){
            echo file_get_contents("data/".$data[1])."\n";
        }elseif($data[1] == "all"){
            echo file_get_contents("data/cityid.txt")."\n";
        }else{
            echo "県または地方のcityidのファイルが存在しませんでした。\n cityid allで検索かけてください\n";
        }
        return true;
    }
}