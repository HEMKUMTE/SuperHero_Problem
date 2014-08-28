<?php
	$customar_type = "";
	$booking_days = array("weekday" => 0, "weekend" => 0);
	
	$days =  array("mon" => "weekday", "tues" => "weekday", "wed" => "weekday",
			"thur" => "weekday","fri" => "weekday", "sat" => "weekend","sun" => "weekend");

	$rates = array(
			"lakewood"  => array("weekday" => array("regular" => 110, "rewards" => 80),
					    "weekend" => array("regular" => 90, "rewards" => 80),
						"rating"=>3),
			"bridgewood" => array("weekday" => array("regular" => 160, "rewards" => 110),
                                            "weekend" => array("regular" => 60, "rewards" => 50),
						"rating"=>4),
			"ridgewood" => array("weekday" => array("regular" => 220, "rewards" => 100),
                                            "weekend" => array("regular" => 150, "rewards" => 40),
						"rating"=>5)
		);



	## Function is use to extract customer type and days from the input
	function  extractData($data){

		global $customar_type, $booking_days, $days;
		$booking_days = array("weekday" => 0, "weekend" => 0);
		
		$data = trim($data);
		$data = strtolower($data);
		$temp = explode(":", $data);
		$customar_type = trim($temp[0]);
		$temp = explode(",", $temp[1]);
		$pattern = '!(.*?)\((.*?)\)!';
		foreach($temp as $value) {
			if(preg_match_all($pattern, $value, $matches)){
				$tday = trim($matches[2][0]);
				if(!empty($days[$tday]) && $days[$tday] == 'weekday') {
					$booking_days['weekday'] += 1;	
				} else if(!empty($days[$tday]) && $days[$tday] == 'weekend') {
					$booking_days['weekend'] += 1;
				}
			}		
		}
	}


	## Calcluate cheap hotel on the basis of rating
	function  getCheapHotel($data){
		global $customar_type, $booking_days, $rates;		
		
		$calculate_hotel_rates = array();
		
		$best_hotel = "";
		
		
		extractData($data);
		
		foreach($rates as $indx => $value){
			if(empty($value['weekday'][$customar_type]))
				break;

			$temp_rates = 0;
			$temp_rates += ($value['weekday'][$customar_type] * $booking_days['weekday']); 
			$temp_rates += ($value['weekend'][$customar_type] * $booking_days['weekend']);
 			$calculate_hotel_rates[$indx]['cost'] = $temp_rates;
			$calculate_hotel_rates[$indx]['rating'] = $value['rating'];
		}
		
		asort($calculate_hotel_rates);
		
		foreach($calculate_hotel_rates as $indx => $value) {
			if(!empty($value['cost']) && $best_hotel == "") {
				$best_hotel = $indx;
				$temp_rate = $value['rating'];
				$temp_cost = $value['cost'];
			} else {
				
				if(!empty($value['cost']) && ($temp_cost == $value['cost'])) {
					if($temp_rate < $value['rating']) {
						$best_hotel = $indx;
						$temp_rate = $value['rating'];
					}
				} else {
					break;
				}
			}
		}
		echo "  ".ucfirst($best_hotel);
	}


$input1 = "Regular: 16Mar2009(mon), 17Mar2009(tues), 18Mar2009(wed)";
getCheapHotel($input1);

$input2 = "Regular: 20Mar2009(fri), 21Mar2009(sat), 22Mar2009(sun)";
getCheapHotel($input2);


$input3 = "Rewards: 26Mar2009(thur), 27Mar2009(fri), 28Mar2009(sat)";
getCheapHotel($input3);

?>
 
