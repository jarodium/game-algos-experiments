<?php
        include("../vendor/autoload.php");    
        include("../universe/includes/opensimplex.php");
        include("../universe/class_star_system.php");
             
        $SS = new star_system();
        $SS->generate_star();
        //$OM->construir(__DIR__."/data/UNIVERSO.json",__DIR__."/data/SECTORES.json");