<?php
require_once 'include/routeros_api.class.php';
require_once 'config.php';

$last_name = "Bang";

$API = new RouterosAPI();
$API->debug = true;

///ip hotspot user add name="$user" limit-bytes-total=1073741824 limit-uptime=1d server=server1 profile=uprof1 mac-address="$[/ip hotspot active get [find user=$"hotspot_user"] mac-address]"

if ($API->connect(HOTSPOT, HS_USER, HS_PASSWORD)) 
{
   /*$API->comm("/ip/hotspot/user/add", array(
      "name"     => $last_name,
      "limit-bytes-total" => 1073741824,
      "limit-uptime" => "6d",
      "mac-address"  => "5A:6D:83:75:A4:3E",
   ));*/
	$API->write('/ip/hotspot/user/print',true);
    $READ = $API->read(true);
   
   $API->disconnect();
}

?>