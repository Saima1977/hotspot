<?php
require_once ('additional_functions.php');
require_once ('mikrotik_functions.php');

if(isset($_POST['room_no']))
{
	$lname = $_POST['lname'];
	$room_no = $_POST['room_no'];
	$mac = $_POST['mac'];
	$ip_addr = $_POST['ipaddr'];
	$referrer = $_POST['referrer'];
	$hotel_no = "";	

	$Web_Service_URL = MERITON_API_URL.'/?hotel='.$hotel_no.'&room='.$room_no;

	debugTextLogger("$room_no Starting cURL call to Meriton API ".$Web_Service_URL);
	
	// Init the cURL session
	$result = postCurl($Web_Service_URL);
}
debugTextLogger($result);

if($result != FALSE)
{
	$xml=simplexml_load_string($result) or die("Error: Cannot create object");

	foreach($xml as $key=>$val)
	{
		foreach($val as $a=>$b)
		{
			switch($a)
			{
				case "FirstNames":
					$first_name = $b;
					break;				
				case "LastName":
					$last_name = $b;
					break;
				case "RatePlan":
					$rate_plan = $b;
					break;
				case "Arrival":
					$arrival = $b;
					break;
				case "Departure":
					$departure = $b;
					break;
			}
		}
	}

	if(strtoupper($last_name) == strtoupper($lname))
	{
		debugTextLogger("Last Name : $last_name");
		debugTextLogger("Rate Plan : $rate_plan");
		debugTextLogger("Arrival : $arrival");
		debugTextLogger("Departure : $departure");

		list($arrival_day, $arrival_month, $arrival_year) = explode("/", $arrival);
		list($departure_day, $departure_month, $departure_year) = explode("/", $departure);

		$arrival_year = substr($arrival_year, 0, strrpos($arrival_year, ' '));
		$departure_year = substr($departure_year, 0, strrpos($departure_year, ' '));

		$arrival_time = mktime(0, 0, 0, $arrival_month, $arrival_day, $arrival_year);
		$departure_time = mktime(0, 0, 0,$departure_month, $departure_day,  $departure_year);

		$diff = abs($departure_time  - $arrival_time);

		$years = floor($diff / (365*60*60*24));
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

		$number_of_days = $days;

		debugTextLogger("Number of Days Stay: $number_of_days");
		debugTextLogger("Referer:  $referrer");
		
		$timelimit = $number_of_days."d";
		
		$log_arr = array(
						"remote_addr" => $ip_addr,
						"mac" => $mac,						
						"request_uri" => $referrer,
						"room_no" => $room_no,
						"first_name" => $first_name,
						"last_name" => $last_name,
						"rate_plan" => $rate_plan,
						"arrival" => $arrival,
						"departure" => $departure,
						"status" => "A"
		);
		
		add_hotspot_user($log_arr);
		
		$bytes = convertToBytes($rate_plan);
		$user_list = add_user_to_hotspot(strtolower($last_name),$bytes,$timelimit,$mac);
		$user_list = login_to_hotspot(strtolower($last_name),$mac,$ip_addr);
		header("Location: $referrer"); 
	}
}
else
{
	echo "<h2>ERROR Connecting to API.</h2>";
}

?>