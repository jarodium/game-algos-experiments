<?php
/* converted structs.h */
$dust_record_dust_pointer = [];
$planets_record_planet_pointer = [];
$gen_gen_pointer = [];


abstract class planet_type { 
    const tUnknown = 0; 
    const tRock = 1; 
    const tVenusian = 2; 
    const tTerrestrial = 3; 
    const tGasGiant = 4; 
    const tMartian = 6;
    const tWater = 7; 
    const tIce = 8; 
    const tSubGasGiant = 9; 
    const tSubSubGasGiant = 10; 
    const tAsteroids = 11; 
    const t1Face = 12; 
    // etc. 
} 
    /*
        Note: Assuming an abstract class to replace the typedf enum in C

        typedef enum planet_type {
            ...
        } planet_type;
    */
abstract class gas {
    var $num = 0;
    var $surf_pressure = 0.00;
}

abstract class sun {
    var $luminosity = 0.00;
    var $mass = 0.00;
    var $life = 0.00;
    var $age = 0.00;
    var $r_ecosphere = 0.00;
    var $name = '';
}


abstract class planets_record {
    var $planet_no = 0;
    var $a;					                        /* semi-major axis of solar orbit (in AU)*/
    var $e;					                        /* eccentricity of solar orbit		 */
    var $axial_tilt;			                    /* units of degrees					 */
    var $mass;				                        /* mass (in solar masses)			 */
    var $gas_giant;			                        /* TRUE if the planet is a gas giant */
    var $dust_mass;			                        /* mass, ignoring gas				 */
    var $gas_mass;			                        /* mass, ignoring dust				 */
                                            /*   ZEROES start here               */
    var $moon_a;				                    /* semi-major axis of lunar orbit (in AU)*/
    var $moon_e;				                    /* eccentricity of lunar orbit		 */
    var $core_radius;		                        /* radius of the rocky core (in km)	 */
    var $radius;				                    /* equatorial radius (in km)		 */
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
    var $sun = new sun();
    var $gases = 0;			                        /* Count of gases in the atmosphere: */
    var $atmosphere = new gas();
    var $type = new planet_type();  	            /* Type code						 */
    var $minor_moons = 0;
    /*planet_pointer first_moon;*/
                                                /*   ZEROES end here               */
    /*planet_pointer next_planet;*/
    var $planet_pointer = ['first_moon','next_planet'];
                                                /*   ZEROES end here               */
}

abstract class planets_record {
    var $planet_no = 0;
    var $a = 0.00;					                /* semi-major axis of solar orbit (in AU)*/
    var $e = 0.00;					                /* eccentricity of solar orbit		 */
    var $axial_tilt = 0.00;			                /* units of degrees					 */
    var $mass = 0.00;				                /* mass (in solar masses)			 */
    var $gas_giant = 0;			                    /* TRUE if the planet is a gas giant */
    var $dust_mass = 0.00;			                /* mass, ignoring gas				 */
    var $gas_mass= 0.00;			                /* mass, ignoring dust				 */
                                                
                                                /*   ZEROES start here               */
    var $moon_a = 0.00;	    			            /* semi-major axis of lunar orbit (in AU)*/
    var $moon_e = 0.00;		    		            /* eccentricity of lunar orbit		 */
    var $core_radius = 0.00;	    	            /* radius of the rocky core (in km)	 */
    var $radius = 0.00; 				            /* equatorial radius (in km)		 */
    var $orbit_zone = 0;    			            /* the 'zone' of the planet			 */
    var $density = 0.00;	    		            /* density (in g/cc)				 */
    var $orb_period = 0.00;			                /* length of the local year (days)	 */
    var $day  = 0.00;				                /* length of the local day (hours)	 */
    var $resonant_period = 0;	                    /* TRUE if in resonant rotation		 */
    var $esc_velocity = 0.00;   		            /* units of cm/sec					 */
    var $surf_accel  = 0.00;			            /* units of cm/sec2					 */
    var $surf_grav = 0.00;			                /* units of Earth gravities			 */
    var $rms_velocity  = 0.00;	    	            /* units of cm/sec					 */
    var $molec_weight  = 0.00;		                /* smallest molecular weight retained*/
    var $volatile_gas_inventory = 0.00;
    var $surf_pressure = 0.00;		                /* units of millibars (mb)			 */
    var $greenhouse_effect = 0;	                    /* runaway greenhouse effect?		 */
    var $boil_point  = 0.00;			            /* the boiling point of water (Kelvin)*/
    var $albedo  = 0.00;				            /* albedo of the planet				 */
    var $exospheric_temp = 0.00;    	            /* units of degrees Kelvin			 */
    var $estimated_temp  = 0.00;                    /* quick non-iterative estimate (K)  */
    var $estimated_terr_temp = 0.00;                /* for terrestrial moons and the like*/
    var $surf_temp = 0.00;			                /* surface temperature in Kelvin	 */
    var $greenhs_rise = 0.00;		                /* Temperature rise due to greenhouse */
    var $high_temp = 0.00;			                /* Day-time temperature              */
    var $low_temp = 0.00;			                /* Night-time temperature			 */
    var $max_temp = 0.00;			                /* Summer/Day						 */
    var $min_temp = 0.00;			                /* Winter/Night						 */
    var $hydrosphere = 0.00;		                /* fraction of surface covered		 */
    var $cloud_cover = 0.00;		                /* fraction of surface covered		 */
    var $ice_cover = 0.00;			                /* fraction of surface covered		 */
    var $sun = new sun();
    var $gases = 0;     				            /* Count of gases in the atmosphere: */
    var $atmosphere = new gas();
    var $type = new planet_type();				/* Type code						 */
    var $minor_moons = 0;
   /*planet_pointer first_moon;*/
                                                /*   ZEROES end here               */
    /*planet_pointer next_planet;*/
    var $planet_pointer = ['first_moon','next_planet'];
                                                /*   ZEROES end here               */        
}

/*	Define the solar system for comparisons, etc. */
#define ZEROES 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL,0,NULL,tUnknown

abstract class dust_record {
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

abstract class gen  {
    var $dust_pointer = ["dusts"];
    var $planet_pointer = ["planets"];
    var $gen_pointer = ["next"];
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