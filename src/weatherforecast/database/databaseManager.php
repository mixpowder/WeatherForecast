<?php

namespace weatherforecast\database;

use \SQLite3;

class databaseManager {
    
    private $db;

    public function __construct($file,$value = 0) {
        $this->value = $value;
        $option = (file_exists($file))? SQLITE3_OPEN_READWRITE : SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE;
        $db = new SQLite3($file, $option);
        $this->setdb($db);
    }
    
    /**
     * @param \SQLite3 $db
     */
    public function setdb(SQLite3 $db){
        $this->db = $db;
        if($this->value === 0){
            $this->db->exec("CREATE TABLE IF NOT EXISTS data (id INTEGER NOT NULL PRIMARY KEY,lod TEXT NOT NULL,uow TEXT NOT NULL,cityid TEXT NOT NULL)");
        }else{
            $this->db->exec("CREATE TABLE IF NOT EXISTS temperature (date TEXT NOT NULL,weather TEXT NOT NULL,max INTEGER NOT NULL,min INTEGER NOT NULL,cityid TEXT NOT NULL)");
        }
        
    }
    
    /**
     * @param string $lod
     * @param string $uow
     * @param string $cityid
     * @return void
     */
    public function createUser(string $lod,string $uow,string $cityid) : void{
        $dbcmd = "SELECT max(id) FROM data";
        $data = $this->db->prepare($dbcmd)->execute()->fetchArray(SQLITE3_ASSOC);
        if($data["max(id)"] === NULL){
            $id = 0;
        }else{
            $id = $data["max(id)"] + 1;
        }
        $dbcmd = "INSERT INTO data (id,lod, uow, cityid) VALUES ({$id},'{$lod}','{$uow}','{$cityid}')";
        $this->db->exec($dbcmd);
    }
    
    /**
     * @return array
     */
    public function getUser(): array{
        $dbcmd = "SELECT max(id) FROM data";
        $data = $this->db->prepare($dbcmd)->execute()->fetchArray(SQLITE3_ASSOC);
        $return = [];
        if($data["max(id)"] === NULL){
            return $return;
        }
        for($id = 0; $id <= $data["max(id)"]; $id++){
        $dbcmd = "SELECT * FROM data WHERE id = ".$id;
        $return[] = $this->db->prepare($dbcmd)->execute()->fetchArray(SQLITE3_ASSOC);
        }
        return $return;
    }
    
    public function deleteUser(int $int){
        $dbcmd = "SELECT max(id) FROM data";
        $data = $this->db->prepare($dbcmd)->execute()->fetchArray(SQLITE3_ASSOC);
        $dbcmd = "DELETE FROM data WHERE id = {$int}";
        $this->db->exec($dbcmd);
        if($data["max(id)"] === NULL){
            return;
        }
        if($data["max(id)"] === $int){
            return;
        }
        $dbcmd = "SELECT * FROM data WHERE id = ".$data["max(id)"];
        $return = $this->db->prepare($dbcmd)->execute()->fetchArray(SQLITE3_ASSOC);
        $dbcmd = "UPDATE data SET id = {$int},lod = '{$return["lod"]}',uow = '{$return["uow"]}',cityid = '{$return["cityid"]}' WHERE id =".$data["max(id)"];
        $this->db->exec($dbcmd);
    }
    
    public function getTemperature($date,$cityid){
        $dbcmd = "SELECT * FROM temperature WHERE date = '{$date}' AND cityid = '{$cityid}'";
        return $this->db->prepare($dbcmd)->execute()->fetchArray(SQLITE3_ASSOC);
    }
    
    public function setTemperature(string $date,string $weather,$max,$min,string $cityid){
        $datedata = $this->getTemperature($date,$cityid);
        if(isset($datedata["min"],$datedata["max"])){
            $bool = true;
            if($max === NULL){
                $max = $datedata["max"];
            }
            if($min === NULL){
                $min = $datedata["min"];
            }
        }else{
            $bool = false;
            if($max === NULL){
                $max = 0;
            }
            if($min === NULL){
                $min = 0;
            }
        }
        if($bool){
            $dbcmd = "UPDATE temperature SET weather = '{$weather}',max = {$max},min = {$min},cityid = '{$cityid}' WHERE date = '{$date}' AND cityid = '{$cityid}'";
            $this->db->exec($dbcmd);
        }else{
            $dbcmd = "INSERT INTO temperature (date,weather,max,min,cityid) VALUES ('{$date}','{$weather}',{$max},{$min},'{$cityid}')";
            $this->db->exec($dbcmd);
        }
        
    }
}