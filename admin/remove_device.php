<?php
require_once("config.php");
require_once("mikrotik_functions.php");

function debugLogger($stmt)
{
	$dir = "/var/www/hotspot/log/";
	$dir_path = $dir."HS_ADMIN_REMOVE_DEVICE_".date('dmY',time()).".log";
	
	if (!file_exists($dir) ) 
	{
		$oldmask = umask(0);  // helpful when used in linux server  
		mkdir($dir, 0744);
	}
	
	$logLine = "\n".date("Y-m-d  H:i:s")."\tDEBUG\t".print_r($stmt, true)."\n\r";	

	$size = file_put_contents($dir_path, $logLine, FILE_APPEND);

	if ($size == FALSE)
	{
		return "Error writing file.";
	}
	else
	{
		return 1;
	}
}

if($_SERVER['REQUEST_METHOD'] === 'GET')
{
	debugLogger("Remove Device from the Room ....... ");
	
	$db = mysqli_connect($MYSQLSVR,$MYSQLUSR,$MYSQLPWD,$MYSQLDBS);
	
	if($db->connect_error) 
	{
		echo "<script>console.log('".$db->connect_error."');</script>";
		debugLogger($db->connect_error);
		die('Error : ('.$db->connect_errno.')'.$db->connect_error);
	}
	
	if((trim($_GET['hotel_code']) != "") && (trim($_GET['room_no']) != "") && (trim($_GET['mac']) != ""))
	{
		debugLogger("DEVICE MAC");
		debugLogger($_GET['mac']);
		debugLogger("HOTEL CODE");
		debugLogger($_GET['hotel_code']);
		debugLogger("ROOM NUMBER");
		debugLogger($_GET['room_no']);
		
		debugLogger("RUNNING QUERY FOR DEVICE TABLE");
		$del_query = "DELETE FROM hotspot_device WHERE hotel_code = '".$_GET['hotel_code']."' AND room_no = '".$_GET['room_no']."' AND mac = '".$_GET['mac']."'";
		debugLogger($del_query);
		$del_res = mysqli_query($db, $del_query) or die(mysqli_error($db));
		
		debugLogger("RUNNING QUERY FOR HOTSPOT TABLE");
		$del_hs_query = "DELETE FROM hotspot_log WHERE hotel_code = '".$_GET['hotel_code']."' AND room_no = '".$_GET['room_no']."' AND mac = '".trim($_GET['mac'])."'";
		debugLogger($del_hs_query);
		$del_res = mysqli_query($db, $del_hs_query) or die(mysqli_error($db));

		debugLogger("FIND ACTIVE USER IN HOTSPOT .. ");
		
		$find_active_user = find_hotspot_active_user(trim($_GET['mac']));
									
		if(!empty($find_active_user))
		{
			$remove_active_user = remove_hotspot_active_user(trim($_GET['mac']));
			debugLogger("DEVICE REMOVED FROM ACTIVE USER...");
		}

		debugLogger("FIND USER IN HOTSPOT .. ");
		
		$find_user = find_hotspot_user(trim($_GET['mac']));
		
		if(!empty($find_user))
		{
			$remove_user = remove_hotspot_user_name(trim($_GET['mac']));
			debugLogger("DEVICE REMOVED FROM HOTSPOT...");
		}	
	}
}

header( 'Location: add_device_macs.php' ) ;
?>