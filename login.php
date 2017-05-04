<html>
<head>
	<style type="text/css"> 	
				/* * Gridism * A simple, responsive, and handy CSS grid by @cobyism * https://github.com/cobyism/gridism */        
				/* Preserve some sanity */                
				.grid,
				.unit 
				{            
					-webkit-box-sizing: border-box;            
					-moz-box-sizing: border-box;            
					box-sizing: border-box;        
				}        
				/* Set up some rules to govern the grid */                
				.grid 
				{            
					display: block;            
					clear: both;        
				}                
				.grid .unit 
				{            
					float: left;            
					width: 100%;            
					padding: 10px;        
				}        
				/* This ensures the outer gutters are equal to the (doubled) inner gutters. */                
				.grid .unit:first-child 
				{            
					padding-left: 20px;        
				}                
				.grid .unit:last-child 
				{	            
					padding-right: 20px;        
				}        
				/* Nested grids already have padding though, so let’s nuke it */                
				.unit .unit:first-child 
				{            
					padding-left: 0;        
				}                
				.unit .unit:last-child 
				{            
					padding-right: 0;        
				}                
				.unit .grid:first-child > .unit 
				{            
					padding-top: 0;        
				}                
				.unit .grid:last-child > .unit 
				{            
					padding-bottom: 0;        
				}        
				/* Let people nuke the gutters/padding completely in a couple of ways */                
				.no-gutters .unit,        
				.unit.no-gutters 
				{            
					padding: 0 !important;        
				}        
				/* Wrapping at a maximum width is optional */                
				.wrap .grid,        
				.grid.wrap 
				{            
					max-width: 978px;            
					margin: 0 auto;        
				}        
				/* Width classes also have shorthand versions numbered as fractions * For example: for a grid unit 1/3 (one third) of the parent width, * simply apply class="w-1-3" to the element. */ 
				.grid .whole,        
				.grid .w-1-1 
				{            
					width: 100%;        
				}                
				.grid .half,        
				.grid .w-1-2 
				{            
					width: 50%;        
				}                
				.grid .one-third,        
				.grid .w-1-3 
				{            
					width: 33.3332%;        
				}                
				.grid .two-thirds,        
				.grid .w-2-3 
				{            
					width: 66.6665%;        
				}                
				.grid .one-quarter,        
				.grid .one-fourth,        
				.grid .w-1-4 
				{            
					width: 25%;        
				}                
				.grid .three-quarters,        
				.grid .three-fourths,        
				.grid .w-3-4 
				{            
					width: 75%;        
				}                
				.grid 
				.one-fifth,        
				.grid .w-1-5 
				{            
					width: 20%;        
				}                
				.grid .two-fifths,        
				.grid .w-2-5 
				{            
					width: 40%;        
				}                
				.grid .three-fifths,        
				.grid .w-3-5 
				{            
					width: 60%;        
				}                
				.grid .four-fifths,        
				.grid .w-4-5 
				{            
					width: 80%;        
				}                
				.grid .golden-small,        
				.grid .w-g-s 
				{            
					width: 38.2716%;        
				}        
				/* Golden section: smaller piece */                
				.grid .golden-large,        
				.grid .w-g-l 
				{            
					width: 61.7283%;        
				}        
				/* Golden section: larger piece */        
				/* Clearfix after every .grid */                
				.grid 
				{            
					*zoom: 1;        
				}                
				.grid:before,        
				.grid:after 
				{            
					display: table;            
					content: "";            
					line-height: 0;        
				}                
				.grid:after 
				{            
					clear: both;        
				}        
				/* Utility classes */                
				.align-center 
				{            
					text-align: center;        
				}                
				.align-left 
				{            
					text-align: left;        
				}                
				.align-right 
				{            
					text-align: right;        
				}                
				.pull-left 
				{            
					float: left;        
				}                
				.pull-right 
				{            
					float: right;        
				}        
				/* A property for a better rendering of images in units: in   this way bigger pictures are just resized if the unit   becomes smaller */                
				.unit img 
				{            
					max-width: 100%;        
				}        
				/* Hide elements using this class by default */                
				.only-on-mobiles 
				{            
					display: none !important;        
				}        
                      
				.splitGen 
				{            
					background: #dfe3e6;            
					height: 2px;            
					width: 100%;            
					float: left;            
					margin: 20px 0px 30px 0px;        
				}                
				h1 
				{            
					font-size: 28px;            
					line-height: 28px;            
					color: #2a3c6d;        
				}                
				h2,        
				.h2 
				{            
					font-size: 22px;        
				}                
				.btn-success 
				{			
					background: #a48553;			
					border: none;			
					box-shadow: 0 1px 1px rgba(0,0,0,0.15);			
					border-radius: 5px;			
					color: #fcfcfc !important;			
					padding: 10px 15px;			
					text-align: center;			
					text-transform: uppercase;			
					font-size: 13px;        
				}                
				.btn-success:active,        
				.btn-success.active,        
				.open>.dropdown-toggle.btn-success,        
				.btn-success:focus,        
				.btn-success.focus,        
				.btn-success:hover,        
				.btn-success.hover,        
				.btn-success:active:focus,        
				.btn-success.active:focus 
				{			
					background-color: #145890;			
					color: white;			
					border: none;        
				}                
				.form-control,        
				input:not([type="checkbox"]) 
				{            
					width: 90%;					
					max-width:400px;        
				}        		        
				a 
				{            
					color: #5C86EF;            
					text-decoration: underline;        
				}                
				a:focus,        
				a:hover,        
				a:active,        
				a:focus:hover 
				{            
					color: #3259B9;        
				}                
				.terms 
				{            
					display: none;        
				}                
				.login-with-room-number-container .grid 
				{            
					margin-bottom: 10px;        
				}                
				html,body 
				{		  
					margin: 0;		  
					padding: 0;		  
					height: 100%;		
				}                
				.full 
				{            
					width: 100%;        
				}				
				*{			
					font-family: Arial, Helvetica, sans-serif;			
					font-weight:200;			
					font-size: 1em;		
				}        		
				h1, h2, h3
				{			
					font-weight: 400;			
					color: #303030;		
				}		
				.header-links a
				{			
					color: rgb(165, 165, 165);			
					font-size: 14px;			
					line-height: 30px;		
				}				
				.hideme
				{			
					display:none !important;		
				}		
				.wrap
				{			
					background-color:white;			
					padding-bottom: 50px;		
				}		
				.lead
				{			
					font-size:14px;			
					color:red;		
				}		
				html 
				{		   
					height: 100%;		
				}		
				body 
				{			
					min-height: 100%;			
					background-color: #11100E;	
				}	
				.comments
				{				
					font-size: 12px;		
				}
				
				/* Responsive Stuff */  
				/* Expand the wrap a bit further on larger screens */                
				@media screen and (min-device-width: 1180px) 
				{            
					.wider .grid, .grid.wider 
					{                
						max-width: 1180px;                
						margin: 0 auto;   	
					}				
				}
				@media screen and (max-device-width: 800px) 
				{            
					/* Stack anything that isn’t full-width on smaller screens      
					and doesn"t provide the no-stacking-on-mobiles class it was originally 	568px, but it was too small*/            
					.grid:not(.no-stacking-on-mobiles) > .unit 
					{                
						width: 100% !important;                
						padding-left: 20px;                
						padding-right: 20px;            
					}            
					.unit .grid .unit 
					{                
						padding-left: 0px;                
						padding-right: 0px;  													
					} 
					.login-with-room-number-container 
					{ 
						width: 100%;
					} 					
					h2
					{
						font-size: 300%;            
						line-height: 120%;
					}					
					h1
					{
						font-size: 400%;            
						line-height: 140%;						
					}					
					.login-room-number, .login-surname, .submit, .comments
					{
						font-size: 200%;
					}					
					input:not([type="checkbox"]) 
					{            
						max-width: 90%;										        
					} 

					.grid .one-third,        
					.grid .w-1-3 
					{            
						width: 50%;        
					}	                
					.grid .two-thirds,        
					.grid .w-2-3 
					{            
						width: 50%;        
					} 					
					
					/* Sometimes, you just want to be different on small screens */            
					.center-on-mobiles 
					{                
						text-align: center !important;            
					}            
					.hide-on-mobiles 
					{                
						display: none !important;            
					}            
					.only-on-mobiles 
					{                
						display: block !important;            
					}									
					.header-links a
					{				
						line-height: 30px;			
					}
				}          				
				@media screen and (max-device-width: 620px) 
				{            
					/* custom responsive bits*/						
					.header-links a
					{				
						line-height: 40px;			
					}					
				}				
	</style>			
