<?php
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    include_once("includes/opensimplex.php");
    class planeta {
        private $reader;

        private function csv2json($ficheiro) {            
            $spreadsheet = $this->reader->load($ficheiro);
            $spreadsheet->setActiveSheetIndex(0);
            
            $planetas = [];
            $hr = $spreadsheet->getActiveSheet()->getHighestRow();
            for($i=4; $i<=$hr;$i++) {
                $planetas[] = [
                    'nome' => $spreadsheet->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),
                    //'a' => $spreadsheet->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),
                    //'e'	=> $spreadsheet->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(), 
                    //'axial_tilt' => $spreadsheet->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),	 
                    //'mass' => $spreadsheet->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),	 
                    'gas_giant' => trim($spreadsheet->getActiveSheet()->getCell('F'.$i)->getCalculatedValue()),	 
                    //'dust_mass' => $spreadsheet->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),	 
                    //'gas_mass' => $spreadsheet->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),	 
                    //'core_radius' => $spreadsheet->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),	 
                    'radius' => trim($spreadsheet->getActiveSheet()->getCell('J'.$i)->getCalculatedValue()),	 
                    //'orbit_zone' => $spreadsheet->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),
                    //'density' => $spreadsheet->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),
                    //'orb_period' => $spreadsheet->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),
                    //'day' => $spreadsheet->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),
                    //'resonant_period' => $spreadsheet->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),
                    //'esc_velocity' => $spreadsheet->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),
                    //'surf_accel' => $spreadsheet->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),
                    //'surf_grav' => $spreadsheet->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),
                    //'rms_velocity' => $spreadsheet->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),
                    //'molec_weight' => $spreadsheet->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),
                    //'volatile_gas_inventory' => $spreadsheet->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),
                    //'surf_pressure' => $spreadsheet->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),
                    //'greenhouse_effect' => $spreadsheet->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),
                    //'boil_point' => $spreadsheet->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),
                    //'albedo' => $spreadsheet->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),
                    //'exospheric_temp' => $spreadsheet->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),
                    //'estimated_temp' => $spreadsheet->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),
                    //'estimated_terr_temp' => $spreadsheet->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),
                    //'surf_temp' => $spreadsheet->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),
                    //'greenhs_rise' => $spreadsheet->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),
                    'high_temp' => trim($spreadsheet->getActiveSheet()->getCell('AE'.$i)->getCalculatedValue()),
                    'low_temp' => trim($spreadsheet->getActiveSheet()->getCell('AF'.$i)->getCalculatedValue()),
                    'max_temp' => trim($spreadsheet->getActiveSheet()->getCell('AG'.$i)->getCalculatedValue()),
                    'min_temp' => trim($spreadsheet->getActiveSheet()->getCell('AH'.$i)->getCalculatedValue()),
                    'hydrosphere' => trim($spreadsheet->getActiveSheet()->getCell('AI'.$i)->getCalculatedValue()),//Oceanic Rate
                    'cloud_cover' => trim($spreadsheet->getActiveSheet()->getCell('AJ'.$i)->getCalculatedValue()),//fuckit... Moisture Rate
                    'ice_cover' => trim($spreadsheet->getActiveSheet()->getCell('AK'.$i)->getCalculatedValue()),//heat level negativa
                    //'atmosphere' => $spreadsheet->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),
                    'type' => trim($spreadsheet->getActiveSheet()->getCell('AM'.$i)->getCalculatedValue()),
                    //'minor_moons' => $spreadsheet->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),
    
                ];
            }
            
            $json = [
                "seed" => str_replace('\'',"",$spreadsheet->getActiveSheet()->getCell('A1')->getCalculatedValue()),
                "name" => str_replace('\'',"",$spreadsheet->getActiveSheet()->getCell('B2')->getCalculatedValue()),
                "luminosity" => str_replace('\'',"",$spreadsheet->getActiveSheet()->getCell('B2')->getCalculatedValue()),
                "mass" => str_replace('\'',"",$spreadsheet->getActiveSheet()->getCell('C2')->getCalculatedValue()),
                "life" => str_replace('\'',"",$spreadsheet->getActiveSheet()->getCell('D2')->getCalculatedValue()),
                "luminosity" => str_replace('\'',"",$spreadsheet->getActiveSheet()->getCell('E2')->getCalculatedValue()),
                "r_ecosphere" => str_replace('\'',"",$spreadsheet->getActiveSheet()->getCell('F2')->getCalculatedValue()),
                "planetas" => $planetas
            ];
                       
            $json = json_encode($json);
            if (file_put_contents(str_replace(".csv",".json",$ficheiro),$json)) {
                unlink($ficheiro);
            }
            $reader = null;
            return $json;
        }

        private function bulkconvert() {
            //converter os ficheiros gerados pelo stargen para outro formato
                /* não usar esta função para já */
            $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(dirname(__DIR__)."/data/sistemas/"), RecursiveIteratorIterator::SELF_FIRST);
            foreach($objects as $name => $object){
                if (strstr($name,"StarGen.csv")) {
                    $json = json_decode(csv2json($name),true);
                    foreach($json["planetas"] as $planeta) {
                        $output = dirname($name)."/".str_replace([" ",'\''],["-",""],$planeta["nome"]).".json";
                        echo 'php planetgen.php --raio='.$planeta["radius"]." --tipo=".str_replace([" ",'\''],["-",""],$planeta["type"])." --output=$output".PHP_EOL;
                        shell_exec('php planetgen.php --raio='.$planeta["radius"]." --tipo=".str_replace([" ",'\''],["-",""],$planeta["type"])." --output=$output");                
                    }
                }
                $i = 0;
            } 
        }

        public function biome($e, $m) {      
            /*if (e < 0.1) return OCEAN;
            if (e < 0.12) return BEACH;
            
            if (e > 0.8) {
              if (m < 0.1) return SCORCHED;
              if (m < 0.2) return BARE;
              if (m < 0.5) return TUNDRA;
              return SNOW;
            }
          
            if (e > 0.6) {
              if (m < 0.33) return TEMPERATE_DESERT;
              if (m < 0.66) return SHRUBLAND;
              return TAIGA;
            }
          
            if (e > 0.3) {
              if (m < 0.16) return TEMPERATE_DESERT;
              if (m < 0.50) return GRASSLAND;
              if (m < 0.83) return TEMPERATE_DECIDUOUS_FOREST;
              return TEMPERATE_RAIN_FOREST;
            }
          
            if (m < 0.16) return SUBTROPICAL_DESERT;
            if (m < 0.33) return GRASSLAND;
            if (m < 0.66) return TROPICAL_SEASONAL_FOREST;
            return TROPICAL_RAIN_FOREST;*/
          }

        public function __construct($RAIO=3000,$TIPO='',$nome='',$ficheiro='') {
            $gen = new openSimplexNoise();

            $width = $RAIO;
            $height = $RAIO;
            $seed = null;
            
            $elevation_txt = '';
            $moisture_txt = '';            

            for ($y = 0; $y < $height; $y++) {         
                $tempe = '';
                $tempm = '';

                for ($x = 0; $x < $width; $x++) {      
                    $nx = $x/$width - 0.5;
                    $ny = $y/$height - 0.5;
                    
                    $e =  1 * $gen->noise2D(1 * $nx, 1 * $ny)  
                    + 0.5 * $gen->noise2D(2 * $nx, 2 * $ny) 
                    + 0.25 * $gen->noise2D(4 * $nx, 2 * $ny);

                    $e /= (1.00+0.50+0.25+0.13+0.06+0.03);
                    $e = pow($e, 5.00);
                    
                    if ($TIPO == "Jovian" || $TIPO == "Sub-Jovian" || $TIPO == "GasDwarf") {
                        $m = 0;
                        if ($TIPO == "GasDwarf") {
                            $e = 0;
                        }
                    }
                    else {
                        $m = (1.00 * $gen->noise2D( 1 * $nx,  1 * $ny)
                        + 1.00 * $gen->noise2D( 2 * $nx,  2 * $ny)
                        + 1.00 * $gen->noise2D( 4 * $nx,  4 * $ny)
                        + 0.23 * $gen->noise2D( 8 * $nx,  8 * $ny)
                        + 0.33 * $gen->noise2D(16 * $nx, 16 * $ny)
                        + 0.50 * $gen->noise2D(32 * $nx, 32 * $ny));
                        $m /= (1.00+1.00+1.00+0.23+0.33+0.50);
                    }    
                    $tempe .= $e.".";
                    $tempm .= $m.".";                                     
                }
                $elevation_txt .= rtrim($tempe,".");
                $moisture_txt .= rtrim($tempe,".");
            }
            //escrever para um ficheiro de texto os descriptores de elevação e humidade
        }

    }