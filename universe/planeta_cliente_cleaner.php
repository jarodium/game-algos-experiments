#!/usr/bin/env php
<?php
/*
* Majordomo Protocol client example
* Uses the mdcli API to hide all MDP aspects
*
* @author Ian Barber <ian(dot)barber(at)gmail(dot)com>
*/
include("../vendor/autoload.php");    
class MyDB extends SQLite3 {
    function __construct($ficheiro) {
        $set = file_exists($ficheiro.".db") ? 1 : 0;
        $this->open($ficheiro.'.db');
        if ($set == 0) {
            $this->exec("PRAGMA main.page_size = 4096;");
            $this->exec("PRAGMA main.cache_size=10000;");
            $this->exec("PRAGMA main.locking_mode=EXCLUSIVE;");
            $this->exec("PRAGMA main.journal_mode=WAL;");
            $this->exec("PRAGMA synchronous=OFF;");
        }
    }
}

$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(dirname(__DIR__)."/data/sistemas/"), RecursiveIteratorIterator::SELF_FIRST);
foreach($objects as $name => $object){
    if (strstr($name,".db")) {
        $db = new MyDB($name);
        if(!$db){
            echo $db->lastErrorMsg();
            die();
        } else {
            //echo "Opened database successfully\n";
        }
        $db->close();
    }
    $i = 0;
} 