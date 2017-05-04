<?php
	$room_no = "";
	$hotel_no = "";
	
	//$room_no = (isset($_POST['room_no']))?$_POST['room_no']:"";
	//$hotel_no = (isset($_POST['hotel_no']))?$_POST['hotel_no']:"";
	
	$room_no = $_POST['room_no'];
	$hotel_no = $_POST['hotel_no'];
	
	if(!empty($room_no))
	{
		$data['status'] = "THIS IS SUCCESS";
	}
	else
	{
		$data['status'] = "NO SUCCESS";
	}
	/*
	$lname = "";
	
	if(isset($_POST['last_name']))
	{
		$lname = $_POST['last_name'];
	}
	$hotel_code = "";
	$ip_address = "";

	require_once("config.php");
								
	$db = mysqli_connect($MYSQLSVR,$MYSQLUSR,$MYSQLPWD,$MYSQLDBS);
	
	if($db->connect_error) 
	{
		die('Error : ('.$db->connect_errno.')'.$db->connect_error);
	}
	
	if($lname != "")
	{
		$sql = "SELECT * FROM hotspot_log WHERE last_name = '".$lname."' AND room_no = '".$room_no."' GROUP BY room_no ORDER by id DESC";
	}
	else
	{
		$sql = "SELECT * FROM hotspot_log WHERE room_no = '".$room_no."' GROUP BY room_no ORDER by id DESC";
	}
	
    if ($result = mysqli_query($db, $sql))
	{
		if (mysqli_num_rows($result) > 0) 
		{
			// output data of each row
			while($row = mysqli_fetch_assoc($result)) 
			{
				$ip_address = $row['remote_addr'];
				$mac_address = $row['mac'];
			}
		}
	}
	
	$data['sql'] = $sql;
	
	if($ip_address != "")
	{
		$result= NULL;
		
		$sql = "SELECT * FROM hotspot_hotel_range";
		
		if ($result = mysqli_query($db, $sql))
		{
			if (mysqli_num_rows($result) > 0) 
			{
				// output data of each row
				while($row = mysqli_fetch_assoc($result)) 
				{
					if(version_compare($row['lower_range'], $ip_address) + version_compare($ip_address, $row['upper_range']) === -2) 
					{
						$hotel_code = $row['hotel_id'];
						break;
					}
				}
			}
		}	
	}
	
	if(!empty($hotel_code))
	{
		$data['response'] = 1;
		$data['hotel_code'] = $hotel_code;
	}
	else
	{
		$data['response'] = 0;
		$data['error'] = "Customer hotel code cannot be retrieved.";
	}
	
	$high_range = "";
	$low_range = "";
	
	if($hotel_no == $hotel_code)
	{
		$result= NULL;
		
		$sql = "SELECT * FROM hotspot_hotel_range WHERE hotel_id = '".$hotel_code."'";
		
		if ($result = mysqli_query($db, $sql))
		{
			if (mysqli_num_rows($result) > 0) 
			{
				// output data of each row
				while($row = mysqli_fetch_assoc($result)) 
				{
					$high_range = $row['upper_range'];
					$low_range = $row['lower_range'];
				}
			}
		}
		
		$result = NULL;
		
		//$sql = "UPDATE hotspot_log SET status = 'D', active = 0 WHERE '".$lname."' AND room_no = '".$room_no."' AND INET_ATON(remote_addr) BETWEEN INET_ATON('".$low_range."') AND INET_ATON('".$high_range."')";
		$sql = "SELECT * FROM hotspot_log WHERE '".$lname."' AND room_no = '".$room_no."' AND INET_ATON(remote_addr) BETWEEN INET_ATON('".$low_range."') AND INET_ATON('".$high_range."')";

		if ($result = mysqli_query($db, $sql))		
		//if ($db->query($sql) === TRUE) 
		{
			$data['response'] = 1;
		} 
		else 
		{
			$data['response'] = 0;
			$data['error'] = $db->error;
			echo "Error updating record: ".$db->error;
		}
		
		$db->close();
	}
	else
	{
		$data['response'] = 0;
		$data['error'] = "Hotel code doesn't match record.";
	}
	*/	
		
	echo json_encode($data);
?>