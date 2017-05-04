<?php
error_reporting(0);

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
            return $number*1000;
        case "MB":
            return $number*pow(1000,2);
        case "GB":
            return $number*pow(1000,3);
        case "TB":
            return $number*pow(1000,4);
        case "PB":
            return $number*pow(1000,5);
        default:
            return $from;
    }
}

function formatSizeUnits($bytes)
{
    if ($bytes >= 1000000000)
    {
        $bytes = number_format($bytes / 1000000000, 2).' GB';
    }
    elseif ($bytes >= 1000000)
    {
        $bytes = number_format($bytes / 1000000, 2).' MB';
    }
    elseif ($bytes >= 1000)
    {
        $bytes = number_format($bytes / 1000, 2).' kB';
    }
    elseif ($bytes > 1)
    {
        $bytes = $bytes.' bytes';
    }
    elseif ($bytes == 1)
    {
        $bytes = $bytes.' byte';
    }
    else
    {
        $bytes = '0 bytes';
    }

    return $bytes;
}

function subtract_time_from_current($date_str)
{
	date_default_timezone_set('Australia/Sydney');
	$arr = array();
	preg_match_all('!\d+!', $date_str, $matches);
	preg_match_all('![a-zA-Z]+!', $date_str, $alphas);

	foreach($alphas as $index => $code)
	{
		foreach($code as $key=>$val)
		{
			$arr[$val] = $matches[$index][$key];
		}
	}
	$date = new DateTime();

	foreach($arr as $key=>$val)
	{
        if($key == 'w')
        {
                date_sub($date,date_interval_create_from_date_string($val." weeks"));
        }
        if($key == 'd')
        {
                date_sub($date,date_interval_create_from_date_string($val." days"));
        }
        if($key == 'h')
        {
                date_sub($date,date_interval_create_from_date_string($val." hours"));
        }
        if($key == 'm')
        {
                date_sub($date,date_interval_create_from_date_string($val." minutes"));
        }
        if($key == 's')
        {
                date_sub($date,date_interval_create_from_date_string($val." seconds"));
        }
	}
	
	return $date->format('Y-m-d h:i:s');	
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
	
    $logLine = "\n".date("Y-m-d  H:i:s")." DEBUG ".print_r($logContent, true)."\n\r";

    file_put_contents($dir_path, $logLine, FILE_APPEND);
}


function routerLogger($logContent)
{
        if (stripos(PHP_OS, 'win') === 0)
        {
                $dir = WIN_LOG_DIR;
                $dir_path = WIN_LOG_DIR.HOTSPOT_PREFIX."".date('dmY',time()).LOG_EXT;
        }
        elseif (stripos(PHP_OS, 'linux') === 0)
        {
                $dir = LOG_DIR;
                $dir_path = LOG_DIR.HOTSPOT_PREFIX."".date('dmY',time()).LOG_EXT;
        }
        else
        {
                $dir = LOG_DIR;
                $dir_path = LOG_DIR.HOTSPOT_PREFIX."".date('dmY',time()).LOG_EXT;
        }

        if (!file_exists($dir) )
        {
                $oldmask = umask(0);  // helpful when used in linux server
                mkdir($dir, 0744);
        }

    $logLine = "\n".date("Y-m-d  H:i:s")."DEBUG ".$logContent."\n\r";

    file_put_contents($dir_path, $logLine, FILE_APPEND);
}

function log_hotspot_user($params=array())
{
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);
	
	if (!$link) 
	{
		echo "Error: Unable to connect to MySQL.".PHP_EOL;
		echo "Debugging errno: ".mysqli_connect_errno().PHP_EOL;
		echo "Debugging error: ".mysqli_connect_error().PHP_EOL;
		exit;
	}
	
	$sql='INSERT INTO '.HOTSPOT_TABLE.'(`'.implode('`, `',array_keys($params)).'`) VALUES ("'.implode('", "', $params).'")';	
	mysqli_query($link, $sql);
		
	mysqli_close($link);
}

function log_connect_user($params=array())
{
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);
	
	if (!$link) 
	{
		echo "Error: Unable to connect to MySQL.".PHP_EOL;
		echo "Debugging errno: ".mysqli_connect_errno().PHP_EOL;
		echo "Debugging error: ".mysqli_connect_error().PHP_EOL;
		exit;
	}
	
	$sql='INSERT INTO hotspot_login(`'.implode('`, `',array_keys($params)).'`) VALUES ("'.implode('", "', $params).'")';	
	mysqli_query($link, $sql);
		
	mysqli_close($link);
}

