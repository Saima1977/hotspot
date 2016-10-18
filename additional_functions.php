<?php
require_once 'config.php';

function random_password($limit=8)
{
    //Configuration for password generation
    $passAlphabet = 'abcdefghikmnpqrstuvxyz23456789';
    $passLength = $limit;

    //Password generation procedure
    $passAlphabetLimit = strlen($passAlphabet)-1;
    $pass = '';
    for ($i = 0; $i < $passLength; ++$i) {
        $pass .= $passAlphabet[mt_rand(0, $passAlphabetLimit)];
    }
	
	return $pass;
}

function convertToBytes($from){
    $number=substr($from,0,-2);
    switch(strtoupper(substr($from,-2))){
        case "KB":
            return $number*1024;
        case "MB":
            return $number*pow(1024,2);
        case "GB":
            return $number*pow(1024,3);
        case "TB":
            return $number*pow(1024,4);
        case "PB":
            return $number*pow(1024,5);
        default:
            return $from;
    }
}

function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824)
    {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    }
    elseif ($bytes >= 1048576)
    {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    }
    elseif ($bytes >= 1024)
    {
        $bytes = number_format($bytes / 1024, 2) . ' kB';
    }
    elseif ($bytes > 1)
    {
        $bytes = $bytes . ' bytes';
    }
    elseif ($bytes == 1)
    {
        $bytes = $bytes . ' byte';
    }
    else
    {
        $bytes = '0 bytes';
    }

    return $bytes;
}

function debugTextLogger($logContent) 
{
	if (stripos(PHP_OS, 'win') === 0) 
	{
		$dir = WIN_LOG_DIR;
		$dir_path = WIN_LOG_DIR.APP_PREFIX."".date('dmY',time()).LOG_EXT;
	} 
	elseif (stripos(PHP_OS, 'linux') === 0) 
	{
		$dir = LOG_DIR;
		$dir_path = LOG_DIR.APP_PREFIX."".date('dmY',time()).LOG_EXT;
	}
	else
	{
		$dir = LOG_DIR;
		$dir_path = LOG_DIR.APP_PREFIX."".date('dmY',time()).LOG_EXT;
	}
	
	if (!file_exists($dir) ) 
	{
		$oldmask = umask(0);  // helpful when used in linux server  
		mkdir($dir, 0744);
	}	
	
    $logLine = "\n".date("Y-m-d  H:i:s")."\tDEBUG\t".print_r($logContent, true)."\n\r";

    file_put_contents($dir_path, $logLine, FILE_APPEND);
}

function log_hotspot_user($params=array())
{
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOSTSPOT_DB_PW,HOTSPOT_DB);

	if (!$link) 
	{
		echo "Error: Unable to connect to MySQL." . PHP_EOL;
		echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
		echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}

	$sql='INSERT INTO '.HOTSPOT_TABLE.'(`'.implode('`, `',array_keys($params)).'`) VALUES ("' . implode('", "', $params) . '")';
	
	mysqli_query($link, $sql);
	
	mysqli_close($link);
}

function disable_hotspot_user($username)
{
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOSTSPOT_DB_PW,HOTSPOT_DB);

	if (!$link) 
	{
		echo "Error: Unable to connect to MySQL." . PHP_EOL;
		echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
		echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}

	$sql='UPDATE '.HOTSPOT_TABLE.' SET status = "D" WHERE last_name = '.ucfirst($username);
	
	mysqli_query($link, $sql);
	
	mysqli_close($link);
}


function hotspot_rows($last_name, $mac)
{
	$parameters = array();
	
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOSTSPOT_DB_PW,HOTSPOT_DB);

	if (!$link) 
	{
		echo "Error: Unable to connect to MySQL." . PHP_EOL;
		echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
		echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}

    $sql = "SELECT * FROM ".HOTSPOT_TABLE." WHERE last_name = '".$last_name."' AND mac = '".$mac."' AND status = 'A'";
	
    if ($result = mysqli_query($link, $sql))
	{
		if (mysqli_num_rows($result) > 0) 
		{
			// output data of each row
			while($row = mysqli_fetch_assoc($result)) 
			{
				$parameters[] = $row;
			}
		}
	}
	mysqli_close($link);
	
	return $parameters;
}


function postCurl($url) 
{
    $ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_0); 
	curl_setopt($ch, CURLOPT_HEADER, 0); // Don’t return the header, just the html
	curl_setopt($ch, CURLOPT_CAINFO, SSL_CERT_PATH); // Set the location of the CA-bundle
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

	if (($result = curl_exec($ch)) === FALSE) 
	{
		die('cURL error: '.curl_error($ch)."<br />");
	}
	
	curl_close($ch);
	
    return $result;
}

?>