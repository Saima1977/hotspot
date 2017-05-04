<?php
require_once ('additional_functions.php');
require_once ('mikrotik_functions.php');

date_default_timezone_set('Australia/Sydney');

$hotspot_bytes = 0;

$returned = daily_update_rows();

if(!empty($returned))
{
	echo "--------------------------------------".date('d-m-Y',time())."-------------------------------------\r\n";
	foreach($returned as $ret_arr=>$arr)
	{
		$rate_plan = $arr['rate_plan'];
		$user_name = $arr['mac'];
		$bytes_in = $arr['bytes_in'];
		$bytes_out = $arr['bytes_out'];
		$departure = $arr['departure'];
		$room_no = $arr['room_no'];
		$hotel_code = $arr['hotel_code'];
		$first_namee = $arr['first_name'];
		$last_namee = $arr['last_name'];
		
		$datediff = strtotime($departure) - time();
		$timelimit = ceil($datediff/(60*60*24));
					
		$hotspot_detail = find_hotspot_user($user_name);
				
		if(isset($hotspot_detail))
		{
			foreach($hotspot_detail as $usr => $val)
			{
				if($val['profile'] != 'shaped')
				{
					$premium = get_user_premium($hotel_code, $room_no);
					
					if($premium === true)
					{
						$profile = 'premium';
					}
					else
					{
						$profile = 'standard';
					}

					//$user_list = remove_hotspot_active_user($user_name);
					//$user_list = remove_hotspot_user_name($user_name);
					//$user_list = add_user_to_hotspot($user_name,$rate_plan,$timelimit,$user_name,$profile);	
				}
			}
		}
		echo date('d-m-Y H:i',time()).", ".$hotel_code.", ".$room_no.", ".$user_name.", ".$val['profile']." ,".$profile."\r\n";
	}
}
?>