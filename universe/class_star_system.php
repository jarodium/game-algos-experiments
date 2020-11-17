<?php
        class star_system {
                private $temp_percentage;
                private $lum_percentage;
                private $rad_percentage;
                private $mass_percentage;

                function __construct() {
                        /**
                         * Create a seed
                         */
                        list($usec, $sec) = explode(' ', microtime());
                        $SEED = mt_srand($sec + $usec * 1000000);


                        $gen = new openSimplexNoise($SEED);

                        /**
                         * The following is borrowed from Tengen Toppa's anime's Ep. 26 xD
                         * Because I felt like it xD
                         */
                        $NEAR_PAST = mt_rand(0,100) * -1;
                        $NEAR_FUTURE = mt_rand(0,100);
                        
                        
                        $PRESENT = time();
                        /**
                         * Randomizing percentages using a noise function
                         */
                        $this->temp_percentage =  1 * $gen->noise2D(1 * $NEAR_PAST, 1 * $NEAR_FUTURE)  
                        + 0.5 * $gen->noise2D(2 * $NEAR_PAST, 2 * $NEAR_FUTURE) 
                        + 0.25 * $gen->noise2D(4 * $NEAR_FUTURE, 2 * $NEAR_PAST);

                        $this->lum_percentage =  1 * $gen->noise2D(1 * $NEAR_PAST, 1 * $NEAR_FUTURE)  
                        + 0.5 * $gen->noise2D(2 * $NEAR_PAST, 2 * $NEAR_FUTURE) 
                        + 0.25 * $gen->noise2D(4 * $NEAR_FUTURE, 2 * $NEAR_PAST);

                        $this->rad_percentage =  1 * $gen->noise3D(1 * $NEAR_PAST, 1 * $NEAR_FUTURE, 3 / $NEAR_PAST)  
                        + 0.5 * $gen->noise2D(2 * $NEAR_PAST, 2 * $NEAR_FUTURE, 3 * $NEAR_FUTURE) 
                        + 0.25 * $gen->noise2D(4 * $NEAR_FUTURE, 2 * $NEAR_PAST, 3 * $NEAR_FUTURE+$NEAR_PAST);

                        $this->mass_percentage =  1 * $gen->noise4D(1 * $NEAR_PAST, 1 * $NEAR_FUTURE, 3 / $NEAR_PAST, $PRESENT * -1)  
                        + 0.5 * $gen->noise4D(2 * $NEAR_PAST, 2 * $NEAR_FUTURE, 3 * $NEAR_FUTURE, $PRESENT * -0.5) 
                        + 0.25 * $gen->noise4D(4 * $NEAR_FUTURE, 2 * $NEAR_PAST, 3 * $NEAR_FUTURE+$NEAR_PAST, $PRESENT * -0.25);
                }

                function generate_star() {
                        /**
                         *      Reads a star system type from the data file
                         */

                        /**
                         *      If the percentage is negative, then the percentage is multiplied 
                         *      by 100 and multiplied by 0.5 ( TGT_PERC )
                         */

                        /**
                         *      If an attribute has a range defined, we randomize a number inside that range
                         *      and apply the below ( HND_PERC )
                         */

                        /**
                         *      Apply 3 way rule xD ( regra de 3 simples ) in order to 
                         *      find the correct value to apply in our newly generated star.
                         *      Next, round it for 2  dec places
                         *      
                         *      ROUND(TGT_PERC *  HND_PERC / 100,2)
                         * 
                         *      We have now the value to commit to the star 
                         */
                }

                public function report() {
                        echo PHP_EOL.$this->temp_percentage.PHP_EOL.$this->lum_percentage.PHP_EOL.$this->rad_percentage.PHP_EOL.$this->mass_percentage.PHP_EOL;
                }
                //http://www.astronomytrek.com/list-of-different-star-types/
                

                //also use spectral peculiarities from the  article above
                 /**
                         * Atempting to populate X planets in this system
                         * 3 planets is the minimum 12 is the maximum
                         */
                        /**
                         * To figure out how many planets we'll use 5 20-sided dice to see how many planets this system will have
                         * for 0 3 to 12 seek value
                         * sort the maximum value out and generate that many planets
                         */
                        /**
                         * 0 assumess gas cloud formation
                         */
                        /**
                         * Star System formation 
                         *  - Roll 10 6-side dice to determine star type
                         */
        }