<?php
$room_no = $_POST['room_no'];
$hotel_no = $_POST['hotel_no'];
$lname = $_POST['last_name'];

$first_name = "";
$last_name = "";
$rate_plan = "";
$arrival = "";
$departure = "";
 

$url = "https://ggws.meriton.com.au";
$Web_Service_URL = $url.'/?hotel='.$hotel_no.'&room='.$room_no;
	
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

// The cert path is relative to this file
curl_setopt($ch, CURLOPT_CAINFO, $crt); // Set the location of the CA-bundle
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

if(($result = curl_exec($ch)) === FALSE) 
{
	$data['result'] = 0;
	die('cURL error: '.curl_error($ch)."<br />");
} 

curl_close($ch);

if($result != FALSE)
{
	$data = array();
	
	$xml=simplexml_load_string($result) or die("Error: Cannot create object");
 
	foreach($xml as $key=>$val)
	{
		foreach($val as $a=>$b)
		{
			switch($a)
			{
				case "FirstNames":
					$first_name = $b;
					break;
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
	
	if(count($xml->children() > 0))
	{
		$data['result'] = 1;
		$data['first_name'] = $first_name;
		$data['last_name'] = $last_name;
		$data['rate_plan'] = $rate_plan;
		$data['arrival'] = $arrival;
		$data['departure'] = $departure;
		$data['hotel_code'] = $hotel_no;
		$data['room_no'] = $room_no;
	}
	else
	{
		$data['result'] = 0;
	}	

	echo json_encode($data);
}
else
{
	echo json_encode("API ERROR");
}
?>