<?php
require_once ('additional_functions.php');
require_once ('mikrotik_functions.php');

date_default_timezone_set('Australia/Sydney');

$hotspot_bytes_total = 0;
$profile = "";

$returned = daily_update_rows();

if(!empty($returned))
{

	$user = list_hotspot_users();
	$active_user = list_hotspot_active_users();	
	
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
		
		$hotspot_active_bytes = 0;
		$hotspot_bytes = 0;
		$total_shaped_usage = 0;
		
		$datediff = strtotime($departure) - time();
		$timelimit = ceil($datediff/(60*60*24));
		
		if($timelimit == 0)
		{
			$timelimit = 1;
		}
		
		//$timelimit = $timelimit * 2;
		
		if($timelimit > 0)
		{
			//$rate_plan = convertToBytes($rate_plan) * 2;
			$rate_plan = convertToBytes($rate_plan);
		
			$db_bytes = $bytes_in + $bytes_out;
			

			if(!empty($active_user))
			{
				foreach($active_user as $num=>$active_arr)
				{
					if(isset($active_arr['mac-address']))
					{
						if($active_arr['mac-address'] == trim($user_name))
						{			
							$hotspot_active_bytes = $active_arr['bytes-in']+$active_arr['bytes-out'];
						}
					}
				}
			}
			
			if(!empty($user))
			{
				foreach($user as $num=>$arr)
				{
					if(isset($arr['mac-address']))
					{
						if($arr['mac-address'] == trim($user_name))
						{	
							if($arr['profile'] != 'shaped')
							{
								$hotspot_bytes = $arr['bytes-in']+$arr['bytes-out'];
								$hotspot_bytes_total = ($hotspot_bytes+$hotspot_active_bytes) - $db_bytes;

									
								if($arr['profile'] == "premium")
								{
									$rate_plan = 500000000000;
								}
								
								if($hotspot_bytes_total < $rate_plan)
								{
									$profile = $arr['profile'];
								}
								else
								{
									$is_safe = is_safe_db($user_name);
		
									if($is_safe == false)
									{
										$profile = "shaped";
										$timelimit = $timelimit."d";
									
										$db = mysqli_connect("172.20.184.72","saimas","4UDwLszVLeRVDYuU","hotspot");

										if($db->connect_error)
										{
        									die('Error : ('.$db->connect_errno.')'.$db->connect_error);
										}

										$sql1 = "INSERT INTO hotspot_shaped (hotel_code,room_no,mac,shaped_bytes) SELECT hotel_code , room_no, mac, ".($hotspot_bytes_total)." FROM hotspot_log WHERE mac = '".$user_name."' AND room_no = '".$room_no."' AND hotel_code = '".$hotel_code."'";

										routerLogger("Running Query ".$sql1);

										if($result2 = mysqli_query($db, $sql1))
										{
											routerLogger("Record is added to hotspot_shaped table");
										}
										else
										{
											routerLogger("Record can not be added to hotspot_shaped table");
										}									
									
										routerLogger("REMOVING HOTSPOT ACTIVE USER $user_name");
										$user_list = remove_hotspot_active_user($user_name);
										routerLogger($user_list);
										routerLogger("REMOVING HOTSPOT USER $user_name");
										$user_list = remove_hotspot_user_name($user_name);
										routerLogger($user_list);
										routerLogger("ADDING USER TO HOTSPOT $user_name $rate_plan $timelimit $user_name $profile");
										$user_list = add_user_to_hotspot($user_name,$rate_plan,$timelimit,$user_name,$profile);
										routerLogger($user_list);

										$sql2 = "DELETE FROM hotspot_log WHERE hotel_code = '".$hotel_code."' AND room_no = '".$room_no."' AND mac = '".$user_name."'";

										routerLogger("Running Query ".$sql2);

										if($result2 = mysqli_query($db, $sql2))
										{
											routerLogger("MAC $user_name is removed from hotspot_log table");
										}
										else
										{
											routerLogger("MAC $user_name can not be removed from hotspot_log table");
										}
									}
								}	
							}
							else
							{
								$user_shaped_usage = get_shaped_db($user_name, $hotel_code, $room_no);
								
								if(!empty($user_shaped_usage))
								{					
									$total_shaped_usage = $user_shaped_usage['shaped_bytes'];
								}
								
								$hotspot_bytes = $arr['bytes-in'] + $arr['bytes-out'] + $hotspot_active_bytes;
								$hotspot_bytes_total = $total_shaped_usage + $hotspot_bytes;								
								$profile = "shaped";								
							}
							
							//echo date('d-m-Y H:i:s',time()).", ".$hotel_code.", ".$room_no.", ".$user_name.", ".str_pad($first_name,20).", ".str_pad($last_name,20).", ".$arrival.", ".$departure.", ".$rate_plan.", ".str_pad($hotspot_bytes_total,12).", ".$profile."\r\n";
						}
					}
				}
			}
		}		
		
		echo date('d-m-Y H:i:s',time()).", ".$hotel_code.", ".str_pad($room_no,5).", ".$user_name.", ".str_pad($first_name,20).", ".str_pad($last_name,20).", ".$arrival.", ".$departure.", ".str_pad($rate_plan,12).", ".str_pad($hotspot_bytes_total,12).", ".$profile."\r\n";
	}
}
?>
