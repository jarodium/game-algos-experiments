<?php
    //namespace my_ns;
    
    class jogador {
        private $id = "";
        public $posicao;
        
        function mover($ctx,$x,$y, $z=0) {
            $this->posicao = [$ctx,$x,$y,$z];
        }
        
        function __construct() {
            $this->id = uniqid();
        }
        
    }
?>