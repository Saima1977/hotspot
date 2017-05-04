<?php
require_once ('additional_functions.php');
require_once ('mikrotik_functions.php');
$lname = $_POST['lname'];
$room_no = $_POST['room_no'];
$mac = $_POST['mac'];
$ip_addr = $_POST['ipaddr'];
$referrer = $_POST['referrer'];
$hotel_no = "";

if(isset($_POST['room_no']))
{
	$url = "https://ggws.meriton.com.au";
	//$Web_Service_URL = $url.'/?room='.$room_no;
	$Web_Service_URL = $url.'/?hotel='.$hotel_no.'&room='.$room_no;

	debugLogger("$room_no Starting cURL call to Meriton API ".$Web_Service_URL);
	
	// Init the cURL session
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $Web_Service_URL);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_0); 
	curl_setopt($ch, CURLOPT_HEADER, 0); // Don’t return the header, just the html
	
	if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') 
	{
		$crt = substr(__FILE__, 0, strrpos( __FILE__, '\\'))."\crt\cacert.pem"; // WIN
	}
	else
	{
		$crt = str_replace('\\', '/', substr(__FILE__, 0, strrpos( __FILE__, '/')))."/crt/cacert.pem"; // *NIX
	}

	debugLogger("$room_no SSL Certificate found at ".$crt);

	// The cert path is relative to this file
	curl_setopt($ch, CURLOPT_CAINFO, $crt); // Set the location of the CA-bundle
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

	if (($result = curl_exec($ch)) === FALSE) 
	{
		debugLogger("$room_no cURL error: ".curl_error($ch));
		die('cURL error: '.curl_error($ch)."<br />");
	} 
	else 
	{
		debugLogger("$room_no Success... ");
		debugLogger($room_no." ".$result);
	}
	curl_close($ch);
}
debugLogger($result);

if($result != FALSE)
{
	$xml=simplexml_load_string($result) or die("Error: Cannot create object");
 
	foreach($xml as $key=>$val)
	{
		foreach($val as $a=>$b)
		{
			switch($a)
			{
				case "LastName":
					$last_name = $b;
					break;
				case "RatePlan":
					$rate_plan = $b;
					break;
				case "Arrival":
					$arrival = $b;
					break;
				case "Departure":
					$departure = $b;
					break;
			}
		}
	}

	if(strtoupper($last_name) == strtoupper($lname))
	{
		echo "Last Name : $last_name</br>";
		echo "Rate Plan : $rate_plan</br>";
		echo "Arrival 	: $arrival</br>";
		echo "Departure : $departure</br>";

		list($arrival_day, $arrival_month, $arrival_year) = explode("/", $arrival);
		list($departure_day, $departure_month, $departure_year) = explode("/", $departure);

		$arrival_year = substr($arrival_year, 0, strrpos($arrival_year, ' '));
		$departure_year = substr($departure_year, 0, strrpos($departure_year, ' '));

		$arrival_time = mktime(0, 0, 0, $arrival_month, $arrival_day, $arrival_year);
		$departure_time = mktime(0, 0, 0,$departure_month, $departure_day,  $departure_year);

		$diff = abs($departure_time  - $arrival_time);

		$years = floor($diff / (365*60*60*24));
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

		$number_of_days = $days;

		echo "Number of Days Stay: $number_of_days</br>";

		$timelimit = $number_of_days."d";

		$bytes = convertToBytes($rate_plan);
		echo "Number of Bytes: ".$bytes."<br/>";
		
		echo "<pre>";
		print_r($user_list);
		echo "</pre>";
	}
}
else
{
	echo "MERITON API DIDN'T WORK!";
}

?>