<?php
    use Ethtezahl\DiceRoller\CupFactory;
    class universe {
        protected $eixos = 12; //queremos registar 12 x 12 sectores
        private $CLUSTERS = [];
        private $SECTORES = [];
        private $distUA = (1/6);
        
        private function rollit($dados,$conta=0) {
            $factory = new CupFactory();
            $cup = $factory->newInstance($dados);    
            $x = $conta > 0 ? $cup->roll()+$conta : $cup->roll()-($conta*-1);
            return $x > -1 ? $x : 0;
        }

        private function criarSistemas($quantos,$tipo,$subtipo) {            
            $x = [];            
            for($i=0; $i<$quantos; $i++) {                                                
                array_push($x, [
                    'id' => uniqid('',true),
                    'posX' => $this->rollit("D12",-1),
                    'posY' => $this->rollit("D12",-1),
                    'posZ' => $this->rollit("D9",-1),
                    'code' => str_pad(mt_rand(0,100),4,"0",STR_PAD_LEFT),
                    "cat" => $tipo."-".$subtipo
                ]);
            }
            return $x;
        }


        public function construir($universe_file,$universe_sectors_file) {
            $constelacoes = json_decode(file_get_contents(__DIR__."/data/CONSTELLATIONS.json"),true);
            //initialize the constellation map
                //constellations have 144 elements in order to fit a 12x12 sector grid
            $UNIV = [];   
            for ($BBI=0; $BBI < $this->eixos; $BBI++) {
                for ($BBJ=0; $BBJ < $this->eixos; $BBJ++) {                               
                    //loop through all sectors
                    
                    shuffle($constelacoes);
                    $nome = array_shift($constelacoes);
                    
                    $UNIV[$BBI][$BBJ] = $nome;
                }
            }
            file_put_contents($universe_file,json_encode($UNIV));
            
            //how many galaxies of each type we will be generating
            $SECTORES = [];
            //barred spiral
            $SECTORES[] = $this->criarSistemas($this->rollit("D8",-7),"BSPI","gigas");
            $SECTORES[] = $this->criarSistemas($this->rollit("2D6",12),"BSPI","major");
            $SECTORES[] = $this->criarSistemas($this->rollit("4D20",36),"BSPI","minor");
            //spiral
            $SECTORES[] = $this->criarSistemas($this->rollit("D4",-2),"SPI","gigas");
            $SECTORES[] = $this->criarSistemas($this->rollit("2D6",12),"SPI","major");
            $SECTORES[] = $this->criarSistemas($this->rollit("4D20",36),"SPI","minor");
            // ring galaxy voids
            $SECTORES[] = $this->criarSistemas($this->rollit("2D4"),"RGV","major");
            $SECTORES[] = $this->criarSistemas($this->rollit("3D8",8),"RGV","major");
            // open cluster
            $SECTORES[] = $this->criarSistemas($this->rollit("3D20"),"OC","gigas");
            $SECTORES[] = $this->criarSistemas($this->rollit("8D20",20),"OC","major");
            
            
            file_put_contents($universe_sectors_file,json_encode($SECTORES));
            
            //criar os sistemas planetários com recurso ao stargen                       
            foreach($SECTORES as $TIPO => $SUBTIPO) {
                if (count($SUBTIPO) > 0) {
                    foreach($SUBTIPO as $SISTEMA) {
                        
                        $ma = mt_rand(1,70);
                       
                        $pasta = $SISTEMA["id"];
                        
                        $nome = $UNIV[$SISTEMA["posX"]][$SISTEMA["posY"]]["abbr"]." " .$UNIV[$SISTEMA["posX"]][$SISTEMA["posY"]]["name"]."-".($this->rollit("D6") < 6 ? "a" : "b");
                        
                       
                    }
                }
            }
        }
        
        public function __construct() {
                //por um worker que devolve a posicção dos clusters
            //$this->CLUSTERS = json_decode(file_get_contents(dirname(__DIR__)."/data/UNIVERSO.json"),true);
                //por um worker que devolve a posicção do sector
            //$this->SECTORES = json_decode(file_get_contents(dirname(__DIR__)."/data/SECTORES.json"),true);
        }
        
        
        
        public function identPos($posicao) {
            if ($posicao[0] == "CL") {
                $posicao[0] = "SEC";
                $ret = $this->identPos($posicao);
                $ret2 = isset($this->CLUSTERS[$posicao[1]][$posicao[2]]) ? $this->CLUSTERS[$posicao[1]][$posicao[2]] : -1;
                if ($ret == -1 || $ret2 == -1 ) return -1;
                else                            return array_merge($ret,$ret2);
            }
            
            if ($posicao[0] == "SEC") {
                $ret = -1;
                foreach($this->SECTORES as $SECTORX) {
                    foreach($SECTORX as $SECTORY) {
                        if ($SECTORY["posX"] == $posicao[1] && $SECTORY["posY"] == $posicao[2] && $SECTORY["posZ"] == $posicao[3]) {
                            return $SECTORY;
                        }
                    }
                }
                return $ret;
            }
        }
        
        public function calcularDistancia($p1,$p2) {
            return sqrt(    pow($p2[1]-$p1[1],2)   +   pow($p2[2]-$p1[2],2));
        }
        
        public function calcularDistancia2($p1, $p2) {
            $dist_entre_coordenadas = round(sqrt( pow($p2[1]-$p1[1],2)   +   pow($p2[2]-$p1[2],2)),2);
            /**
             * a partir do momento que em que a distância maior é calculada,
             * só preciso de determinar onde é que é para entrar e onde é para sair
             * */
            //determinar se estamos a subir na super-matrix
            if ($p1[1] < $p2[1]) {
                    
                //calcular a distância do ponto Z1 para saida do ponto de origem P1
                $dist_saida_origem = (9-$p1[2])*$this->distUA;
                //calcular a distância para a entrada do Ponto Z2 para o destino P2
                $dist_entrada_destino = $p2[2]*$this->distUA;
            }
            if ($p1[1] > $p2[1]) {
                    //recuo
                //calcular a distância do ponto Z1 para saida do ponto de origem P1
                $dist_saida_origem = $p1[2]*$this->distUA;
                //calcular a distância para a entrada do Ponto Z2 para o destino P2
                $dist_entrada_destino = (9-$p2[2])*$this->distUA;
            }
            
            echo $dist_entre_coordenadas.PHP_EOL;
            echo $dist_saida_origem.PHP_EOL;
            echo $dist_entrada_destino.PHP_EOL;
        
            return $dist_entre_coordenadas+round($dist_entrada_destino,2)+round($dist_saida_origem,2);
        }            
    
    }
?>