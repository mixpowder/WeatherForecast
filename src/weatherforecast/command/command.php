<?php
namespace weatherforecast\command;

class command{
    
    public function __construct() {
        $file = array_diff(scandir("./src/weatherforecast/command/"), array('..', '.','command.php'));
        foreach($file as $filename){
            $filename = basename($filename,".php");
            $filename = "\\weatherforecast\\command\\".$filename;
            $class = new $filename();
            $this->commandlist[$class->commandName()]["class"] = $class;
            $this->commandlist[$class->commandName()]["args"] = $class->neceArg();
            
        }
    }
    
}