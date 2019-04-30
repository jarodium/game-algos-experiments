<?php
    use Bcn\Component\Json\Writer;
    use Bcn\Component\StreamWrapper\Stream;


    
   
   $db = new MyDB();
   if(!$db){
      echo $db->lastErrorMsg();
   } else {
      echo "Opened database successfully\n";
   }

    $sql =<<<EOF
      CREATE TABLE teste
      (X            INT,
      Y            INT, 
      BIO        INT,
      R         CHAR(50)
      );
EOF;

   $ret = $db->exec($sql);

    $width = 3000;
    $height = 3000;
    $seed = null;

    $planet = [];
    
    for ($y = 0; $y < $height; $y++) {
        $db->exec('BEGIN;');
        for ($x = 0; $x < $width; $x++) {      
            $nx = $x/$width - 0.5;
            $ny = $y/$height - 0.5;
            
            $e =  1 * $gen->noise(1 * $nx, 1 * $ny)  +  0.5 * $gen->noise(2 * $nx, 2 * $ny)      + 0.25 * $gen->noise(4 * $nx, 2 * $ny);
            //$e /= (1.00+0.50+0.25+0.13+0.06+0.03);
            $e = pow($e, 5.00);
            
            if ($j[1] == "Jovian" || $j[1] == "Sub-Jovian" || $j[1] == "GasDwarf") {
                $m = 0;
            }
            else {
                $m = (1.00 * $gen->noise( 1 * $nx,  1 * $ny)
                + 1.00 * $gen->noise( 2 * $nx,  2 * $ny)
                + 1.00 * $gen->noise( 4 * $nx,  4 * $ny)
                + 0.23 * $gen->noise( 8 * $nx,  8 * $ny)
                + 0.33 * $gen->noise(16 * $nx, 16 * $ny)
                + 0.50 * $gen->noise(32 * $nx, 32 * $ny));
                $m /= (1.00+1.00+1.00+0.23+0.33+0.50);
            }
            
            //$planet[$x][$y]["elev"] = $e;            
            //$writer->write("k", [$x,$y]);      // write key-value entry
            $db->exec("INSERT INTO teste (X,Y,BIO) VALUES ($x, $y,'".biome($j[1],$e,$m)."' );");
            //$writer->write(null, [$x,$y,biome($j[1],$e,$m)]);
                /*$planet[$x][$y]["b"] = ;
                $planet[$x][$y]["r"] = resourcing($j[1],$e);*/
            
            
            //$planet[$x][$y]["mois"] = $m;
        }
        $db->exec('COMMIT;');
        echo "$y \n";
         
    }
   
    //file_put_contents($j[2],json_encode($planet));
        /*$writer->leave();
    $writer->leave(); */
        
        
    /*$encoder = new \Violet\StreamingJsonEncoder\StreamJsonEncoder(
        $planet,
        function ($json) use ($fp) {
            fwrite($fp, $json);
        }
    );
    
    $encoder->encode();*/
  $db->close();