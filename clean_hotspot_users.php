<?php
require_once ('additional_functions.php');
require_once ('mikrotik_functions.php');
date_default_timezone_set('Australia/Sydney');

$today = date('d-m-Y',time());

$list = list_hotspot_users();

$counter = 1;

echo "-------------------------------------".$today."-----------------------------------------------\n";

foreach($list as $usr => $val)
{
	$rate_plan = "";
  	$user_name = "";
    	$bytes_in = "";
    	$bytes_out = "";
    	$departure = "";
    	$room_no = "";
    	$hotel_code = "";
    	$first_name = "";
    	$last_name = "";

	$match_flag = false;
		
	$returned = daily_update_rows();
	//echo $today."| HOTSPOT username: ".$val['name']."\n";
	echo $today."| ".$val['name']." | ";

	foreach($returned as $ret_arr=>$arr)
	{
		$rate_plan = $arr['rate_plan'];
		$user_name = $arr['mac'];
		$bytes_in = $arr['bytes_in'];
		$bytes_out = $arr['bytes_out'];
		$departure = $arr['departure'];
		$room_no = $arr['room_no'];
		$hotel_code = $arr['hotel_code'];
		$first_name = $arr['first_name'];
		$last_name = $arr['last_name'];	

		if(($val['name'] == $user_name)||($val['name'] == "default-trial"))
		{
			$match_flag = true;
		}
	}

    	//echo $today."| MATCH: ";
    	echo ($match_flag == true)?"   MATCH   ":"NO MATCH   ";
    	//echo "\n";
	
	if($match_flag === false)
	{
			//echo $today."| ($counter)"." DELETE USER : ".$val['name']."\n";
			echo " | DELETE USER\n";
			$counter++;
				
			$user_list = remove_hotspot_active_user($val['name']);
			/*print_r($user_list);
			echo "-------------------------------------------------\n";*/
			$user_list = remove_hotspot_user_name($val['name']);
			/*print_r($user_list);
			echo "-------------------------------------------------\n";*/
	}
	else
	{
		echo " | KEEP USER\n";
	}
}

echo "-------------------------------------TOTAL REMOVED: ".($counter-1)."-----------------------------------------------\n\n\n";
?>
