<?php
require_once("config.php");
require_once ('mikrotik_functions.php');
require_once ('/var/www/hotspot/docroot/additional_functions.php');

date_default_timezone_set('Australia/Sydney');
					
$db = mysqli_connect($MYSQLSVR,$MYSQLUSR,$MYSQLPWD,$MYSQLDBS);
	
if($db->connect_error) 
{
	die('Error : ('.$db->connect_errno.')'.$db->connect_error);
}

$sql = "SELECT * FROM hotspot_remove";


if ($result = mysqli_query($db, $sql))
{
	if (mysqli_num_rows($result) > 0) 
	{
		$stmt .= date('d-m-Y H:i:s').": Removing Accounts Start From Hotspot\r\n";

		// output data of each row
		while($row = mysqli_fetch_assoc($result)) 
		{
			$stmt .= date('d-m-Y H:i:s').": Removing Room No: ".$row['room_no']." from Hotel Code ".$row['hotel_code']." From Hotspot\r\n";
			
			$sql0 = "SELECT * FROM hotspot_log WHERE room_no = '".$row['room_no']."' AND hotel_code = '".$row['hotel_code']."'";
			
			$stmt .= date('d-m-Y H:i:s').": Running Query ".$sql0."\r\n";

			if ($result0 = mysqli_query($db, $sql0))
			{
				if (mysqli_num_rows($result0) > 0) 
				{
					// output data of each row
					while($row0 = mysqli_fetch_assoc($result0)) 
					{	
						$is_safe = is_safe_db($row0['mac']);
		
						if($is_safe == false)
						{				
							//$stmt .= date('d-m-Y H:i:s').": Removing MAC: ".$row0['mac']." From Active Hotspot List\r\n";
							//$user_list = remove_hotspot_active_user($row0['mac']);
							//if($user_list == 0)
							//{
							//	$stmt .= date('d-m-Y H:i:s').": MAC: ".$row0['mac']." Cannot be removed from Active Hotspot\r\n";
							//}
							$stmt .= date('d-m-Y H:i:s').": Removing MAC: ".$row0['mac']." From Hotspot List\r\n";
							$user_list = remove_hotspot_user_name($row0['mac']);
							if($user_list == 0)
							{
								$stmt .= date('d-m-Y H:i:s').": MAC: ".$row0['mac']." Cannot be removed from Hotspot\r\n";
							}						
						}
					}
				}
			}
			

			$sql1 = "DELETE FROM hotspot_remove WHERE hotel_code = '".$row['hotel_code']."' AND room_no = '".$row['room_no']."'";
			
			$stmt .= date('d-m-Y H:i:s').": Running Query ".$sql1."\r\n";
									
			if($result1 = mysqli_query($db, $sql1))
			{
				$stmt .= date('d-m-Y H:i:s').": Record is removed from queue\r\n";
			}
			else
			{
				$stmt .= date('d-m-Y H:i:s').": Record can not be removed from queue\r\n";
			}

			$sql2 = "DELETE FROM hotspot_log WHERE hotel_code = '".$row['hotel_code']."' AND room_no = '".$row['room_no']."'";
			
			$stmt .= date('d-m-Y H:i:s').": Running Query ".$sql2."\r\n";
									
			if($result2 = mysqli_query($db, $sql2))
			{
				$stmt .= date('d-m-Y H:i:s').": Record is removed from Database\r\n";
			}
			else
			{
				$stmt .= date('d-m-Y H:i:s').": Record can not be removed from Database\r\n";
			}
			
		}
	}
}

if(trim($stmt) != "")
{
	$logLine = "\n".date("Y-m-d  H:i:s")."\tDEBUG\t".print_r($stmt, true)."\n\r";
	echo $logLine;
}
?>
