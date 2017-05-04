<?php
require_once ('additional_functions.php');

date_default_timezone_set('Australia/Sydney');
					
$db = mysqli_connect($MYSQLSVR,$MYSQLUSR,$MYSQLPWD,$MYSQLDBS);
	
if($db->connect_error) 
{
	die('Error : ('.$db->connect_errno.')'.$db->connect_error);
}

$sql = "SELECT hotel_code, room_no, mac FROM hotspot_login";


if ($result = mysqli_query($db, $sql))
{
	if (mysqli_num_rows($result) > 0) 
	{
		$stmt .= date('d-m-Y H:i:s').": Removing Login Records Start From Table\r\n";

		// output data of each row
		while($row = mysqli_fetch_assoc($result)) 
		{
			$stmt .= date('d-m-Y H:i:s').": Checking Room No: ".$row['room_no']." from Hotel Code: ".$row['hotel_code']." and Mac: ".$row['mac']."\r\n";
			
			$sql0 = "SELECT * FROM hotspot_log WHERE room_no = '".$row['room_no']."' AND hotel_code = '".$row['hotel_code']."' AND mac = '".$row['mac']."'";
			
			$stmt .= date('d-m-Y H:i:s').": Running Query ".$sql0."\r\n";

			if ($result0 = mysqli_query($db, $sql0))
			{
				if(mysqli_num_rows($result0) <= 0) 
				{
					// output data of each row
					$sql1 = "DELETE FROM hotspot_login WHERE hotel_code = '".$row['hotel_code']."' AND room_no = '".$row['room_no']."' AND mac = '".$row['mac']."'";
			
					$stmt .= date('d-m-Y H:i:s').": Running Query ".$sql1."\r\n";
									
					/*if($result1 = mysqli_query($db, $sql1))
					{
						$stmt .= date('d-m-Y H:i:s').": Record is removed from queue\r\n";
					}
					else
					{
						$stmt .= date('d-m-Y H:i:s').": Record can not be removed from queue\r\n";
					}*/
				}
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
