<?php
/*
* Majordomo Protocol worker example
* Uses the mdwrk API to hide all MDP aspects
*
* @author Ian Barber <ian(dot)barber(at)gmail(dot)com>
*/

include_once("../vendor/autoload.php");
include_once '../includes/class_mdworker.php';
include_once("../includes/opensimplex.php");
include_once '../includes/class_planeta.php';


$verbose = false;
$mdwrk = new Mdwrk("tcp://localhost:5555", "generaterockicedwarf", $verbose);

$reply = NULL;
$planeta = new planeta();

while (true) {
    $request = $mdwrk->recv($reply);
    
    $reply = NULL;
    $j = json_decode($request->unwrap(),true);
    $ret = $planeta->criarPlaneta($j["R"],$j["TIPO"],$j["OUT"]);
    
    $reply = new Zmsg();
    
    if ($ret < 0) {
        $reply->body_set("500q");
    }
    else {
        $reply->body_set("200q");
    }
}