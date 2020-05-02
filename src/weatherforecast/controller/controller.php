<?php
namespace weatherforecast\controller;

//require 'src/weatherforecast/command/command.php';
use weatherforecast\command\command;

class controller{
    
    private $command;


    public function __construct() {
        $this->command = new command();
        touch("user.txt");
        
    }
    
    /**
     * @param String $data
     */
    public function command($data){
        $data = explode(" ",$data);
        if(isset($this->command->commandlist[$data[0]])){
            if($this->command->commandlist[$data[0]]["args"] === count($data)){
                $this->command->commandlist[$data[0]]["class"]->execute($data);
            }else{
                echo "引数が少ないか多すぎます";
            }
        }else{
            echo "ないで";
        }
    }
    
}