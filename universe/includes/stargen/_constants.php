<?php
    define('RADIANS_PER_ROTATION',          2.0 * M_PI);
    define('ECCENTRICITY_COEFF',            0.077);			/* Dole's was 0.077			*/
    define('PROTOPLANET_MASS',              1.0E-15);		/* Units of solar masses	*/
    define('CHANGE_IN_EARTH_ANG_VEL',       -1.3E-15);		/* Units of radians/sec/year*/
    define('SOLAR_MASS_IN_GRAMS',           1.989E33);		/* Units of grams			*/
    define('SOLAR_MASS_IN_KILOGRAMS',       1.989E30);		/* Units of kg				*/
    define('EARTH_MASS_IN_GRAMS',           5.977E27);		/* Units of grams			*/
    define('EARTH_RADIUS',                  6.378E8);		/* Units of cm				*/
    define('EARTH_DENSITY',                 5.52);			/* Units of g/cc			*/
    define('KM_EARTH_RADIUS',			    6378.0);		/* Units of km				*/
    //      EARTH_ACCELERATION		        (981.0);		/* Units of cm/sec2			*/
    define('EARTH_ACCELERATION',            980.7);			/* Units of cm/sec2			*/
    define('EARTH_AXIAL_TILT',              23.4);			/* Units of degrees			*/
    define('EARTH_EXOSPHERE_TEMP',	        1273.0);		/* Units of degrees Kelvin	*/
    define('SUN_MASS_IN_EARTH_MASSES',      332775.64);
    define('ASTEROID_MASS_LIMIT',           0.001);			/* Units of Earth Masses	*/
    define('EARTH_EFFECTIVE_TEMP',          250.0);			/* Units of degrees Kelvin (was 255)	*/
    define('CLOUD_COVERAGE_FACTOR',         1.839E-8);		/* Km2/kg					*/
    define('EARTH_WATER_MASS_PER_AREA',	    3.83E15);	    /* grams per square km		*/
    define('EARTH_SURF_PRES_IN_MILLIBARS',  1013.25);
    define('EARTH_SURF_PRES_IN_MMHG',       760.);			/* Dole p. 15				*/
    define('EARTH_SURF_PRES_IN_PSI',	    14.696);		/* Pounds per square inch	*/
    define('MMHG_TO_MILLIBARS',             EARTH_SURF_PRES_IN_MILLIBARS / EARTH_SURF_PRES_IN_MMHG);
    define('PSI_TO_MILLIBARS',              EARTH_SURF_PRES_IN_MILLIBARS / EARTH_SURF_PRES_IN_PSI);
    define('H20_ASSUMED_PRESSURE',	        47. * MMHG_TO_MILLIBARS);   /* Dole p. 15       */
    define('MIN_O2_IPP',	                72. * MMHG_TO_MILLIBARS);	/* Dole, p. 15	    */
    define('MAX_O2_IPP',	                400. * MMHG_TO_MILLIBARS);	/* Dole, p. 15		*/
    define('MAX_HE_IPP',	                61000. * MMHG_TO_MILLIBARS);    /* Dole, p. 16	*/
    define('MAX_NE_IPP',	                3900. * MMHG_TO_MILLIBARS);	    /* Dole, p. 16	*/
    define('MAX_N2_IPP',	                2330. * MMHG_TO_MILLIBARS);	    /* Dole, p. 16	*/
    define('MAX_AR_IPP',	                1220. * MMHG_TO_MILLIBARS);	    /* Dole, p. 16	*/
    define('MAX_KR_IPP',	                350. * MMHG_TO_MILLIBARS);	    /* Dole, p. 16	*/
    define('MAX_XE_IPP',	                160. * MMHG_TO_MILLIBARS);	    /* Dole, p. 16	*/
    define('MAX_CO2_IPP',                   7. * MMHG_TO_MILLIBARS);	    /* Dole, p. 16  */
    define('MAX_HABITABLE_PRESSURE',        118 * PSI_TO_MILLIBARS);	    /* Dole, p. 16	*/
    // The next gases are listed as poisonous in parts per million by volume at 1 atm:
    define('PPM_PRSSURE',                   EARTH_SURF_PRES_IN_MILLIBARS / 1000000.);
    define('MAX_F_IPP',	                    0.1 * PPM_PRSSURE);			    /* Dole, p. 18	*/
    define('MAX_CL_IPP',	                1.0 * PPM_PRSSURE);			    /* Dole, p. 18	*/
    define('MAX_NH3_IPP',	                100. * PPM_PRSSURE);		    /* Dole, p. 18	*/
    define('MAX_O3_IPP',	                0.1 * PPM_PRSSURE);			    /* Dole, p. 18	*/
    define('MAX_CH4_IPP',	                50000. * PPM_PRSSURE);		    /* Dole, p. 18	*/
    define('EARTH_CONVECTION_FACTOR',       0.43);          /* from Hart, eq.20 */
    //      FREEZING_POINT_OF_WATER', (273.0);			/* Units of degrees Kelvin	*/
    define('FREEZING_POINT_OF_WATER',       273.15);    /* Units of degrees Kelvin	*/
    //      EARTH_AVERAGE_CELSIUS',   (15.5);			/* Average Earth Temperature */
    define('EARTH_AVERAGE_CELSIUS',         14.0);			/* Average Earth Temperature */
    define('EARTH_AVERAGE_KELVIN',          EARTH_AVERAGE_CELSIUS + FREEZING_POINT_OF_WATER);
    define('DAYS_IN_A_YEAR',                365.256);		/* Earth days per Earth year*/
    //		gas_retention_threshold = 5.0;  		/* ratio of esc vel to RMS vel */
    define('GAS_RETENTION_THRESHOLD',       6.0);			/* ratio of esc vel to RMS vel */

    define('ICE_ALBEDO',			        0.7);
    define('CLOUD_ALBEDO',			        0.52);
    define('GAS_GIANT_ALBEDO',		        0.5);			/* albedo of a gas giant	*/
    define('AIRLESS_ICE_ALBEDO',	        0.5);
    define('EARTH_ALBEDO',			        0.3);			/* was .33 for a while */
    define('GREENHOUSE_TRIGGER_ALBEDO',     0.20);
    define('ROCKY_ALBEDO',			        0.15);
    define('ROCKY_AIRLESS_ALBEDO',	        0.07);
    define('WATER_ALBEDO',			        0.04);

    define('SECONDS_PER_HOUR',		        3600.0);
    define('CM_PER_AU',				        1.495978707E13); /* number of cm in an AU	*/
    define('CM_PER_KM',				        1.0E5);			/* number of cm in a km		*/
    define('KM_PER_AU',				        CM_PER_AU / CM_PER_KM);
    define('CM_PER_METER',			        100.0);
    //define('MILLIBARS_PER_BAR		(1013.25)
    define('MILLIBARS_PER_BAR',		        1000.00);

    define('GRAV_CONSTANT',			        6.672E-8);		/* units of dyne cm2/gram2	*/
    define('MOLAR_GAS_CONST',			    8314.41);		/* units: g*m2/(sec2*K*mol) */
    define('K',						        50.0);			/* K = gas/dust ratio		*/
    define('B',						        1.2E-5);		/* Used in Crit_mass calc	*/
    define('DUST_DENSITY_COEFF',		    2.0E-3);	    /* A in Dole's paper		*/
    define('ALPHA',					        5.0);			/* Used in density calcs	*/
    define('N',						        3.0);			/* Used in density calcs	*/
    define('J',						        1.46E-19);		/* Used in day-length calcs (cm2/sec2 g) */    
    define('INCREDIBLY_LARGE_NUMBER',       9.9999E37);    

    /*	Now for a few molecular weights (used for RMS velocity calcs):	   */
    /*	This table is from Dole's book "Habitable Planets for Man", p. 38  */

    define('ATOMIC_HYDROGEN',			1.0);	/* H   */
    define('MOL_HYDROGEN',			    2.0);	/* H2  */
    define('HELIUM',					4.0);	/* He  */
    define('ATOMIC_NITROGEN',			14.0);	/* N   */
    define('ATOMIC_OXYGEN',			    16.0);	/* O   */
    define('METHANE',			        16.0);	/* CH4 */
    define('AMMONIA',					17.0);	/* NH3 */
    define('WATER_VAPOR',				18.0);	/* H2O */
    define('NEON',					    20.2);	/* Ne  */
    define('MOL_NITROGEN',		    	28.0);	/* N2  */
    define('CARBON_MONOXIDE',			28.0);	/* CO  */
    define('NITRIC_OXIDE',			    30.0);	/* NO  */
    define('MOL_OXYGEN',                32.0);	/* O2  */
    define('HYDROGEN_SULPHIDE',		    34.1);	/* H2S */
    define('ARGON',					    39.9);	/* Ar  */
    define('CARBON_DIOXIDE',			44.0);	/* CO2 */
    define('NITROUS_OXIDE',			    44.0);	/* N2O */
    define('NITROGEN_DIOXIDE',		    46.0);	/* NO2 */
    define('OZONE',					    48.0);	/* O3  */
    define('SULPH_DIOXIDE',			    64.1);	/* SO2 */
    define('SULPH_TRIOXIDE',			80.1);	/* SO3 */
    define('KRYPTON',					83.8);	/* Kr  */
    define('XENON',					    131.3); /* Xe  */

    //	And atomic numbers, for use in ChemTable indexes
    define('AN_HE',	                        2);
    define('AN_N',	                        7);
    define('AN_O',	                        8);
    define('AN_H',	                        1);
    define('AN_F',	                        9);
    define('AN_NE',	                        10);
    define('AN_P',	                        15);
    define('AN_CL',	                        17);
    define('AN_AR',	                        18);
    define('AN_BR',	                        35);
    define('AN_KR',	                        36);
    define('AN_I',	                        53);
    define('AN_XE',	                        54);
    define('AN_HG',	                        80);
    define('AN_AT',	                        85);
    define('AN_RN',	                        86);
    define('AN_FR',	                        87);

    define('AN_NH3',	                    900);
    define('AN_H2O',	                    901);
    define('AN_CO2',	                    902);
    define('AN_O3',	                        903);
    define('AN_CH4',	                    904);
    define('AN_CH3CH2OH',	                905);
    define('A1_20',					        6.485E12);		/* All units are in cgs system.	 */
    define('A2_20',					        4.0032E-8);		/*	 ie: cm, g, dynes, etc.		 */
    define('BETA_20',					    5.71E12);
    define('JIMS_FUDGE',				    1.004);

    /*	 The following defines are used in determining the fraction of a planet	 */
    /*	covered with clouds in function cloud_fraction in file enviro.c.		 */
    define('Q1_36',					        1.258E19);		        /* grams	*/
    define('Q2_36',					        0.0698);		        /* 1/Kelvin */

    /* converted macros */
    function pow2($a) {     return (($a) * ($a));                   }
    function pow3($a) {     return (($a) * ($a) * ($a));            }
    function pow4($a) {     return (($a) * ($a) * ($a) * ($a));     }
    function pow1_4($a) {   return sqrt(sqrt($a));                  }
    function pow1_34($a) {  return pow($a,(1.0/3.0));               }

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
    
       
