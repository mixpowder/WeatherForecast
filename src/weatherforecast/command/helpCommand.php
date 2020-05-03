<?php

namespace weatherforecast\command;

class helpCommand{
    
    public $neceArg;
    public $usage;
    public $commandName;


    public function __construct() {
        $this->neceArg = 1;
        $this->usage = "help";
        $this->commandName = "help";
    }
    
    /**
     * @param array $data
     * @return bool
     */
    public function execute(array $data): bool{
        $list = (new command())->commandlist;
        echo '------------------help---------------------'."\n";
        foreach($list as $key => $value){
            echo $value["class"]->usage."\n";
        }
        echo '-------------------------------------------'."\n";
        return true;
    }
}