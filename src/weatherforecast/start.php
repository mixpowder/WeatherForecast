<?php

namespace weatherforecast;

echo "\e[92m起動中...\n";

spl_autoload_register(function ($class_name) {
    $file = "src/". $class_name . '.php';
    if(is_readable($file)) {
        require_once $file;
        return;
    }
    
});
$con = new controller\controller();

echo "\e[92m"."起動しました\e[0m\n";
while(true){
    $stdin = trim(fgets(STDIN));
    if ($stdin === "stop"){
        echo "終了\n";
        break;
    }elseif($stdin === ""){
        
    }else{
        $con->command($stdin);
    }
}

echo "スレッドの終了待機中...\n";
$con->shutdown();