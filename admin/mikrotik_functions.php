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
	else
	{
		return 0;
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
	else
	{
		return 0;
	}	
}

function find_hotspot_active_user($username)
{
	$API = new RouterosAPI();
	$API->debug = false;	
	
	if ($API->connect(HOTSPOT, HS_USER, HS_PASSWORD)) 
	{   	
		$user_id = $API->comm('/ip/hotspot/active/print', array(
												"?user"=>$username
												));	
												
		$API->disconnect();
		return $user_id;	
	}
	else
	{
		return 0;
	}	
}

function find_hotspot_active_user_ip($ip)
{
	$API = new RouterosAPI();
	$API->debug = false;	
	
	if ($API->connect(HOTSPOT, HS_USER, HS_PASSWORD)) 
	{   	
		$user_id = $API->comm('/ip/hotspot/active/print', array(
												"?address"=>$ip
												));	
												
		$API->disconnect();
		return $user_id;	
	}
	else
	{
		return 0;
	}	
}

function find_hotspot_user($username)
{
	$API = new RouterosAPI();
	$API->debug = false;	

	if ($API->connect(HOTSPOT, HS_USER, HS_PASSWORD)) 
	{  
		$READ =  $API->comm('/ip/hotspot/user/print', array(
            "?name" => "$username"
            ));
		$API->disconnect();
		return $READ;	
	}
	else
	{
		return 0;
	}	
}

