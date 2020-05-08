<?php

namespace weatherforecast\command;

class command{
    
    public $commandlist;
    
    public function __construct($db) {
        $file = array_diff(scandir("./src/weatherforecast/command/"), array('..', '.','command.php'));
        foreach($file as $filename){
            $filename = basename($filename,".php");
            $filename = "\\weatherforecast\\command\\".$filename;
            $class = new $filename($db);
            $this->commandlist[$class->commandName]["class"] = $class;
        }
    }
}