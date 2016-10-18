<?php
require_once 'include/routeros_api.class.php';
require_once 'config.php';

function list_hotspot_users()
{
	$API = new RouterosAPI();
	$API->debug = false;
	
	if ($API->connect(HOTSPOT, HS_USER, HS_PASSWORD)) 
	{
		$API->write('/ip/hotspot/user/print',true);
		$READ = $API->read(true);
   		$API->disconnect();
		return $READ;
	}
}

function list_hotspot_active_users()
{
	$API = new RouterosAPI();
	$API->debug = false;
	
	if ($API->connect(HOTSPOT, HS_USER, HS_PASSWORD)) 
	{
		$API->write('/ip/hotspot/active/print',true);
		$READ = $API->read(true);
   		$API->disconnect();
		return $READ;
	}
}

function list_user_manager_users()
{
	$API =  new RouterosAPI();
	$API->debug = false;

	if ($API->connect(HOTSPOT, HS_USER, HS_PASSWORD)) 
	{
		$API->write('/tool/user-manager/user/getall');
		$READ = $API->read(false);

		$API->disconnect();
		return $READ;
	}
}

function find_hotspot_active_user($username)
{
	$user_list = list_hotspot_active_users();
	$flag = false;
	$user_arr= array();
	foreach($user_list as $user=>$list)
	{
		$key = array_search($username,$list);	
		
		if($key != NULL)
		{
			foreach($list as $key=>$value)
			{
				$user_arr[$key] = $value;
			}
			$flag = true;
		}
		
		if($flag == true)
		{
			break;
		}
	}
	return $user_arr;	
}


function find_hotspot_user($username)
{
	$user_list = list_hotspot_users();
	$flag = false;
	$user_arr= array();
	foreach($user_list as $user=>$list)
	{
		$key = array_search($username,$list);	
		
		if($key != NULL)
		{
			foreach($list as $key=>$value)
			{
				$user_arr[$key] = $value;
			}
			$flag = true;
		}
		
		if($flag == true)
		{
			break;
		}
	}
	return $user_arr;	
}

function limit_hotspot_user($ip)
{
	set_time_limit(100);
	$API = new RouterosAPI();
	$API->debug = true;

	if ($API->connect(HOTSPOT, HS_USER, HS_PASSWORD)) 
	{      
		$READ = $API->comm('/queue/simple/add', array(
												"target"=>$ip,
												"max-limit"=>"256KB/256KB"
											));

		$API->disconnect();
		
		return $READ;	
	}	
}


function find_hotspot_mac_user($mac)
{
	$user_list = list_hotspot_users();	
	$flag = false;
	$user_arr= array();
	foreach($user_list as $user=>$list)
	{
		$key = array_search($mac,$list);	
		
		if($key != NULL)
		{
			foreach($list as $key=>$value)
			{
				$user_arr[$key] = $value;
			}
			$flag = true;
		}
		
		if($flag == true)
		{
			break;
		}
	}
	return $user_arr;	
}

function disable_hotspot_mac_user($mac)
{
	set_time_limit(100);
	$API = new RouterosAPI();
	$API->debug = true;

	if ($API->connect(HOTSPOT, HS_USER, HS_PASSWORD)) 
	{      
		$user_arr = find_hotspot_mac_user($mac);
		$userid = $user_arr['.id'];
		
		$API->write('/ip/hotspot/user/set', false);
		$API->write('=.id='.$userid, false);
		$API->write('=disabled=yes');
		$READ = $API->read(false);
		
		$API->disconnect();
		
		return $READ;	
	}
}

function enable_hotspot_mac_user($mac)
{
	set_time_limit(100);
	$API = new RouterosAPI();
	$API->debug = true;

	if ($API->connect(HOTSPOT, HS_USER, HS_PASSWORD)) 
	{      
		$user_arr = find_hotspot_mac_user($mac);
		$userid = $user_arr['.id'];
		
		$API->write('/ip/hotspot/user/set', false);
		$API->write('=.id='.$userid, false);
		$API->write('=disabled=no');
		$READ = $API->read(false);
		
		$API->disconnect();
		
		return $READ;	
	}
}

function disable_hotspot_user_name($username)
{
	set_time_limit(100);
	$API = new RouterosAPI();
	$API->debug = true;

	if ($API->connect(HOTSPOT, HS_USER, HS_PASSWORD)) 
	{      
		$user_arr = find_hotspot_user($username);
		$userid = $user_arr['.id'];
		
		$API->write('/ip/hotspot/user/set', false);
		$API->write('=.id='.$userid, false);
		$API->write('=disabled=yes');
		$READ = $API->read(false);		
		
		$API->disconnect();
		
		return $READ;	
	}
}

function enable_hotspot_user_name($username)
{
	set_time_limit(100);
	$API = new RouterosAPI();
	$API->debug = false;

	if ($API->connect(HOTSPOT, HS_USER, HS_PASSWORD)) 
	{      
		$user_arr = find_hotspot_user($username);
		$userid = $user_arr['.id'];
		
		$API->write('/ip/hotspot/user/set', false);
		$API->write('=.id='.$userid, false);
		$API->write('=disabled=no');
		$READ = $API->read(false);
		
		$API->disconnect();
		
		return $READ;	
	}
}

function remove_hotspot_user_name($username)
{
	set_time_limit(0);
	$API = new RouterosAPI();
	$API->debug = false;

	if ($API->connect(HOTSPOT, HS_USER, HS_PASSWORD)) 
	{      
		$user_arr = find_hotspot_user($username);
		$userid = $user_arr['.id'];
		
		$READ = $API->comm('/ip/hotspot/user/remove', array(
												".id"=>$userid,
											));
	
		$API->disconnect();		
		return $READ;	
	}
}

function remove_hotspot_active_user($username)
{
	set_time_limit(0);
	$API = new RouterosAPI();
	$API->debug = false;

	if ($API->connect(HOTSPOT, HS_USER, HS_PASSWORD)) 
	{      
		$user_arr = find_hotspot_active_user($username);
		$userid = $user_arr['.id'];

		$API->write("/ip/hotspot/active/remove", false);
		$API->write("=.id=$userid");
		$READ = $API->read(false);		
		$API->disconnect();
		return $READ;	
	}
}

function login_to_hotspot($user,$mac,$ipaddr)
{
	set_time_limit(100);
	$API = new RouterosAPI();
	$API->debug = false;

	if ($API->connect(HOTSPOT, HS_USER, HS_PASSWORD)) 
	{      
		$READ = $API->comm('/ip/hotspot/active/login',array(
												"user"     => $user,
												"mac-address" => $mac,
												"ip"  => $ipaddr,
											));

		$API->disconnect();
		
		return $READ;	
	}
}

function add_user_to_hotspot($user,$bytes,$uptime,$mac,$passwd = NULL)
{
	set_time_limit(0);
	$API = new RouterosAPI();
	$API->debug = false;;

	if($passwd == NULL)
	{
		$args = array(
					"name" => $user,
					"limit-bytes-total" => $bytes,
					"limit-uptime" => $uptime,
					"mac-address" => $mac
				);
	}
	else
	{
		$args = array(
					"name" => $user,
					"limit-bytes-total" => $bytes,
					"limit-uptime" => $uptime,
					"mac-address" => $mac,
					"password" => $passwd
				);		
	}
	
	if ($API->connect(HOTSPOT, HS_USER, HS_PASSWORD)) 
	{
		$READ = $API->comm("/ip/hotspot/user/add", $args);
		
		$API->disconnect();
		
		return $READ;
	}
}

?>