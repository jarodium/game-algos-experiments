<?php
/*
* Majordomo Protocol worker example
* Uses the mdwrk API to hide all MDP aspects
*
* @author Ian Barber <ian(dot)barber(at)gmail(dot)com>
*/

include_once("../vendor/autoload.php");
include_once("../includes/opensimplex.php");
include_once '../includes/class_planeta.php';


$planeta = new planeta();
$ret = $planeta->criarPlaneta($j["R"],$j["TIPO"],$j["OUT"]);
    