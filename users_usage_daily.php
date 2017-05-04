<?php
require_once ('additional_functions.php');
require_once ('mikrotik_functions.php');

date_default_timezone_set('Australia/Sydney');

$hotspot_bytes = 0;
$hotspot_bytes_total = 0;
$profile = "";

$returned = daily_update_rows();

if(!empty($returned))
{
	foreach($returned as $ret_arr=>$arr)
	{
		$rate_plan = $arr['rate_plan'];
		$room_no = $arr['room_no'];
		$user_name = $arr['mac'];
		$bytes_in = $arr['bytes_in'];
		$bytes_out = $arr['bytes_out'];
		$arrival = $arr['arrival'];
		$departure = $arr['departure'];
		$first_name = $arr['first_name'];
		$last_name = $arr['last_name'];
		$hotel_code = $arr['hotel_code'];
		
		$datediff = strtotime($departure) - time();
		$timelimit = ceil($datediff/(60*60*24));
		
		if($timelimit > 0)
		{
			$rate_plan = convertToBytes($rate_plan);
		
			$db_bytes = $bytes_in+$bytes_out;

			$hotspot_info = find_hotspot_active_user($user_name);
		
			if(isset($hotspot_info))
			{
				foreach($hotspot_info as $key => $arr)
				{
					$hotspot_bytes = $arr['bytes-in']+$arr['bytes-out'];
				}
			}
			else
			{
				$hotspot_bytes = 0;
			}
						
			$hotspot_detail = find_hotspot_user($user_name);
				
			if(isset($hotspot_detail))
			{
				foreach($hotspot_detail as $usr => $val)
				{
					echo "USER PROFILE : ".$val['profile']."\r\n";
					if($val['profile'] != 'shaped')
					{
						echo "PROFILE CHECKED FOR BYTES\r\n";
						
						$hotspot_bytes_in = $val['bytes-in'];
						$hotspot_bytes_out = $val['bytes-out'];
						
						$hotspot_bytes_total = $hotspot_bytes;
					
						if($hotspot_bytes_total > $rate_plan)
						{
							echo "USERNAME: $user_name\r\n";
							echo "$hotspot_bytes_total > $rate_plan\r\n";
						
							$profile = "shaped";
						
							echo "PROFILE CHANGED TO $profile\r\n";
							//$user_list = remove_hotspot_active_user($user_name);
							//$user_list = remove_hotspot_user_name($user_name);
							//$user_list = add_user_to_hotspot($user_name,$rate_plan,$timelimit,$user_name,$profile);	
						}
					}
					else
					{
						$profile = $val['profile'];
					}
				}
			}
		}
		else
		{
			echo "NO MORE STAY!";
		}
		
		echo $hotel_code.", ".$room_no.", ".$first_name.", ".$last_name.", ".$arrival.", ".$departure.", ".$rate_plan.", ".$hotspot_bytes_total.", ".$profile."\r\n";		
	}
}
?>