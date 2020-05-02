<?php

namespace weatherforecast\command;

class helpCommand{
    
    /**
     * @return int
     */
    public function neceArg(): int{
        return 1;
    }
    
    /**
     * @return string
     */
    public function commandName(): string{
        return "help";
    }
    
    /**
     * @param array $data
     * @return bool
     */
    public function execute(array $data): bool{
        $list = (new command())->commandlist;
        echo '------------------help---------------------'."\n";
        foreach($list as $key => $value){
            echo $key."\n";
        }
        echo '-------------------------------------------'."\n";
        return true;
    }
}