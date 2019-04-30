<?php
    /**
     * The right hand of God ( lol )
     * 
     * This broker is responsible for the planetary creation
     * */
    include("../includes/class_mdbroker.php");
    $verbose = $_SERVER['argc'] > 1 && $_SERVER['argv'][1] == '-v';
    $broker = new Mdbroker(true);
    $broker->bind("tcp://*:5555");
    $broker->listen();

?>