function disconnect_hotspot_user($mac_add)
{
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);

	if (!$link) 
	{
		echo "Error: Unable to connect to MySQL.".PHP_EOL;
		echo "Debugging errno: ".mysqli_connect_errno().PHP_EOL;
		echo "Debugging error: ".mysqli_connect_error().PHP_EOL;
		exit;
	}

	$sql='UPDATE '.HOTSPOT_TABLE.' SET status = "D" WHERE UPPER(mac) = "'.strtoupper($mac_add).'" AND active = 1';
	
	mysqli_query($link, $sql);
	
	mysqli_close($link);
}

function daily_update_rows()
{
	$parameters = array();
	
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);

	//$str_sql = "SELECT * FROM ".HOTSPOT_TABLE." WHERE departure > CURDATE() AND active = 1 AND room_no != '9999' AND room_no != '9998'";
	$str_sql = "SELECT * FROM ".HOTSPOT_TABLE." WHERE departure > CURDATE()";
	
	// Execute the query.
 
	if($query = mysqli_query($link, $str_sql))
	{
		while($result = mysqli_fetch_array($query))
		{
			$parameters[] = $result;
		}
	}
	
	mysqli_close($link);
	
	return $parameters;		
}

function daily_update_rooms()
{
	$parameters = array();
	
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);

	$str_sql = "SELECT * FROM ".HOTSPOT_TABLE." WHERE departure > CURDATE() GROUP BY room_no";
 
	// Execute the query.
 
	if($query = mysqli_query($link, $str_sql))
	{
		while($result = mysqli_fetch_array($query))
		{
			$parameters[] = $result;
		}
	}
	
	mysqli_close($link);
	
	return $parameters;		
}

function daily_shaped_users()
{
	$parameters = array();
	
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);

	$str_sql = "SELECT * FROM hotspot_shaped";
 
	// Execute the query.
 
	if($query = mysqli_query($link, $str_sql))
	{
		while($result = mysqli_fetch_array($query))
		{
			$parameters[] = $result;
		}
	}
	
	mysqli_close($link);
	
	return $parameters;		
}


function get_room($room_no,$hotel_code)
{
	$parameters = array();
	
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);

	$str_sql = "SELECT * FROM ".HOTSPOT_TABLE." WHERE departure >= CURDATE() AND active = 1 AND room_no = '".$room_no."' AND UPPER(hotel_code) = '".strtoupper($hotel_code)."'";
 
	// Execute the query.
 
	if($query = mysqli_query($link, $str_sql))
	{
		while($result = mysqli_fetch_array($query))
		{
			$parameters[] = $result;
		}
	}
	
	mysqli_close($link);
	
	return $parameters;		
}

function get_record($mac)
{
	$parameters = array();
	
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);

	$str_sql = "SELECT * FROM ".HOTSPOT_TABLE." WHERE UPPER(mac) = '".strtoupper($mac)."'";
 
	// Execute the query.
 
	if($query = mysqli_query($link, $str_sql))
	{
		while($result = mysqli_fetch_array($query))
		{
			$parameters[] = $result;
		}
	}
	
	mysqli_close($link);
	
	return $parameters;		
}


function get_room_all($room_no,$hotel_code)
{
	$parameters = array();
	
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);

	$str_sql = "SELECT * FROM ".HOTSPOT_TABLE." WHERE UPPER(room_no) = '".strtoupper($room_no)."' AND UPPER(hotel_code) = '".strtoupper($hotel_code)."'";
 
	// Execute the query.
 
	if($query = mysqli_query($link, $str_sql))
	{
		while($result = mysqli_fetch_array($query))
		{
			$parameters[] = $result;
		}
	}
	
	mysqli_close($link);
	
	return $parameters;		
}

function get_shaped_all()
{
	$parameters = array();
	
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);

	$str_sql = "SELECT * FROM hotspot_shaped";
 
	// Execute the query.
 
	if($query = mysqli_query($link, $str_sql))
	{
		while($result = mysqli_fetch_array($query))
		{
			$parameters[] = $result;
		}
	}
	
	mysqli_close($link);
	
	return $parameters;		
}

