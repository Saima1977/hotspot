<?php
	require_once("config.php");
	date_default_timezone_set('Australia/Sydney');
	
	$logContent = $_POST['log_line'];

	$dir = "/var/www/hotspot/log/";
	$dir_path = $dir."HS_ADMIN_CHANGE_ROOM_".date('dmY',time()).".log";
	
	if (!file_exists($dir) ) 
	{
		$oldmask = umask(0);  // helpful when used in linux server  
		mkdir($dir, 0744);
	}	
	
	$data['dir_path'] = $dir_path;
	
    $logLine = "\n".date("Y-m-d  H:i:s")."\tDEBUG\t".print_r($logContent, true)."\n\r";

    $success = file_put_contents($dir_path, $logLine, FILE_APPEND);
	
	
	if($success === FALSE)
	{
		$data['error'] = 1;
	}
	else
	{
		$data['error'] = 0;
	}
	
	echo json_encode($data);
?>