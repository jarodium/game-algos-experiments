<?php
    //.db.db.db
    $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(dirname(__DIR__)), RecursiveIteratorIterator::SELF_FIRST);
    foreach($objects as $name => $object){
        if (stristr($name,".db.db")) {
            rename($name,str_replace(".db.db",".db",$name));
        }
    }
?>