function get_shaped_user($hotel, $room, $mac)
{	
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);

	$str_sql = "SELECT * FROM hotspot_shaped WHERE UPPER(hotel_code) = '".strtoupper($hotel)."' AND UPPER(room_no) = '".strtoupper($room)."' and mac = '".$mac."'";
 
	// Execute the query.
	if($query = mysqli_query($link, $str_sql))
	{
		if(mysqli_num_rows($query) > 0) 
		{
			$reply = true;
		}
		else
		{
			$reply = false;
		}
	}
	mysqli_close($link);
	
	return $reply;		
}


function get_user_db($hotel, $room, $mac)
{	
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);

	$str_sql = "SELECT * FROM hotspot_log WHERE UPPER(hotel_code) = '".strtoupper($hotel)."' AND UPPER(room_no) = '".strtoupper($room)."' and mac = '".$mac."'";
 
	// Execute the query.
	if($query = mysqli_query($link, $str_sql))
	{
		if(mysqli_num_rows($query) > 0) 
		{
			$reply = true;
		}
		else
		{
			$reply = false;
		}
	}
	mysqli_close($link);
	
	return $reply;		
}

function get_user_info($mac)
{	
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);

	$str_sql = "SELECT * FROM hotspot_log WHERE UPPER(mac) = '".strtoupper($mac)."' ORDER BY log_date ASC LIMIT 1";
 
		// Execute the query.
 
	if($query = mysqli_query($link, $str_sql))
	{
		while($result = mysqli_fetch_array($query))
		{
			$parameters[] = $result;
		}
	}
	mysqli_close($link);
	
	return $parameters;		
}

function get_user_premium($hotel, $room)
{	
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);

	$str_sql = "SELECT * FROM hotspot_premium WHERE UPPER(hotel_code) = '".strtoupper($hotel)."' AND UPPER(room_no) = '".strtoupper($room)."'";
 
	// Execute the query.
	if($query = mysqli_query($link, $str_sql))
	{
		if(mysqli_num_rows($query) > 0) 
		{
			$premium = true;
		}
		else
		{
			$premium = false;
		}
	}
	mysqli_close($link);
	
	return $premium;		
}

function get_usage_db($mac)
{	
	$parameters = array();
	
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);

	$str_sql = "SELECT * FROM ".HOTSPOT_TABLE." WHERE UPPER(mac) = '".strtoupper($mac)."' AND active = 1";
 
	// Execute the query.
 
	if($query = mysqli_query($link, $str_sql))
	{
		while($result = mysqli_fetch_array($query))
		{
			$parameters = $result;
		}
	}
	
	mysqli_close($link);
	
	return $parameters;		
}

function get_shaped_db($mac, $hotel_code, $room_no)
{	
	$parameters = array();
	
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);

	//$str_sql = "SELECT * FROM hotspot_shaped WHERE UPPER(mac) = '".strtoupper($mac)."' AND UPPER(room_no) = '".strtoupper($room_no)."' AND UPPER(hotel_code) = '".strtoupper($hotel_code)."'";
	$str_sql = "SELECT * FROM hotspot_shaped WHERE UPPER(mac) = '".strtoupper($mac)."' GROUP BY mac";
 
	// Execute the query.
 
	if($query = mysqli_query($link, $str_sql))
	{
		while($result = mysqli_fetch_array($query))
		{
			$parameters = $result;
		}
	}
	
	mysqli_close($link);
	
	return $parameters;		
}

function get_safe_db($mac)
{	
	$parameters = array();
	
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);

	$str_sql = "SELECT * FROM hotspot_safe WHERE UPPER(mac) = '".strtoupper($mac)."'";
 
	// Execute the query.
 
	if($query = mysqli_query($link, $str_sql))
	{
		while($result = mysqli_fetch_array($query))
		{
			$parameters = $result;
		}
	}
	
	mysqli_close($link);
	
	return $parameters;
}

function is_safe_db($mac)
{	
	$is_safe = false;;
	
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);

	$str_sql = "SELECT * FROM hotspot_safe WHERE UPPER(mac) = '".strtoupper($mac)."'";
 
	// Execute the query.
 
	if($query = mysqli_query($link, $str_sql))
	{
		if(mysqli_num_rows($query) > 0)
		{
			$is_safe = true;
		}
	}
	
	mysqli_close($link);
	
	return $is_safe;
}

