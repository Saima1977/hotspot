<?php
error_reporting(0);
require_once("config.php");
require_once ('/var/www/hotspot/docroot/mikrotik_functions.php');
require_once ('/var/www/hotspot/docroot/additional_functions.php');
date_default_timezone_set('Australia/Sydney');
							
$db = mysqli_connect($MYSQLSVR,$MYSQLUSR,$MYSQLPWD,$MYSQLDBS);
	
if($db->connect_error) 
{
	die('Error : ('.$db->connect_errno.')'.$db->connect_error);
}

$room = ms_escape_string(isset($_GET['room_no'])?$_GET['room_no']:"");
$hotel = ms_escape_string(isset($_GET['hotel_no'])?$_GET['hotel_no']:"");
$last = ms_escape_string(isset($_GET['last_name'])?$_GET['last_name']:"");

$data['room'] = $room;
$data['hotel'] = $hotel;
$data['last_name'] = $last;


/*
$sql = "REPLACE INTO hotspot_remove(room_no, hotel_code) VALUES('".$room."', '".$hotel."')";
$stmt = date('d-m-Y H:i:s').": Request to remove Room No: ".$room." from Hotel Code ".$hotel." From Hotspot\r\n";
$stmt .= date('d-m-Y H:i:s').": Running Query ".$sql."\r\n";

if ($result = mysqli_query($db, $sql)) */
if((trim($room) != "")&&(trim($hotel) != "")&&(trim($last) != ""))
{
	$stmt .= date('d-m-Y H:i:s').": Room ".$room." from Hotel Code ".$hotel." is to be removed from Hotspot\r\n";

	//$sql0 = "SELECT * FROM hotspot_log WHERE room_no = '".$room."' AND hotel_code = '".$hotel."' AND UPPER(last_name) = '".strtoupper($last)."' AND departure >= CURDATE() AND arrival = (SELECT MAX(arrival) FROM hotspot_log WHERE UPPER(last_name) = '".strtoupper($last)."' AND room_no = '".$room."' AND hotel_code = '".$hotel."' AND departure > CURDATE())";
	$sql0 = "SELECT * FROM hotspot_log WHERE room_no = '".$room."' AND hotel_code = '".$hotel."' AND UPPER(last_name) = '".strtoupper($last)."' AND arrival = (SELECT MAX(arrival) FROM hotspot_log WHERE UPPER(last_name) = '".strtoupper($last)."' AND room_no = '".$room."' AND hotel_code = '".$hotel."')";

	$stmt .= date('d-m-Y H:i:s').": Request to remove Room No: ".$room." from Hotel Code ".$hotel." residing Last Name: ".$last."\r\n";
	
	$stmt .= date('d-m-Y H:i:s').": Running Query ".$sql0."\r\n";

	if ($result0 = mysqli_query($db, $sql0))
	{
		if (mysqli_num_rows($result0) > 0) 
		{
			// output data of each row
			$counter = 1;
		
			while($row0 = mysqli_fetch_assoc($result0)) 
			{
				//$sql1 = "UPDATE hotspot_log SET status = 'D', active = 0 WHERE mac = '".$row0['mac']."'"; 
				$sql1 = "DELETE FROM hotspot_log WHERE mac = '".$row0['mac']."' AND room_no = '".$room."'";
			
				$stmt .= date('d-m-Y H:i:s').": Running query to remove devices in room: ".$sql1."\r\n";

				if(mysqli_query($db, $sql1))
				{
					$index = strtoupper($row0['last_name'])."-".$counter;
					$data[$index] =  $row0['mac'];
					$mac_address = $row0['mac'];			
				} 
				else 
				{
					$error = "ERROR: Could not execute $sql1. ".mysqli_error($db);
					$stmt .= date('d-m-Y H:i:s').": ".$error."\r\n";
					$data['error'] = mysqli_error($db);
				}
				
				$user_list = find_hotspot_active_user($row0['mac']);
				
				if(!empty($user_list))
				{
					$stmt .= date('d-m-Y H:i:s').": Removing MAC address ".$row0['mac']." from ACTIVE HOTSPOT list.....\r\n";
				
					$user_list = remove_hotspot_active_user($row0['mac']);
					
					if($user_list == 0)
					{
						$stmt .= date('d-m-Y H:i:s').": Removing MAC address ".$row0['mac']." from ACTIVE HOTSPOT list was NOT successful\r\n";
					}
					
					if(!empty($user_list))
					{
						$stmt .= date('d-m-Y H:i:s').": SERIALIZED ARRAY ".serialize($user_list)."\r\n";
						$stmt .= date('d-m-Y H:i:s').": Removing MAC address ".$row0['mac']." from ACTIVE HOTSPOT list was NOT successful\r\n";
					}
				}
				
				$user_list = find_hotspot_user($row0['mac']);
				
				if(!empty($user_list))
				{
					$stmt .= date('d-m-Y H:i:s').": Removing MAC address ".$row0['mac']." from HOTSPOT list.....\r\n";
				
					$user_list = remove_hotspot_user_name($row0['mac']);
					
					if($user_list == 0)
					{
						$stmt .= date('d-m-Y H:i:s').": Removing MAC address ".$row0['mac']." from HOTSPOT list was NOT successful\r\n";
					}
					
					if(!empty($user_list))
					{
						$stmt .= date('d-m-Y H:i:s').": SERIALIZED ARRAY ".serialize($user_list)."\r\n";
						$stmt .= date('d-m-Y H:i:s').": Removing MAC address ".$row0['mac']." from HOTSPOT list was NOT successful\r\n";
					}					
				}
				
				$counter++;
			}
		}
		else
		{
			$data['error'] = "No Records found.";
			$stmt .= date('d-m-Y H:i:s').": ".$data['error']."\r\n";
		}
	}
	else
	{
		echo "ERROR: Could not execute $sql. ".mysqli_error($db);
		$data['error'] = mysqli_error($db);	
		$stmt .= date('d-m-Y H:i:s').": ".$data['error']."\r\n";
	}
}
else
{
	$stmt .= date('d-m-Y H:i:s').": Incomplete fields to process\r\n";
}

$data['log'] = $stmt;

echo json_encode($data);
?>
