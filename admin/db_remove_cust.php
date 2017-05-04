<?php
require_once("config.php");
require_once ('/var/www/hotspot/docroot/mikrotik_functions.php');
//require_once ('..\mikrotik_functions.php');
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
$data['last'] = $last;

$sql = "SELECT * FROM hotspot_log WHERE room_no = '".$room."' AND hotel_code = '".$hotel."' AND UPPER(last_name) = '".strtoupper($last)."' AND active = 1 AND departure >= CURDATE() AND arrival = (SELECT MAX(arrival) FROM hotspot_log WHERE UPPER(last_name) = '".strtoupper($last)."' AND room_no = '".$room."' AND hotel_code = '".$hotel."' AND departure > CURDATE() AND active = 1)";

$stmt = " Request to remove Room No: ".$room." from Hotel Code ".$hotel." residing Last Name ".$last."\r\n";
$stmt .= date('d-m-Y H:i:s').": Running Query ".$sql."\r\n";

if ($result = mysqli_query($db, $sql))
{
	if (mysqli_num_rows($result) > 0) 
	{
		// output data of each row
		$counter = 1;
		
		while($row = mysqli_fetch_assoc($result)) 
		{
			$sql1 = "UPDATE hotspot_log SET status = 'D', active = 0 WHERE id = ".$row['id'].""; 
			
			$stmt .= date('d-m-Y H:i:s').": Running query on MACS in room ".$sql1."\r\n";

			if(mysqli_query($db, $sql1))
			{
				$index = strtoupper($row['last_name'])."-".$counter;
				$data[$index] =  $row['mac'];
				$mac_address = $row['mac'];
			
			} 
			else 
			{
				$error = "ERROR: Could not execute $sql1. ".mysqli_error($db);
				$stmt .= date('d-m-Y H:i:s').": ".$error."\r\n";
				$data['error'] = mysqli_error($db);
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

$data['log'] = $stmt;

echo json_encode($data);
?>