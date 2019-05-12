<?php
    include("../vendor/autoload.php");
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
    
    function csv2json($ficheiro) {
        global $reader;
        $spreadsheet = $reader->load($ficheiro);
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
        
        //unset($reader);
        $json = json_encode($json);
        if (file_put_contents(str_replace(".csv",".json",$ficheiro),$json)) {
            unlink($ficheiro);
        }
        
        return $json;
    }
    
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