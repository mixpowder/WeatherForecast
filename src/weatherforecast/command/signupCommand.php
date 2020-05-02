<?php

namespace weatherforecast\command;

class signupCommand{
    
    /**
     * @return int
     */
    public function neceArg(): int{
        return 3;
    }
    
    /**
     * @return string
     */
    public function commandName(): string{
        return "signup";
    }
    
    /**
     * @param array $data
     * @return bool
     */
    public function execute(array $data): bool{
        $select = $data[1];
        $userID = $data[2];
        $txt = "user.txt";
        $line = "";
        if (!(filesize($txt) === 0)) {
            foreach (file($txt, FILE_IGNORE_NEW_LINES) as $value) {
                $line .= $value . "\n";
            }
        }
        $line .= $select.":".$userID."\n";
        file_put_contents($txt,$line);
        return true;
    }
}