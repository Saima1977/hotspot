<?php
require_once ('mikrotik_functions.php');
require_once ('additional_functions.php');
//$user_list = limit_hotspot_user('192.168.0.252');
//$user_list = list_hotspot_active_users();

$mac = "5A:5D:83:75:A4:4E";
//$bytes = 2147483648;
$bytes = convertToBytes("500GB");
$timelimit = "365d";
$uptime = "365d";
$ip = "192.168.0.252";

//$user_list = disconnect_hotspot_user($mac);
//$user_list = remove_hotspot_active_user("54:27:58:18:E3:8D");

//$user_list = remove_hotspot_user_name("A0:32:99:AB:37:ED");
//$user_list = find_hotspot_user("54:27:58:18:E3:8D");
//$user_list = add_user_to_hotspot("A0:32:99:AB:37:ED",$bytes,$uptime,"54:27:58:18:E3:8D","premium");
//$user_list = find_hotspot_active_user("D8:FC:93:30:A2:DC");

//echo "<pre>";
//print_r($user_list);
//echo "</pre>";
//$user_list = login_to_hotspot("A0:32:99:AB:37:ED","A0:32:99:AB:37:ED","10.26.100.98");

//$user_list = find_hotspot_user("50:c8:e5:90:7f:58");
//$user_list = remove_hotspot_active_user("34:68:95:62:66:CF");
//$user_list = remove_hotspot_user_name("34:68:95:62:66:CF");
//$user_list = list_hotspot_active_users();

//$user_list = list_hotspot_users();
//$user_list = remove_hotspot_user_name("00:EE:BD:AD:0A:94");
//$user_list = find_hotspot_active_user("54:27:58:18:E3:8D");
//$user_list = find_profile_hotspot("5A:5D:83:75:A4:4E");
//$user_list = limit_hotspot_user("kailing-5A:5D:83:75:A4:4E");
//$user_list = login_to_hotspot("00:00:00:00:00:00","5A:5D:83:75:A4:4E","192.168.0.252");
//$user_list = add_limit_hotspot_user("5A:5D:83:75:A4:4E","5000000");
//$user_list = setup_hotspot();
//$user_list = list_queue_hotspot();
//$user_list = add_queue_hotspot("192.168.0.243");
//$user_list = list_profile_hotspot();
//$user_list = add_profile_hotspot($mac);
//$user_list = remove_profile_hotspot("*2");
//$user_list = get_usage_db("5A:5D:83:75:A4:4E");
//$user_list =  remove_hotspot_host("70:28:8B:E1:32:AF");

	$API = new RouterosAPI();
	$API->debug = false;	
	
	if ($API->connect(HOTSPOT, HS_USER, HS_PASSWORD)) 
	{   	
		$user_list = $API->comm('/ip/hotspot/active/print', array(
												"count-only" => "",
												"?server"=>"SYDMAS"
												));	
												
		$API->disconnect();
	}


echo "<pre>";
print_r($user_list);
echo "</pre>";

?>
