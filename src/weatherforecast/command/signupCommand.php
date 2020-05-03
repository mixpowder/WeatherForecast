<?php

namespace weatherforecast\command;

class signupCommand{
    
    public $neceArg;
    public $usage;
    public $commandName;


    public function __construct() {
        $this->neceArg = 4;
        $this->commandName = "signup";
        $this->usage = "signup <line or discord> <userID or webhookURL> <cityID>";
    }
    
    /**
     * @param array $data
     * @return bool
     */
    public function execute(array $data): bool{
        $select = $data[1];
        $userID = $data[2];
        $cityID = $data[3];
        $txt = "user.txt";
        $line = "";
        if (!(filesize($txt) === 0)) {
            foreach (file($txt, FILE_IGNORE_NEW_LINES) as $value) {
                $line .= $value . "\n";
            }
        }
        $line .= $select.": ".$userID.": ".$cityID."\n";
        file_put_contents($txt,$line);
        return true;
    }
}