function get_device_db($mac)
{	
	$parameters = array();
	
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);

	$str_sql = "SELECT * FROM hotspot_device WHERE UPPER(mac) = '".strtoupper($mac)."'";
 
	// Execute the query.
 
	if($query = mysqli_query($link, $str_sql))
	{
		while($result = mysqli_fetch_array($query))
		{
			$parameters = $result;
		}
	}
	
	mysqli_close($link);
	
	return $parameters;
}

function is_device_db($mac)
{	
	$is_device = false;;
	
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);

	$str_sql = "SELECT * FROM hotspot_device WHERE UPPER(mac) = '".strtoupper($mac)."'";
 
	// Execute the query.
 
	if($query = mysqli_query($link, $str_sql))
	{
		if(mysqli_num_rows($query) > 0)
		{
			$is_device = true;
		}
	}
	
	mysqli_close($link);
	
	return $is_device;
}


//function update_usage_db($bytes_in, $bytes_out, $id)
function update_usage_db($bytes_in, $bytes_out, $mac)
{
	$parameters = array();
	
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);

	//$str_sql = "UPDATE ".HOTSPOT_TABLE." SET bytes_in = ".$bytes_in.", bytes_out = ".$bytes_out." WHERE id = '".$id."' AND active = 1";
	$str_sql = "UPDATE ".HOTSPOT_TABLE." SET bytes_in = ".$bytes_in.", bytes_out = ".$bytes_out." WHERE UPPER(mac) = '".strtoupper($mac)."' AND active = 1";
 
	// Execute the query.
 
	mysqli_query($link, $str_sql) or die(mysqli_error($link));
	
	mysqli_close($link);	
}

function delete_user_db($id)
{	
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);

	$str_sql = "UPDATE ".HOTSPOT_TABLE." SET active = 0, status = 'D' WHERE id = '".$id."'";
 
	// Execute the query.
 
	mysqli_query($link, $str_sql);
	
	mysqli_close($link);	
}

function delete_mac_user_db($mac)
{	
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);
	
	$del_sql = "DELETE FROM hotspot_shaped WHERE UPPER(mac) = '".strtoupper($mac)."'";
	
	mysqli_query($link, $del_sql);

	$str_sql = "UPDATE ".HOTSPOT_TABLE." SET active = 0, status = 'D' WHERE UPPER(mac) = '".strtoupper($mac)."'";
 
	// Execute the query.
 
	mysqli_query($link, $str_sql);
	
	mysqli_close($link);	
}

function update_status_db($id)
{
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);

	$str_sql = "UPDATE ".HOTSPOT_TABLE." SET status = 'D' WHERE id = '".$id."' AND active = 1"; 
 
	// Execute the query.
 
	mysqli_query($link, $str_sql);
	
	mysqli_close($link);		
}

function delete_old_user_db()
{
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);

	$str_sql = "UPDATE ".HOTSPOT_TABLE." SET status = 'D', active = 0 WHERE departure < CURDATE()"; 
 
	// Execute the query.
 
	mysqli_query($link, $str_sql);
	
	mysqli_close($link);		
}

function archive_user_db()
{
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);

	// Execute the query.

	$query = mysqli_query($link, "INSERT INTO hotspot_archive (SELECT * FROM ".HOTSPOT_TABLE." WHERE DATE(DATE_ADD(departure, INTERVAL 1 DAY)) < CURDATE())");
    $query = mysqli_query($link, "DELETE FROM ".HOTSPOT_TABLE." WHERE DATE(DATE_ADD(departure, INTERVAL 1 DAY)) < CURDATE()");
    
	if(!$query) 
	{ 
		die(mysqli_error()); 
	}
	
	mysqli_close($link);		
}

function delete_old_premium_db()
{
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);

	// Execute the query.
    $query = mysqli_query($link, "DELETE FROM hotspot_premium WHERE end_date < CURDATE()");
    
	if(!$query) 
	{ 
		die(mysqli_error()); 
	} 
	
	mysqli_close($link);		
}

function delete_old_device_db()
{
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);

	// Execute the query.
    $query = mysqli_query($link, "DELETE FROM hotspot_device WHERE departure < CURDATE()");
    
	if(!$query) 
	{ 
		die(mysqli_error()); 
	} 
	
	mysqli_close($link);		
}

function delete_shaped_user($hotel,$room,$mac)
{
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);

	// Execute the query.
    $query = mysqli_query($link, "DELETE FROM hotspot_shaped WHERE hotel_code = '".$hotel."' AND room_no = '".$room."' AND mac = '".$mac."'");
    
	if(!$query) 
	{ 
		die(mysqli_error()); 
	} 
	
	mysqli_close($link);		
}


