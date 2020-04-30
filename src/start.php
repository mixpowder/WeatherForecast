<?php

while(true){
    $stdin = trim(fgets(STDIN));
    if ($stdin === "stop"){
        echo "終了";
        break;
    }else{
        echo $stdin;
    }
}