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
$hotel_code = "";

$returned = daily_update_rooms();

if(!empty($returned))
{
	$user = list_hotspot_users();
	$active_user = list_hotspot_active_users();
	
	foreach($returned as $ret_arr=>$arr)
	{
		$hotel_code = $arr['hotel_code'];

		if(is_array($arr))
		{			
			$ip_addr = $arr['remote_addr'];
			$room_no = $arr['room_no'];
			$hotel_no = $arr['hotel_code'];

			echo "(".date("d-m-Y H:i:s",time()).") ROOM NO : ".$room_no."\n";
			
			$room_detail = get_room($room_no,$hotel_no);
		
			foreach($room_detail as $room=>$detail)
			{
				$user_in = "";
				$user_out = "";
				$user_active_in = "";
				$user_active_out = "";
			
				if(trim($detail['mac'])!= "")
				{
					if(!empty($user))
					{
						foreach($user as $num=>$arr)
						{
							if(isset($arr['mac-address']))
							{
								if($arr['mac-address'] == trim($detail['mac']))
								{
									echo "(".date("d-m-Y H:i:s",time()).") MAC ADDRESS FOUND FOR ROOM NO: ".$room_no." HOTSPOT USER: ".$detail['mac']."\n";
									$user_in = $arr['bytes-in'];
									echo "(".date("d-m-Y H:i:s",time()).") USER BYTES IN: ".$user_in."\n";
									$user_out = $arr['bytes-out'];
									echo "(".date("d-m-Y H:i:s",time()).") USER BYTES OUT: ".$user_out."\n";
								}
							}
						}	
					}	
					
					if(trim($user_in) == "")
					{
						$user_in = 0;
						echo "(".date("d-m-Y H:i:s",time()).") USER BYTES IN SET TO: ".$user_in."\n";
					}
				
					if(trim($user_out) == "")
					{
						$user_out = 0;
						echo "(".date("d-m-Y H:i:s",time()).") USER BYTES OUT SET TO: ".$user_out."\n";
					}
					
					if(!empty($active_user))
					{
						foreach($active_user as $active_num=>$active_arr)
						{
							if(isset($active_arr['mac-address']))
							{
								if($active_arr['mac-address'] == trim($detail['mac']))
								{
									echo "(".date("d-m-Y H:i:s",time()).") MAC ADDRESS FOUND FOR ROOM NO: ".$room_no." HOTSPOT ACTIVE USER: ".$detail['mac']."\n";
									$user_active_in = $active_arr['bytes-in'];
									echo "(".date("d-m-Y H:i:s",time()).") USER ACTIVE BYTES IN: ".$user_active_in."\n";
									$user_active_out = $active_arr['bytes-out'];
									echo "(".date("d-m-Y H:i:s",time()).") USER ACTIVE BYTES OUT: ".$user_active_out."\n";
								}
							}
						}	
					}	
					
					if(trim($user_active_in) == "")
					{
						$user_active_in = 0;
						echo "(".date("d-m-Y H:i:s",time()).") USER ACTIVE BYTES IN SET TO: ".$user_active_in."\n";
					}
				
					if(trim($user_active_out) == "")
					{
						$user_active_out = 0;
						echo "(".date("d-m-Y H:i:s",time()).") USER ACTIVE BYTES OUT SET TO: ".$user_active_out."\n";
					}				
				
					
					$bytes_in = $user_in + $user_active_in;

					echo "(".date("d-m-Y H:i:s",time()).") BYTES IN: ".$bytes_in."\n";
					$bytes_out = $user_out + $user_active_out;

					echo "(".date("d-m-Y H:i:s",time()).") BYTES OUT: ".$bytes_out."\n";

					echo "(".date("d-m-Y H:i:s",time()).") MAC: ".$detail['mac']."\n";
			
					$test_str = update_usage_db($bytes_in, $bytes_out, $detail['mac']);
					
					print_r($test_str);
				}
			}
		}
	}
}
?>