function hotspot_rows_ip($ip)
{
	$parameters = array();
	
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);

	if (!$link) 
	{
		echo "Error: Unable to connect to MySQL.".PHP_EOL;
		echo "Debugging errno: ".mysqli_connect_errno().PHP_EOL;
		echo "Debugging error: ".mysqli_connect_error().PHP_EOL;
		exit;
	}

    $sql = "SELECT * FROM ".HOTSPOT_TABLE." WHERE ip_addr = '".$ip."' AND active = 1 GROUP BY mac";
	
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
function hotspot_rows_mac($mac)
{
	$parameters = array();
	
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);

	if (!$link) 
	{
		echo "Error: Unable to connect to MySQL.".PHP_EOL;
		echo "Debugging errno: ".mysqli_connect_errno().PHP_EOL;
		echo "Debugging error: ".mysqli_connect_error().PHP_EOL;
		exit;
	}

    $sql = "SELECT * FROM ".HOTSPOT_TABLE." WHERE UPPER(mac) = '".strtoupper($mac)."' AND status != 'D' AND active = 1 GROUP BY room_no";
	
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
function hotspot_rows_room($room_no)
{
	$parameters = array();
	
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);

	if (!$link) 
	{
		echo "Error: Unable to connect to MySQL.".PHP_EOL;
		echo "Debugging errno: ".mysqli_connect_errno().PHP_EOL;
		echo "Debugging error: ".mysqli_connect_error().PHP_EOL;
		exit;
	}

    $sql = "SELECT * FROM ".HOTSPOT_TABLE." WHERE room_no = '".$room_no."' AND active = 1 GROUP BY room_no";
	
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


function get_hotspot_hotel($ip_addr)
{
	$hotel_code = 0;
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);

	if (!$link) 
	{
		echo "Error: Unable to connect to MySQL.".PHP_EOL;
		echo "Debugging errno: ".mysqli_connect_errno().PHP_EOL;
		echo "Debugging error: ".mysqli_connect_error().PHP_EOL;
		exit;
	}

    $sql = "SELECT * FROM hotspot_hotel_range";
	
    if ($result = mysqli_query($link, $sql))
	{
		if (mysqli_num_rows($result) > 0) 
		{
			// output data of each row
			while($row = mysqli_fetch_assoc($result)) 
			{
				$hotel_code .= $row['lower_range']." - ".$row['upper_range']." - ".$ip_addr."\n";
				if(version_compare($row['lower_range'], $ip_addr) + version_compare($ip_addr, $row['upper_range']) === -2) 
				{
					$hotel_code = $row['hotel_id'];
					break;
				}
			}
		}
	}
	mysqli_close($link);
	
	return $hotel_code;
}

function is_hotspot_hotel($hotel_code)
{
	$link = mysqli_connect(HOTSPOT_DB_HOST,HOTSPOT_DB_USER,HOTSPOT_DB_PW,HOTSPOT_DB);

        if (!$link)
        {
                echo "Error: Unable to connect to MySQL.".PHP_EOL;
                echo "Debugging errno: ".mysqli_connect_errno().PHP_EOL;
                echo "Debugging error: ".mysqli_connect_error().PHP_EOL;
                exit;
        }

    	$sql = "SELECT * FROM hotspot_hotel_range WHERE UPPER(hotel_id) = '".strtoupper($hotel_code)."'";

    	if ($result = mysqli_query($link, $sql))
        {
                if (mysqli_num_rows($result) > 0)
                {
                        // output data of each row
                	
			$response = true;
		}
		else
		{
			$response = false;
		}
        }
	else
	{
		$response = false;
	}
        mysqli_close($link);

        return $response;
}


function postCurl($url) 
{
	$ssl_path = str_replace('\\', '/', substr(__FILE__, 0, strrpos( __FILE__, '/')))."/crt/cacert.pem";
	
    $ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_0); 
	curl_setopt($ch, CURLOPT_HEADER, 0); // Don’t return the header, just the html
	curl_setopt($ch, CURLOPT_CAINFO, $ssl_path); // Set the location of the CA-bundle
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

	if (($result = curl_exec($ch)) === FALSE) 
	{
		die('cURL error: '.curl_error($ch)." - ".$ssl_path."<br />");
	}
	
	curl_close($ch);
	
    return $result;
}

?>