function add_limit_hotspot_user($user_name,$bytes)
{
	$API = new RouterosAPI();
	$API->debug = false;

	if ($API->connect(HOTSPOT, HS_USER, HS_PASSWORD)) 
	{      
		$READ = $API->comm('/ip/hotspot/user/add', array(
												"limit-bytes-total"=>$bytes,
												"mac-address"=>$user_name,
												"name"=>$user_name,		
											));
		$API->disconnect();
		
		return $READ;	
	}	
	else
	{
		return 0;
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

function remove_hotspot_user_name($username)
{
	set_time_limit(0);
	$API = new RouterosAPI();
	$API->debug = false;

	if ($API->connect(HOTSPOT, HS_USER, HS_PASSWORD)) 
	{      
		$user_id = $API->comm('/ip/hotspot/user/print', array(
												".proplist" => ".id",
												"?name"=>$username
												));									

		if(!empty($user_id[0]['.id']))
		{												
			$READ = $API->comm('/ip/hotspot/user/remove', array(".id"=>$user_id[0][".id"]));
		}
		else
		{
			$READ = 0;
		}
		
		$API->disconnect();		
		return $READ;
	}
	else
	{
		return 0;
	}
}

function remove_hotspot_active_user($username)
{
	set_time_limit(0);
	$API = new RouterosAPI();
	$API->debug = false;

	if ($API->connect(HOTSPOT, HS_USER, HS_PASSWORD)) 
	{      
		$user_id = $API->comm('/ip/hotspot/active/print', array(
												".proplist" => ".id",
												"?user"=>$username
												));	

		if(!empty($user_id[0]['.id']))
		{										
			$READ = $API->comm('/ip/hotspot/active/remove', array(".id"=>$user_id[0]['.id']));
		}
		else
		{
			$READ = 0;
		}
		
		$API->disconnect();
		return $READ;	
	}
	else
	{
		return 0;
	}
}

function login_to_hotspot($user,$mac,$ipaddr)
{
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
	else
	{
		return 0;
	}
}

function add_user_to_hotspot($user,$bytes,$uptime,$mac,$profile = NULL)
{
	$API = new RouterosAPI();
	$API->debug = false;

	if($profile == NULL)
	{
		$args = array(
					"name" => $user,
					//"limit-bytes-total" => $bytes,
					"limit-uptime" => $uptime,
					"mac-address" => $mac
				);
	}
	else
	{
		$args = array(
					"name" => $user,
					//"limit-bytes-total" => $bytes,
					"limit-uptime" => $uptime,
					"mac-address" => $mac,
					"profile" => $profile
				);		
	}
	
	if ($API->connect(HOTSPOT, HS_USER, HS_PASSWORD)) 
	{
		$READ = $API->comm("/ip/hotspot/user/add", $args);		
		$API->disconnect();
		return $READ;
	}
	else
	{
		return 0;
	}
}

function list_queue_hotspot()
{
	$API = new RouterosAPI();
	$API->debug = false;	

	if ($API->connect(HOTSPOT, HS_USER, HS_PASSWORD)) 
	{	
		$API->write('/queue/simple/print',false);
		$API->write('=stats=');
		$READ = $API->read();	
		
		$API->disconnect();
		
		return $READ;	
	}
	else
	{
		return 0;
	}	
}

function add_queue_hotspot($target)
{
	$API = new RouterosAPI();
	$API->debug = false;	

	$maxlimit = "5M/1M";
	$comment = "Queue Added for the customers.";
	
	if ($API->connect(HOTSPOT, HS_USER, HS_PASSWORD)) 
	{	
		$API->write("/queue/simple/add",false);
        $API->write('=target='.$target,false);   // IP
        $API->write('=max-limit='.$maxlimit,false);   //   2M/2M   [TX/RX]
        $API->write('=comment='.$comment,true);         // comentario
        $READ = $API->read(false);
		
		$API->disconnect();
		
		return $READ;	
	}
	else
	{
		return 0;
	}	
}

function list_profile_hotspot()
{
	$API = new RouterosAPI();
	$API->debug = false;	

	$maxlimit = "5M/1M";
	
	if ($API->connect(HOTSPOT, HS_USER, HS_PASSWORD)) 
	{	
		$READ = $API->comm('/ip/hotspot/user/profile/getall', false);
        
		
		$API->disconnect();
		
		return $READ;	
	}
	else
	{
		return 0;
	}	
}

function find_profile_hotspot($mac)
{
	$API = new RouterosAPI();
	$API->debug = false;	
	
	if ($API->connect(HOTSPOT, HS_USER, HS_PASSWORD)) 
	{	
		$READ = $API->comm('/ip/hotspot/user/profile/print', array(
												"?name"=>$mac
												));
        		
		$API->disconnect();
		
		return $READ;	
	}
	else
	{
		return 0;
	}	
}

function add_profile_hotspot($name)
{
	$API = new RouterosAPI();
	$API->debug = false;	

	$maxlimit = "1M/5M";
	$args = array(
				"name" => $name,
				"rate-limit" => $maxlimit
	);
	
	if ($API->connect(HOTSPOT, HS_USER, HS_PASSWORD)) 
	{	
		$READ = $API->comm('/ip/hotspot/user/profile/add', $args);
		$API->disconnect();
		return $READ;	
	}
	else
	{
		return 0;
	}	
}

function remove_profile_hotspot($id)
{
	$API = new RouterosAPI();
	$API->debug = false;	
	
	if ($API->connect(HOTSPOT, HS_USER, HS_PASSWORD)) 
	{	
		$READ = $API->comm('/ip/hotspot/user/profile/remove', array(".id"=>$id));        		
		$API->disconnect();
		return $READ;	
	}
	else
	{
		return 0;
	}	
}

function remove_hotspot_host($mac)
{
	$API = new RouterosAPI();
	$API->debug = false;	
	
	if ($API->connect(HOTSPOT, HS_USER, HS_PASSWORD)) 
	{   	
		$user_id = $API->comm('/ip/hotspot/host/print', array(
												"?mac-address"=>$mac
												));	
		
		if(!empty($user_id[0]['.id']))
		{										
			$READ = $API->comm('/ip/hotspot/host/remove', array(".id"=>$user_id[0]['.id']));
		}
		else
		{
			$READ = 0;
		}												
																								
		$API->disconnect();
	}
	else
	{
		$READ = 0;
	}

	return $READ;	
}

?>