</head>
<?php
date_default_timezone_set('Australia/Sydney');

$log_out = (isset($_POST['Next']) && ($_POST['Next'] == "LOGOUT"))?true:false;

if((isset($_POST)) && (!isset($_POST['login_page'])) && ($log_out == false))
{
	$mac=isset($_POST['mac'])?$_POST['mac']:"";
	$ipaddr=isset($_POST['ip'])?$_POST['ip']:"";
	$URL_REF = parse_url($_SERVER['HTTP_REFERER']);
	$data = $URL_REF['query'];
	$new_url = substr($data, (strrpos($data, '=') ?: -1) +1);
	$new_url = urldecode($new_url);
}


if(!isset($_POST['login_page']) && (!empty($_POST)) && ($log_out == false))
{
	require_once ('additional_functions.php');
	require_once ('mikrotik_functions.php');

	$macadd=isset($_POST['mac'])?$_POST['mac']:"";
	
	$safe_list = get_safe_db($macadd);

	if(empty($safe_list))
	{
?>
	<body bgcolor="#ffffff" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
		<form action="" method="post">
			<div id="jsena" style="display:'none'">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" style="height:100%;">
					<tr>
						<td width="100%" >
							<div class="grid" style="background-image: url(/images/customizeimages/Meriton_GeometricPattern[1].jpg); repeat-x;background-position-y: bottom;     ">
								<div class="unit whole" style="padding-left: 0px;padding-right: 0px;height: 120px;max-width: 800px;margin:  auto;display: block;     ">
									<img src="images/meriton-logo.png" style="margin-top: 12px;margin-left: 20px;display: block;max-width: 100%;" alt="" />
								</div>
							</div>
							<div class="wrap">
								<div class="grid hide-on-mobiles" style="">
									<div class="unit whole" style="">
										<h1>Complimentary Internet Service</h1>
										<div class="splitGen">&nbsp;</div>
										<p class="lead"></p>
									</div>
								</div>
								<div class="grid" style="">
									<div class="unit half login-with-room-number-container">
										<h2>Login with Suite Number</h2>
										<div class="splitGen">&nbsp;</div>
										<div class="grid">
											<div class="  notification-text">
												<label id="errormessage"></label>
											</div>
										</div>
										<div class="grid login-room-number">
											<div class="unit one-third text-right">Suite Number</div>
											<div class="unit two-thirds">
												<input type="text" maxlength="30" name="room_no" value="" autocomplete="off">
											</div>
										</div>
										<div class="grid login-surname">
											<div class="unit one-third text-right">Surname</div>
											<div class="unit two-thirds">
												<input type="text"   maxlength="50" id="lname" name="lname"  autocomplete="off">
											</div>
										</div>
										<div class="grid submit">
											<div class="unit half">
												<input type="hidden" value="<?php echo $mac; ?>" name="mac">
												<input type="hidden" value="<?php echo $ipaddr; ?>" name="ipaddr">
												<input type="hidden" value="<?php echo $new_url; ?>" name="referrer">
												<input type="hidden" value="true" name="login_page">		
												<input type='submit' name='submit' class="buttonstyle">
											</div>
										</div>
									</div>
									<div class="unit half">
										<p>Welcome to Meriton Serviced Apartments, please enjoy our complimentary internet service. To connect, enter your suite number and surname then click the login button. </p>
										<p>Please contact guest services on extension 9 if you require any assistance. 	</p>
										<!--p>Complimentary internet access has data cap limits as listed below: </p>
										<ul>
											<li>Studio / Suites with 1 Bedroom: 1 GB / day</li>
											<li>Suites with 2 Bedrooms: 2 GB / day</li>
											<li>Suites with 3 Bedrooms: 3 GB / day</li>
										</ul>
										<p> Usage resets at midnight every day and once data cap has been reached your internet speed will be shaped to 256Kbps. </p-->
										<br/>
										<br/>
									</div>
								</div>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</form>
	</body>
<?php
	}
	else
	{
		$URL_REF = parse_url($_SERVER['HTTP_REFERER']);
		$data = $URL_REF['query'];
		$newurl = substr($data, (strrpos($data, '=') ?: -1) +1);
		$newurl = urldecode($newurl);		
		
		$referrer = $newurl;
		debugTextLogger("-------PREMIUM MAC $mac-------");
		debugTextLogger("PREMIUM MAC REFERRER: $referrer");
		$mac_record = get_record($mac);
		$hotel_code = get_hotspot_hotel($ipaddr);
		debugTextLogger("PREMIUM MAC HOTEL CODE: $hotel_code");
		debugTextLogger("PREMIUM MAC IP ADDRESS: ".$ipaddr);
		
		$rate_plan = "500GB";
		$bytes = convertToBytes($rate_plan);
		$timelimit = '2555d';
		$depart = strtotime("+2555 day");
		$status = 1;
		
		if(empty($mac_record))
		{
			$user_list = find_hotspot_user($mac);
			
			if(empty($user_list))
			{
				$user_list = add_user_to_hotspot($mac,$bytes,$timelimit,$mac,"premium");
				debugTextLogger("ADD PREMIUM MAC $mac TO HOTSPOT");
				debugTextLogger(serialize($user_list));		
			}
			else
			{
				debugTextLogger("MAC $mac ALREADY EXISTS IN HOTSPOT");
			}
			
			$log_arr = array(
							"remote_addr" => $ipaddr,
							"hotel_code" => $hotel_code,
							"ip_addr" => $_SERVER['REMOTE_ADDR'],
							"mac" => $mac,						
							"user_name" => $mac,
							"room_no" => '0',
							"first_name" => "PREMIUM",
							"last_name" => "ACCOUNT",
							"rate_plan" => $rate_plan,
							"bytes_in" => 0,
							"bytes_out" => 0,							
							"arrival" => date("Y-m-d",time()),
							"departure" => date("Y-m-d",$depart),
							"status" => "A"
						);	

			$reply = log_hotspot_user($log_arr);

			$find_active_user = find_hotspot_active_user($mac);
			
			if(empty($find_active_user))
			{			
				$user_list = login_to_hotspot($mac,$mac,$ipaddr);
				if(empty($user_list))
				{
					debugTextLogger("ADD PREMIUM ACTIVE USER $mac IN HOTSPOT");
					debugTextLogger(serialize($user_list));						
				}
			}
			else
			{
				debugTextLogger("ACTIVE USER MAC $mac ALREADY EXISTS IN HOTSPOT");
			}
		
			$log_status = array(
						"hotel_code" => $hotel_code,
						"room_no" => 0,
						"mac" => $mac,
						"ip_address" => $_SERVER['REMOTE_ADDR'],
						"last_name" => "ACCOUNT",
						"api_output" => "",
						"status" => $status
					);
				
			$log_user = log_connect_user($log_status);				
		}
		else
		{
			$user_list = find_hotspot_user($mac);
			
			if(empty($user_list))
			{
				$user_list = add_user_to_hotspot($mac,$bytes,$timelimit,$mac,"premium");
				debugTextLogger("ADD PREMIUM MAC $mac TO HOTSPOT");
				debugTextLogger(serialize($user_list));		
			}
			else
			{
				debugTextLogger("PREMIUM MAC $mac ALREADY EXISTS IN HOTSPOT");
			}			
			
			$find_active_user = find_hotspot_active_user($mac);
			
			if(empty($find_active_user))
			{
				$user_list = login_to_hotspot($mac,$mac,$ipaddr);
				if(empty($user_list))
				{
					debugTextLogger("ADD PREMIUM ACTIVE USER $mac IN HOTSPOT");
					debugTextLogger(serialize($user_list));						
				}
			}
			else
			{
				debugTextLogger("PREMIUM ACTIVE USER MAC $mac ALREADY EXISTS IN HOTSPOT");
			}
		}
		
		$log_status = array(
						"hotel_code" => $hotel_code,
						"room_no" => 0,
						"mac" => $mac,
						"ip_address" => $_SERVER['REMOTE_ADDR'],
						"last_name" => "ACCOUNT",
						"api_output" => "",
						"status" => $status
					);
				
		$log_user = log_connect_user($log_status);

		if(trim($referrer))
		{
			echo "<script>window.location.href = '".$referrer."';</script>";
		}
		else
		{
?>
	<body bgcolor="#ffffff" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
		<form action="" method="post" name="disconnect_form">
			<div id="jsena" style="display:'none'">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" style="height:100%;">
					<tr>
						<td width="100%" >
							<div class="grid" style="background-image: url(/images/customizeimages/Meriton_GeometricPattern[1].jpg); repeat-x;background-position-y: bottom;     ">
								<div class="unit whole" style="padding-left: 0px;padding-right: 0px;height: 120px;max-width: 800px;margin:  auto;display: block;     ">
									<img src="images/meriton-logo.png" style="margin-top: 12px;margin-left: 20px;display: block;max-width: 100%;" alt="" />
								</div>
							</div>
							<div class="wrap">
								<div class="grid" style="">
									<div class="unit whole hide-on-mobiles" style="">
										<h1>Complimentary Internet Service</h1>
										<div class="splitGen">&nbsp;</div>
										<p class="lead"></p>
									</div>
								</div>
								<div class="grid" style="">
									<div class="unit whole">
										<div class="grid">
											<div class="notification-text">
												<label id="errormessage">You have successfully logged in.</label>
											</div>
										</div>
										<hr>
										<div class="grid">
											<div class="unit whole hide-on-mobiles">To start browsing the internet, please minimise this login window and open the new browser window.</div>
										</div>									
									</div>
								</div>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</form>
	</body>
<?php			
		}
	}
}
else
{
	require_once ('additional_functions.php');
	require_once ('mikrotik_functions.php');

	debugTextLogger("POST VARIABLES");
	debugTextLogger(implode(" - ",$_POST));
	
	$reduced_speed = "";
	$remain_bytes = "";
	$total_bytes = 0;
	$logout = 1;
	$status = "";
	$profile = "standard";
	$premium = false;

	if(isset($_POST['Next']) && ($_POST['Next'] == "LOGOUT"))
	{
		$find_user = find_hotspot_active_user($_POST['mac_add']);
		
		if(!empty($find_user))
		{
			//$user_list = remove_hotspot_active_user($_POST['mac_add']);	
		}
		
		//disconnect_hotspot_user($_POST['mac_add']);
		
		debugTextLogger("USERNAME FOR DISCONNECT");
		debugTextLogger($_POST['mac_add']);
		$logout = 0;
		$message = "You have successfully logged out.";
		session_destroy();
	}
	else
	if(isset($_POST['room_no']))
	{
		debugTextLogger($_POST['room_no']);
		debugTextLogger("BROWSER REFRESHED");
		debugTextLogger($_POST['mac']);
		debugTextLogger($_POST['ipaddr']);

		$lname = $_POST['lname'];
		$room_no = $_POST['room_no'];
		$mac = $_POST['mac'];
		$ip_addr = $_POST['ipaddr'];
		$referrer = $_POST['referrer'];
		$hotel_no = "";
		//$last_name = $lname;
		$check_name = "";
		$check_rate = "";
	
		if(($_POST['room_no'] == "9999")&&(is_hotspot_hotel($lname)))
		{
			$rate_plan = "20GB";
			$_SESSION['check_rate'] = $rate_plan;
			//$bytes = convertToBytes($rate_plan);
			$bytes = convertToBytes($rate_plan) * 2;
			$timelimit = '7d';
		
			$_SESSION['status'] = "ACTIVE";
			$find_user = find_hotspot_user($mac);
			//$find_user = find_hotspot_user($user_name);
			debugTextLogger("FIND USER IN HOTSPOT");
			debugTextLogger(serialize($find_user));			
		
			if(empty($find_user))
			{
				$timelimit = '1d';
				$user_list = add_user_to_hotspot($mac,$bytes,$timelimit,$mac,"standard");
				debugTextLogger("ADD USER TO HOTSPOT");
				debugTextLogger(serialize($user_list));	
			}

			$hotel_code = get_hotspot_hotel(trim($ip_addr));

			$depart = strtotime("+1 day");			
			
			$log_arr = array(
							"remote_addr" => $ip_addr,
							"hotel_code" => $hotel_code,
							"ip_addr" => $_SERVER['REMOTE_ADDR'],
							"mac" => $mac,						
							"user_name" => $mac,
							"room_no" => $room_no,
							"first_name" => "",
							"last_name" => $lname,
							"rate_plan" => $rate_plan,
							"bytes_in" => 0,
							"bytes_out" => 0,							
							"arrival" => date("Y-m-d",time()),
							"departure" => date("Y-m-d",$depart),
							"status" => "A"
						);	

			$reply = log_hotspot_user($log_arr);
			$_SESSION['status'] = "ACTIVE";	
		}

		debugTextLogger("POST ROOM NO: ");
		debugTextLogger($_POST['room_no']);
		debugTextLogger("LAST NAME: ");
		debugTextLogger($_POST['lname']);
		
		if(trim($_POST['room_no']) == "9998")
		{
			$rate_plan = "50MB";
			$_SESSION['check_rate'] = $rate_plan;
			//$bytes = convertToBytes($rate_plan);
			$bytes = convertToBytes($rate_plan) * 2;
		
			$_SESSION['status'] = "ACTIVE";
			$find_user = find_hotspot_user($mac);
			//$find_user = find_hotspot_user($user_name);
			debugTextLogger("FIND USER IN HOTSPOT");
			debugTextLogger(serialize($find_user));			
		
			if(empty($find_user))
			{
				$timelimit = '7d';
				$user_list = add_user_to_hotspot($mac,$bytes,$timelimit,$mac,"standard");
				debugTextLogger("ADD USER TO HOTSPOT");
				debugTextLogger(serialize($user_list));	
			}

			$hotel_code = get_hotspot_hotel(trim($ip_addr));
			
			$log_arr = array(
							"remote_addr" => $ip_addr,
							"hotel_code" => $hotel_code,
							"ip_addr" => $_SERVER['REMOTE_ADDR'],
							"mac" => $mac,						
							"user_name" => $mac,
							"room_no" => $room_no,
							"first_name" => "",
							"last_name" => $lname,
							"rate_plan" => $rate_plan,
							"bytes_in" => 0,
							"bytes_out" => 0,							
							"arrival" => date("Y-m-d",time()),
							"departure" => "",
							"status" => "A"
						);	

			$reply = log_hotspot_user($log_arr);
			$_SESSION['status'] = "ACTIVE";
			$logout = 1;
		}		
						
		if(!isset($_SESSION['status']))
		{	
			debugTextLogger("FIND HOTEL CODE");
			debugTextLogger(trim($ip_addr));
			$hotel_code = get_hotspot_hotel(trim($ip_addr));
			debugTextLogger("HOTEL CODE");
			debugTextLogger($hotel_code);
		
			$_SESSION['status'] = "ACTIVE";
			$Web_Service_URL = MERITON_API_URL.'/?hotel='.$hotel_code.'&room='.$room_no;

			debugTextLogger("$room_no Starting cURL call to Meriton API ".$Web_Service_URL);
	
			// Init the cURL session
			$result = postCurl($Web_Service_URL);
			debugTextLogger($result);	

			$xml=simplexml_load_string($result) or die("Error: Cannot create object");
	
			$check_name = $xml->Guest->LastName;
			$check_name = trim(preg_replace('/\s\s+/', ' ', $check_name));
			$check_rate = $xml->Guest->RatePlan;
			$check_rate = trim(preg_replace('/\s\s+/', '', $check_rate));
			//$_SESSION['check_rate'] = $check_rate;
			$check_rate = trim(preg_replace('/GB|MB/', '', $check_rate));
			//$_SESSION['check_rate'] = $check_rate;
			debugTextLogger($check_name);
			
			$check_name = trim($check_name);

			if(!empty($check_name))
			{		
				foreach($xml as $key=>$val)
				{
					foreach($val as $a=>$b)
					{
						if(trim($b) != "")
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
				}
				
				if(strtoupper($last_name) == strtoupper($lname))
				{
					debugTextLogger("Last Name : $last_name");
					debugTextLogger("Rate Plan : $rate_plan");
					debugTextLogger("Arrival : $arrival");
					debugTextLogger("Departure : $departure");
					
					$arrival = explode(" ", $arrival);

					$arrival = date_create_from_format('d/m/Y', $arrival[0]);
					if($arrival != FALSE)
					{
						$arrival = date_format($arrival, 'Y-m-d');				
					}
					
					$departure = explode(" ", $departure);
					
					$departure = date_create_from_format('d/m/Y', $departure[0]);
					if($departure != FALSE)
					{
						$departure = date_format($departure, 'Y-m-d');					
					}

					$datediff = strtotime($departure) - time();
					$days =  ceil($datediff/(60*60*24));

					debugTextLogger("Days: $days");	
					
					$number_of_days = $days + 1;
					//$number_of_days = $days * 2;
					
					debugTextLogger("Number of Days Added: $number_of_days");
					debugTextLogger("Referer:  $referrer");
		
					$timelimit = $number_of_days."d";
		
					$_SESSION['last_name'] = $last_name;
		
					//$bytes = convertToBytes($rate_plan);

					$calc_bytes = convertToBytes($rate_plan);
					
					if($calc_bytes == 0)
					{
						$rate_plan = "2GB";
					}	

					$bytes = convertToBytes($rate_plan) * 2;
					$find_user = find_hotspot_user($mac);
					
					preg_match("/^\d+/",$rate_plan,$my_bytes);
					$postfix = preg_replace("/^\d+/","",$rate_plan);
					
					$rate_plan = ($my_bytes[0] * 2).$postfix;
					$_SESSION['check_rate'] = $rate_plan;
					
					
					debugTextLogger("FIND USER IN HOTSPOT");
		
					if(empty($find_user))
					{
						$premium = get_user_premium($hotel_code, $room_no);
						
						if($premium === true)
						{
							$profile = "premium";
						}
						else
						{
							$profile = "standard";
						}
						
						debugTextLogger("ADD USER IN HOTSPOT WITH BYTES $bytes");							
						
						$user_list = add_user_to_hotspot($mac,$bytes,$timelimit,$mac,$profile);
						
						debugTextLogger("ADD USER IN HOTSPOT WITH PROFILE $profile");						
					}	
		
					$arrival = strtr($arrival, '/', '-');
					$departure = strtr($departure, '/', '-');
		
					$log_arr = array(
							"remote_addr" => $ip_addr,
							"hotel_code" => $hotel_code,
							"ip_addr" => $_SERVER['REMOTE_ADDR'],
							"mac" => $mac,						
							"user_name" => $mac,
							"room_no" => $room_no,
							"first_name" => $first_name,
							"last_name" => $last_name,
							"rate_plan" => $rate_plan,
							"bytes_in" => 0,
							"bytes_out" => 0,
							"arrival" => date("Y-m-d H:i:s",strtotime($arrival)),
							"departure" => date("Y-m-d H:i:s",strtotime($departure)),
							"status" => "A"
						);	

					$reply = log_hotspot_user($log_arr);
					$logout = 1;
				}
				else
				{
					$logout = 0;
					$message = "Last name is not matched with current user. Please try again.";					
				}	
			}
			else
			{
				$logout = 0;
				$message = "Last name is not filled in. Please try again.";
			}
		}
		
		$status = ($logout == 0)?0:1;
				
		$log_status = array(
						"hotel_code" => $hotel_code,
						"room_no" => $room_no,
						"mac" => $mac,
						"ip_address" => $_SERVER['REMOTE_ADDR'],
						"last_name" => $lname,
						"api_output" => $result,
						"status" => $status
					);
				
		$log_user = log_connect_user($log_status);		

		if($logout != 0)
		{
			$find_active_user = find_hotspot_active_user($mac);
			debugTextLogger("FIND ACTIVE USER IN HOTSPOT");
			debugTextLogger(serialize($find_active_user));		
			
			if(empty($find_active_user))
			{
				$user_list = login_to_hotspot($mac,$mac,$ip_addr);
				debugTextLogger("ADD ACTIVE USER IN HOTSPOT");
				debugTextLogger(serialize($user_list));				
				$find_active_user = find_hotspot_active_user($mac);
				debugTextLogger("FIND ACTIVE USER IN HOTSPOT");
				debugTextLogger(serialize($find_active_user));				
			}
			
			if(!empty($find_active_user))
			{
				$find_user = find_hotspot_user($mac);
				debugTextLogger("FIND USER IN HOTSPOT");
				debugTextLogger(serialize($find_user));	

				if($find_user[0]['profile'] != 'shaped')
				{
					$user_db_usage = get_usage_db($mac);
					
					if(!empty($user_db_usage))
					{		
						$total_db_usage = $user_db_usage['bytes_in'] + $user_db_usage['bytes_out'];
						$total_hotspot_usage = $find_user[0]['bytes-in'] + $find_active_user[0]['bytes-in'] + $find_user[0]['bytes-out'] + $find_active_user[0]['bytes-out'];
						$total_bytes = $total_hotspot_usage - $total_db_usage;
						
						if($total_bytes < 0)
						{
							$total_bytes = $total_hotspot_usage;
						}
						
						//$allocated_bytes = convertToBytes($_SESSION['check_rate'])*1;
						$allocated_bytes = convertToBytes($_SESSION['check_rate']);
				
						debugTextLogger("ALLOCATED BYTES");
						debugTextLogger($allocated_bytes);
				
						$remain_bytes = $allocated_bytes-$total_bytes;		
					}
				}
				else
				{
					$user_shaped_usage = get_shaped_db($mac, $hotel_code, $room_no);
					if(!empty($user_shaped_usage))
					{					
						$total_shaped_usage = $user_shaped_usage['shaped_bytes'];
						$total_hotspot_usage = $find_user[0]['bytes-in'] + $find_active_user[0]['bytes-in'] + $find_user[0]['bytes-out'] + $find_active_user[0]['bytes-out'];					
						$total_bytes = $total_hotspot_usage + $total_shaped_usage;
						$remain_bytes = 0;
						$reduced_speed = "Your browsing speed has been reduced to 256/256 kbps";						
					}
				}
				
				debugTextLogger("TOTAL BYTES");
				debugTextLogger($total_bytes);
				debugTextLogger("REMAIN BYTES");
				debugTextLogger($remain_bytes);				
			}
			else
			{
				$logout = 0;
				$message = "You can not be logged in at this time. Please try again.";
			}
		}
	}
	else
	if(isset($_POST['mac']) || isset($_POST['ipaddr']) && (!isset($_POST['Next'])) && ($_POST['Next'] != "LOGOUT"))
	{
		debugTextLogger("USER STATUS");
		debugTextLogger($_POST['mac']);
		debugTextLogger($_POST['ipaddr']);
		debugTextLogger($_POST['bytes_in']);
		debugTextLogger($_POST['bytes_out']);

		$hotel_code = get_hotspot_hotel($_POST['ipaddr']);
		debugTextLogger("HOTEL CODE");
		debugTextLogger($hotel_code);	

		$users = hotspot_rows_mac($_POST['mac']);
		$room_no = $users[0]['room_no'];
		
		$Web_Service_URL = MERITON_API_URL.'/?hotel='.$hotel_code.'&room='.$room_no;
		debugTextLogger("$room_no Starting cURL call to Meriton API ".$Web_Service_URL);
	
		// Init the cURL session
		$result = postCurl($Web_Service_URL);
		debugTextLogger($result);
		
		$mac = $_POST['mac'];

		$xml=simplexml_load_string($result) or die("Error: Cannot create object");
	
		$check_rate = $xml->Guest->RatePlan;
		$check_rate = trim(preg_replace('/\s\s+/', '', $check_rate));
		/*$check_rate = trim(preg_replace('/GB|MB/', '', $check_rate));*/
		$last_name = $xml->Guest->LastName;
		$last_name = trim(preg_replace('/\s\s+/', '', $last_name));
		debugTextLogger($check_rate);
		
		$find_active_user = find_hotspot_active_user($mac);
		debugTextLogger("FIND ACTIVE USER IN HOTSPOT");
		debugTextLogger(serialize($find_active_user));
		
		if(!empty($find_active_user))
		{					
			$find_user = find_hotspot_user($mac);
			debugTextLogger("FIND USER IN HOTSPOT");
			debugTextLogger(serialize($find_user));
			
			$user_db_usage = get_usage_db($mac);
			$total_db_usage = $user_db_usage['bytes_in'] + $user_db_usage['bytes_out'];
			$total_hotspot_usage = $find_user[0]['bytes-in'] + $find_active_user[0]['bytes-in'] + $find_user[0]['bytes-out'] + $find_active_user[0]['bytes-out'];			
			$total_bytes = $total_hotspot_usage - $total_db_usage;	
			$allocated_bytes = convertToBytes($check_rate) * 2;
				
			debugTextLogger("ALLOCATED BYTES");
			debugTextLogger($allocated_bytes);
						
			if($total_bytes < 0)
			{
				$total_bytes = $total_hotspot_usage;
			}
				
			$remain_bytes = $allocated_bytes-$total_bytes;

			if($find_user[0]['profile'] == 'shaped')
			{

				$user_shaped_usage = get_shaped_db($mac, $hotel_code, $room_no);
				
				if(!empty($user_shaped_usage))
				{					
					$total_shaped_usage = $user_shaped_usage['shaped_bytes'];
					$total_hotspot_usage = $find_user[0]['bytes-in'] + $find_active_user[0]['bytes-in'] + $find_user[0]['bytes-out'] + $find_active_user[0]['bytes-out'];					
					$total_bytes = $total_hotspot_usage + $total_shaped_usage;
					$remain_bytes = 0;
					$reduced_speed = "Your browsing speed has been reduced to 256/256 kbps";	
				}
			}				
								
			debugTextLogger("TOTAL BYTES");
			debugTextLogger($total_bytes);
			debugTextLogger("REMAIN BYTES");
			debugTextLogger($remain_bytes);	
		}
		else
		{
			$logout = 0;
			//$message = "You can not be logged in at this time. Please try again.";	
			$message = "User can not be logged in at this time. Please try again.";	
		}
	}
	else
	{
		$logout = 0;
		$message = "Submitted form cannot be processed. Please try again.";			
	}	
?>
	<body bgcolor="#ffffff" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
		<form action="" method="post" name="disconnect_form">
			<div id="jsena" style="display:'none'">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" style="height:100%;">
					<tr>
						<td width="100%" >
							<div class="grid" style="background-image: url(/images/customizeimages/Meriton_GeometricPattern[1].jpg); repeat-x;background-position-y: bottom;     ">
								<div class="unit whole" style="padding-left: 0px;padding-right: 0px;height: 120px;max-width: 800px;margin:  auto;display: block;     ">
									<img src="images/meriton-logo.png" style="margin-top: 12px;margin-left: 20px;display: block;max-width: 100%;" alt="" />
								</div>
							</div>
							<div class="wrap">
								<div class="grid" style="">
									<div class="unit whole hide-on-mobiles" style="">
										<h1>Complimentary Internet Service</h1>
										<div class="splitGen">&nbsp;</div>
										<p class="lead"></p>
									</div>
								</div>
								<div class="grid" style="">
									<div class="unit whole">
										<div class="grid">
											<div class="notification-text">
												<?php 
													if($logout === 0)
													{
												?>
												<label id="errormessage"><?php echo $message; ?></label>
												<?php
													}
													else
													{
												?>
												<label id="errormessage">You have successfully logged in.</label>
												<?php
													}
												?>
											</div>
										</div>
										<?php
											if($logout != 0)
											{
										?>
												<h2>You are now connected to the internet</h2>
												<hr>
												<div class="grid">
													<!--div class="unit whole hide-on-mobiles">To start browsing the internet, please minimise this login window and open the new browser window.</div-->	
												</div>
												<!--div class="grid">
													<div class="unit half">
														<div class="unit one-third text-right comments">Internet Data Remaining</div>
														<div class="unit two-thirds comments"><?php echo formatSizeUnits($remain_bytes); ?></div>
													</div>
													<div class="unit half">
														<div class="unit one-third text-right comments">Internet Data Consumed</div>
														<div class="unit two-thirds comments"><?php echo formatSizeUnits($total_bytes); ?></div>			
													</div>			
												</div>
												<div class="grid">
													<div class="unit whole comments"><?php echo $reduced_speed; ?></div>
												</div-->										
												<div class="grid submit">
													<div class="unit half">	
														<input type="hidden" name="mac_add" value="<?php echo $mac;?>">	
														<input type="hidden" name="last_id" value="<?php echo $last_name;?>">	
														<!--input type='submit' name='Next' value="LOGOUT" class="buttonstyle"-->
													</div>
												</div>
										<?php
												//echo "<script>window.location.href = '".$_POST['referrer']."';</script>";
											}
										?>
									</div>
								</div>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</form>
	</body>
<?php
}
?>	
</html>
