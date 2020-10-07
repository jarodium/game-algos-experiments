<?php
/* converted structs.h */
$dust_record_dust_pointer = [];
$planets_record_planet_pointer = [];
$gen_gen_pointer = [];


class planet_type { 
    var $tUnknown = 0; 
    var $tRock = 1; 
    var $tVenusian = 2; 
    var $tTerrestrial = 3; 
    var $tGasGiant = 4; 
    var $tMartian = 6;
    var $tWater = 7; 
    var $tIce = 8; 
    var $tSubGasGiant = 9; 
    var $tSubSubGasGiant = 10; 
    var $tAsteroids = 11; 
    var $t1Face = 12; 
    // etc. 
} 

class gas {
    var $num = 0;
    var $surf_pressure = 0.00;
}

class sun {
    var $luminosity = 0.00;
    var $mass = 0.00;
    var $life = 0.00;
    var $age = 0.00;
    var $r_ecosphere = 0.00;
    var $name = '';
}


class planet_record {
    var $planet_no = 0;
    var $a;			        /* semi-major axis of solar orbit (in AU)       */
    var $e;				/* eccentricity of solar orbit		        */
    var $axial_tilt;			/* units of degrees			        */
    var $mass;	                        /* mass (in solar masses)			*/
    var $gas_giant;                     /* TRUE if the planet is a gas giant            */
    var $dust_mass;                     /* mass, ignoring gas				*/
    var $gas_mass;                      /* mass, ignoring dust				*/
                                            /*   ZEROES start here                      */
    var $moon_a;                    /* semi-major axis of lunar orbit (in AU)           */
    var $moon_e;                    /* eccentricity of lunar orbit		        */
    var $core_radius;               /* radius of the rocky core (in km)	                */
    var $radius;	            /* equatorial radius (in km)		        */
    var $orbit_zone;			                    /* the 'zone' of the planet			 */
    var $density;			                        /* density (in g/cc)				 */
    var $orb_period;			                    /* length of the local year (days)	 */
    var $day;				                        /* length of the local day (hours)	 */
    var $resonant_period;	                        /* TRUE if in resonant rotation		 */
    var $esc_velocity;		                        /* units of cm/sec					 */
    var $surf_accel;			                    /* units of cm/sec2					 */
    var $surf_grav;			                        /* units of Earth gravities			 */
    var $rms_velocity;		                        /* units of cm/sec					 */
    var $molec_weight;		                        /* smallest molecular weight retained*/
    var $volatile_gas_inventory;
    var $surf_pressure;		                        /* units of millibars (mb)			 */
    var $greenhouse_effect;	                        /* runaway greenhouse effect?		 */
    var $boil_point;			                    /* the boiling point of water (Kelvin)*/
    var $albedo;				                    /* albedo of the planet				 */
    var $exospheric_temp;	                        /* units of degrees Kelvin			 */
    var $estimated_temp;                            /* quick non-iterative estimate (K)  */
    var $estimated_terr_temp;                       /* for terrestrial moons and the like*/
    var $surf_temp;			                        /* surface temperature in Kelvin	 */
    var $greenhs_rise;		                        /* Temperature rise due to greenhouse */
    var $high_temp;			                        /* Day-time temperature              */
    var $low_temp;			                        /* Night-time temperature			 */
    var $max_temp;			                        /* Summer/Day						 */
    var $min_temp;			                        /* Winter/Night						 */
    var $hydrosphere;		                        /* fraction of surface covered		 */
    var $cloud_cover;		                        /* fraction of surface covered		 */
    var $ice_cover;			                        /* fraction of surface covered		 */
    var $sun;
    var $gases = 0;			                        /* Count of gases in the atmosphere: */
    var $atmosphere;
    var $type;  	            /* Type code						 */
    var $minor_moons = 0;
    /*planet_pointer first_moon;*/
                                                /*   ZEROES end here               */
    /*planet_pointer next_planet;*/
    var $planet_pointer = ['first_moon','next_planet'];
                                                /*   ZEROES end here               */
    public function __construct() {
            $this->sun = new sun();
            $this->atmosphere = new gas();
            $this->type = new planet_type();
    }
}

/*	Define the solar system for comparisons, etc. */
define ('tUnknown', 0);
define ('ZEROES', [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL,0,NULL,tUnknown]);

class dust_record {
    var $inner_edge = 0.00;
    var $outer_edge = 0.00;
    var $dust_present = 0;
    var $gas_present = 0;
    var $dust_pointer = ["next_band"];
}

abstract class star {
    var $luminosity = 0.00;
    var $mass = 0.00;
    var $m2 = 0.00;
    var $e = 0.00;
    var $a = 0.00;
    var $planet_pointer = ["known_planets"];
    var $desig = "";
    var $in_celestia = 0;
    var $name = "";
};

abstract class catalog {
    var $count = 0;
    var $arg = "";
    var $stars = []; //place values as instances of star
};

class gen  {
    var $dusts = [];
    var $planets = [];
    var $next = [];
};

// From Keris

abstract class ChemTableS
{
  var $num = 0;
  var $symbol = '';
  var $html_symbol = '';
  var $name = '';
  var $weight = 0.00;
  var $melt = 0.00;
  var $boil = 0.00;
  var $density = 0.00;
  var $abunde = 0.00;
  var $abunds = 0.00;
  var $reactivity = 0.00;
  var $max_ipp = 0.00;	// Max inspired partial pressure im millibars
}