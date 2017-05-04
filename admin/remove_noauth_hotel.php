<?php
require_once("config.php");

function debugLogger($stmt)
{
	$dir = "/var/www/hotspot/log/";
	$dir_path = $dir."HS_ADMIN_REMOVE_NOAUTH_".date('dmY',time()).".log";
	
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
	debugLogger("Remove Hotel from No Authentication Table ....... ");
	
	$db = mysqli_connect($MYSQLSVR,$MYSQLUSR,$MYSQLPWD,$MYSQLDBS);
	
	if($db->connect_error) 
	{
		echo "<script>console.log('".$db->connect_error."');</script>";
		debugLogger($db->connect_error);
		die('Error : ('.$db->connect_errno.')'.$db->connect_error);
	}
	
	if(trim($_GET['hotel_code']) != "")
	{
		debugLogger("HOTEL CODE");
		debugLogger($_GET['hotel_code']);
		
		debugLogger("RUNNING QUERY FOR NO AUTHENTICATION TABLE");
		$del_query = "DELETE FROM hotspot_hotel_noauth WHERE hotel_code = '".$_GET['hotel_code']."'";
		debugLogger($del_query);
		$del_res = mysqli_query($db, $del_query) or die(mysqli_error($db));
	}
}

header('Location: add_hotel_noauth.php');
?>