<?php
        include("../vendor/autoload.php"); 
        use Ethtezahl\DiceRoller\CupFactory;

        function rollit($dados,$conta=0) {
                $factory = new CupFactory();
                $cup = $factory->newInstance($dados);    
                $x = $conta > 0 ? $cup->roll()+$conta : $cup->roll()-($conta*-1);
                return $x > -1 ? $x : 0;
        }

        //echo rollit("5D20",5);
        var_dump(json_decode(file_get_contents(dirname(__DIR__)."/universe/data/NAMES.json")));
        