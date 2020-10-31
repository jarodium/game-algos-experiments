<?php
    //this file is responsibile for creating the Universe
    include("../vendor/autoload.php");    
    include("../universe/class_universo.php");
        
    $OM = new universo();
    $OM->construir(__DIR__."/data/UNIVERSO.json",__DIR__."/data/SECTORES.json");
?>