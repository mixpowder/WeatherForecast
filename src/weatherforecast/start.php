<?php

namespace weatherforecast;

spl_autoload_register(function ($class_name) {
    $file = "src/". $class_name . '.php';
    if(is_readable($file)) {
        require_once $file;
        return;
    }
    
});
$con = new controller\controller();


while(true){
    $stdin = trim(fgets(STDIN));
    if ($stdin === "stop"){
        echo "終了".PHP_EOL;
        break;
    }else{
        $con->command($stdin);
    }
}

echo "スレッドの終了を待機致しましております...".PHP_EOL;
$con->shutdown();