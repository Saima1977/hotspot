<?php
require_once ('additional_functions.php');
require_once ('mikrotik_functions.php');

date_default_timezone_set('Australia/Sydney');


$hotel_no = "";
$room_checked = false;
$name_checked = false;
$rateplan = "";
$last_name = "";
$rate_plan = "";
$timelimit = "";
$room_no = "9999";

$returned = daily_update_rooms();

if(!empty($returned))
{
	foreach($returned as $ret_arr=>$arr)
	{
		$room_checked = false;
		$name_checked = false;

		if(is_array($arr))
		{
			$ip_addr = $arr['remote_addr'];
			$room_no = $arr['room_no'];
			$hotel_no = $arr['hotel_code'];
			$mac_address = $arr['mac'];
			$departure = "";
			
			if(($room_no != "9999")&&($room_no != "9998"))
			{			
				$Web_Service_URL = MERITON_API_URL.'/?hotel='.$hotel_no.'&room='.$room_no;
				$result = postCurl($Web_Service_URL);				
				$xml=simplexml_load_string($result) or die("Error: Cannot create object");
				print_r($xml);			

				foreach($arr as $key=>$ret)
				{	
					if($key === 'room_no')
					{
						$room_no = $ret;
						
						$rate_plan = $xml->Guest->RatePlan;
						$last_name = $xml->Guest->LastName;
						
						if((trim($last_name)!="") && (trim($rate_plan)!=""))
						{
							$room_checked = true;
						}
												
					}
				
					if($key === 'last_name')
					{
						$lname = $ret;
						$last_name = $xml->Guest->LastName;
						
						if($room_checked == true)
						{
							if(strtoupper($last_name) == strtoupper($lname))
							{
								$name_checked = true;
							}
						}	
					}
					
					if($key === 'departure')
					{
						$departure = date('Y-m-d',strtotime($ret));
						echo "\n(".date("d-m-Y",time()).") DEPARTURE DATE FROM DB: ".$departure."\n";
						$depart_api = $xml->Guest->Departure;
						if(!empty($depart_api))
						{
							$depart_api = date_create_from_format('d/m/Y H:i', $depart_api);
							$depart_api = date_format($depart_api, 'Y-m-d');
						}
						echo "\n(".date("d-m-Y",time()).") DEPARTURE DATE FROM API: ".$depart_api."\n";
					}
				
					if($key === 'mac')
					{
						$mac_add = $ret;
					}
				}
			}
			else
			{
				$room_checked = true;
				$name_checked = true;
			}
		
			if($room_checked != true)
			{
				echo "\n(".date("d-m-Y",time()).") ROOM NOT OCCUPIED: ".$room_no."\n";
			}
		
			if($name_checked != true)
			{
				echo "\n(".date("d-m-Y",time()).") NAME NOT CHECKED: ".$last_name." AGAINST ".$lname."\n";
			}

			$room_detail = get_room($room_no,$hotel_no);
		
			if($name_checked != true)
			{
				echo "\n(".date("d-m-Y",time()).") ROOM DETAIL WRONG: ".$room_no."\n";
			
				foreach($room_detail as $room=>$detail)
				{	
					echo "\n(".date("d-m-Y",time()).") DEPARTURE DATE: ".date('Y-m-d',strtotime($detail['departure']))."\n";
					echo "\n(".date("d-m-Y",time()).") DATE TODAY: ".date('Y-m-d',strtotime('today'))."\n";
					
						
					echo "\nREMOVING MAC ADDRESS FROM ACTIVE USERS/USERS/DB: ".$detail['mac']."\n";
					$user_list = remove_hotspot_active_user($detail['mac']);
					echo "\n\r".$user_list."\n\r";
					$user_list = remove_hotspot_user_name($detail['mac']);
					echo "\n\r".$user_list."\n\r";
					$test_str = delete_mac_user_db($detail['mac']);				
				}			
			}
			else
			if(($room_checked == true) && ($name_checked == true))
			{
				echo "\n(".date("d-m-Y",time()).") ROOM CHECKED: ".$room_no."\n";
				
				echo "\n(".date("d-m-Y",time()).") CHECKING DEPARTURE DATE.....\n";
			
				if($departure != $depart_api)
				{
					echo "\n(".date("d-m-Y",time()).") DATES NOT MATCHED: ".$departure." AND ".$depart_api."\n";
					echo "\nREMOVING MAC ADDRESS FROM ACTIVE USERS/USERS/DB: ".$arr['mac']."\n";
				
					$user_list = remove_hotspot_active_user($arr['mac']);
					echo "\n\r".$user_list."\n\r";
					$user_list = remove_hotspot_user_name($arr['mac']);
					echo "\n\r".$user_list."\n\r";
					$test_str = delete_mac_user_db($arr['mac']);					
				}
				else
				{
					echo "\n(".date("d-m-Y",time()).") DATES MATCHED: ".$departure." AND ".$depart_api."\n";
				}
			}
		}
	}
	
	$remove_old_user =  delete_old_user_db();
	$archive_str = archive_user_db();
	$remove_old_premium = delete_old_premium_db();
}
?>