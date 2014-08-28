<?php

	Class SuperHero {

		public  $hero_message;
		private $super_hero_code, $super_hero, $phone_translated_code;

		
		function __construct() {

			$this->super_hero_code = array();

			$this->hero_message = "";

			$this->super_hero = array( "SUPERMAN", "BATMAN", "THOR", "HULK", "ROBIN", "BLADE", "IRONMAN", 
						   "PHANTOM",  "GHOSTRIDER", "SPIDERMAN", "CAPTAINAMERICA", "BLACKWIDOW", 
						   "FLASH", "HELLBOY", "WOLVERINE", "PUNISHER" );

			$this->phone_translated_code = array( "A" => 2, "B" => 2, "C" => 2,
	                                                "D" => 3, "E" => 3, "F" => 3,
         	                                        "G" => 4, "H" => 4, "I" => 4,
                 	                                "J" => 5, "K" => 5, "L" => 5,
                         	                        "M" => 6, "N" => 6, "O" => 6,
                                 	                "P" => 7, "Q" => 7, "R" => 7, "S" => 7, 
                                         	        "T" => 8, "U" => 8, "V" => 8,
                                                	"W" => 9, "X" => 9, "Y" => 9, "Z" => 9 );


			$this->generateSuperHeroCode();
   		}


		## This function is used to generate  the number code for all listed super hero
		private function generateSuperHeroCode() {

			foreach($this->super_hero as $hero) {
				$temp_ch = str_split($hero);

				$temp_str = "";
				foreach($temp_ch as $ch){

					if(!empty($this->phone_translated_code[$ch])) 
						$temp_str .= $this->phone_translated_code[$ch];

				}


				if($temp_str !== "")
					$this->super_hero_code[$temp_str] = $hero;
			}

		}

		## This function fetch the super hero for the sms code
		private function decodeMessage(){
			if(!empty($this->hero_message)) {

				if(!empty($this->super_hero_code[$this->hero_message]))
					print  $this->super_hero_code[$this->hero_message];
				else
					print "Invaild Code";
			}
		}

		## this function is used to accept the smscode and decode it.
		public function smsRecieve($code){

			$temp = explode(" ", $code);
			if($temp[0] == '0'){
				$this->hero_message = $temp[1];

				$this->decodeMessage();
			} else {
				echo "Invalid code";
			}
		}
	}


	$obj = new SuperHero();
	$obj->smsRecieve("0 228626");
	echo "   "; 
	$obj->smsRecieve("0 4855");
	echo "   ";  
        $obj->smsRecieve("0 78737626");
	echo "   "; 
	$obj->smsRecieve("0 8467"); 
        echo "   ";  


?>
