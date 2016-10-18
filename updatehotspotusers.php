<?php
require_once ('additional_functions.php');
require_once ('mikrotik_functions.php');

$hotel_no = "";

$user_list = list_hotspot_users();

foreach($user_list as $user_arr=>$arr)
{
	foreach($arr as $key => $val)
	{
		if($key == 'user')
		{	
			$l_name = ucfirst($val);
		}
		if($key == 'address')
		{
			$ip = $val;
		}
		if($key == 'session-time-left')
		{
			$time_left = $val;
		}
		if($key == 'mac-address')
		{
			$mac_address = $val;
		}
	}
	
	$arr = explode("d", $time_left, 2);
	$time_left_days = $arr[0];
	
	$returned = hotspot_rows($l_name,$mac_address);
	
	foreach($returned as $ret_arr=>$arr)
	{
		foreach($arr as $key=>$ret)
		{
			if($key == 'room_no')
			{
				$room_no = $ret;
			}
		}
	}
	
	$Web_Service_URL = MERITON_API_URL.'/?hotel='.$hotel_no.'&room='.$room_no;

	$result = postCurl($Web_Service_URL);
	
	if($result != FALSE)
	{
		$xml=simplexml_load_string($result) or die("Error: Cannot create object");
 
		foreach($xml as $key=>$val)
		{
			foreach($val as $a=>$b)
			{
				switch($a)
				{
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
	}

	$today_day = date('d',time());
	$today_month = date('m',time());
	$today_year = date('Y',time());

	list($departure_day, $departure_month, $departure_year) = explode("/", $departure);
		
	$departure_year = substr($departure_year, 0, strrpos($departure_year, ' '));

	$today_time = mktime(0, 0, 0, $today_month, $today_day, $today_year);
	$departure_time = mktime(0, 0, 0, $departure_month, $departure_day, $departure_year);
		
	$diff = abs($departure_time  - $today_time);
	
	if($diff > 0)
	{
		if($l_name == $last_name)
		{
			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			$days = floor(($diff - $years * 365*60*60*24 - $months * 30*60*60*24)/ (60*60*24));

			$number_of_days = $days;
	
			if($time_left_days < $number_of_days)
			{
				$remaining_days = $number_of_days - $time_left_days;
			
				$bytes = convertToBytes($remaining_days."GB");
			
				$timelimit = $number_of_days."d";
				$user_list = remove_hotspot_user_name(strtolower($last_name));
				$user_list = add_user_to_hotspot(strtolower($last_name),$bytes,$timelimit,$mac_address);
				$user_list = login_to_hotspot(strtolower($last_name),$mac_address,$ip);
			}
		}
	}
	else
	{
		$user_list = remove_hotspot_user_name(strtolower($l_name));
	}
}

?>