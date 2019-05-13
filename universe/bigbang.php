<?php
    //this file is responsibile for creating the Universe
    include("../vendor/autoload.php");    
    include("../includes/class_universo.php");
        
    $OM = new universo();
    $OM->construir();
?>