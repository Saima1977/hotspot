<?php
require_once ('additional_functions.php');
require_once ('mikrotik_functions.php');

date_default_timezone_set('Australia/Sydney');

$hotspot_bytes = 0;


$shaped = daily_shaped_users();
$hotspot_detail = list_hotspot_users();

if(!empty($shaped))
{
	echo "--------------------------------------".date('d-m-Y',time())."-------------------------------------\r\n";
	
	foreach($shaped as $ret_arr=>$arr)
	{
		$user_name = $arr['mac'];
		
		$info = get_user_info($user_name);
		$hotel_code = $info[0]['hotel_code'];
		$room_no = $info[0]['room_no'];
		$rate_plan = $info[0]['rate_plan'];
		$rate_plan = convertToBytes($info[0]['rate_plan']);
		$departure = $info[0]['departure']; 
		
		if(!empty($info))
		{
			$datediff = strtotime($departure) - time();
			$timelimit = ceil($datediff/(60*60*24));
			
			if($timelimit == 0)
			{
				$timelimit = 1;
			}
			//$timelimit = $timelimit."d";
									
			if(isset($hotspot_detail))
			{
				foreach($hotspot_detail as $usr => $val)
				{
					if($val['mac-address'] == trim($user_name))
					{
						if($val['profile'] == 'shaped')
						{	
							$premium = get_user_premium($hotel_code, $room_no);
					
							if($premium === true)
							{
								$profile = 'premium';
								//$timelimit = $timelimit * 2;
							}
							else
							{
								$profile = 'standard';
								//$timelimit = $timelimit * 2;
							}

							$is_safe = is_safe_db($user_name);
		
							if($is_safe == false)
							{
								$timelimit = $timelimit."d";
								
								routerLogger("REMOVING HOTSPOT ACTIVE USER $user_name");
								$user_list = remove_hotspot_active_user($user_name);
								routerLogger($user_list);
								routerLogger("REMOVING HOTSPOT USER $user_name");
								$user_list = remove_hotspot_user_name($user_name);
								routerLogger($user_list);
								routerLogger("ADDING USER TO HOTSPOT $user_name $rate_plan $timelimit $user_name $profile");
								$user_list = add_user_to_hotspot($user_name,$rate_plan,$timelimit,$user_name,$profile);	
								routerLogger($user_list);
						
								$db = mysqli_connect("172.20.184.72","saimas","4UDwLszVLeRVDYuU","hotspot");

								if($db->connect_error)
								{
									die('Error : ('.$db->connect_errno.')'.$db->connect_error);
								}

								$sql1 = "DELETE FROM hotspot_log WHERE hotel_code = '".$hotel_code."' AND room_no = '".$room_no."' AND mac = '".$user_name."'";

								routerLogger("Running Query ".$sql1);
						
								if($result1 = mysqli_query($db, $sql1))
								{
									routerLogger("Record is removed from hotspot_log table");
								}
								else
								{
									routerLogger("Record can not be removed from hotspot_log table");
								}
						
								$sql2 = "DELETE FROM hotspot_shaped WHERE hotel_code = '".$hotel_code."' AND room_no = '".$room_no."' AND mac = '".$user_name."'";

								routerLogger("Running Query ".$sql2);
						
								if($result2 = mysqli_query($db, $sql2))
								{
									routerLogger("Record is removed from hotspot_shaped table");
								}
								else
								{
									routerLogger("Record can not be removed from hotspot_shaped table");
								}
								echo date('d-m-Y H:i',time()).", ".$hotel_code.", ".$room_no.", ".$user_name.", ".$val['profile']." ,".$profile."\r\n";						
							}
						}
					}
				}
			}
		}
	}
}
?>