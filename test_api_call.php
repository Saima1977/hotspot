<?php
	require_once ('additional_functions.php');

	$Web_Service_URL = MERITON_API_URL.'/?hotel='.$hotel_code.'&room='.$room_no;
	
	$result = postCurl($Web_Service_URL);
	
	echo "RESULT : ".$result;
?>