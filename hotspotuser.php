<html>
<head>
    <script>
		"use strict";
	function submitForm(oFormElement)
	{
		var xhr = new XMLHttpRequest();
		xhr.onload = function(){ alert (xhr.responseText); }
		xhr.open (oFormElement.method, oFormElement.action, true);
		xhr.send (new FormData (oFormElement));
		window.close();
		return false;
	}
		
	</script>
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
				/* Responsive Stuff */        	
				@media screen and (max-width: 800px) 
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
				/* Expand the wrap a bit further on larger screens */                
				@media screen and (min-width: 1180px) 
				{            
					.wider .grid,            
					.grid.wider 
					{                
						max-width: 1180px;                
						margin: 0 auto;            
					}        
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
				@media screen and (max-width: 620px) 
				{            
					/* custom responsive bits*/						
					.header-links a
					{				
						line-height: 40px;			
					}			        
				}
<?php
require_once ('additional_functions.php');
require_once ('mikrotik_functions.php');

if(isset($_POST['room_no']))
{
	$lname = $_POST['lname'];
	$room_no = $_POST['room_no'];
	$mac = $_POST['mac'];
	$ip_addr = $_POST['ipaddr'];
	$referrer = $_POST['referrer'];
	$hotel_no = "";	

	$Web_Service_URL = MERITON_API_URL.'/?hotel='.$hotel_no.'&room='.$room_no;

	debugTextLogger("$room_no Starting cURL call to Meriton API ".$Web_Service_URL);
	
	// Init the cURL session
	$result = postCurl($Web_Service_URL);
}
debugTextLogger($result);

if($result != FALSE)
{
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

	if(strtoupper($last_name) == strtoupper($lname))
	{
		debugTextLogger("Last Name : $last_name");
		debugTextLogger("Rate Plan : $rate_plan");
		debugTextLogger("Arrival : $arrival");
		debugTextLogger("Departure : $departure");

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

		debugTextLogger("Number of Days Stay: $number_of_days");
		debugTextLogger("Referer:  $referrer");
		
		$timelimit = $number_of_days."d";
		
		$log_arr = array(
						"remote_addr" => $ip_addr,
						"mac" => $mac,						
						"request_uri" => $referrer,
						"room_no" => $room_no,
						"first_name" => $first_name,
						"last_name" => $last_name,
						"rate_plan" => $rate_plan,
						"arrival" => $arrival,
						"departure" => $departure,
						"status" => "A"
		);
		
		log_hotspot_user($log_arr);
		
		$bytes = convertToBytes($rate_plan);
		$user_list = add_user_to_hotspot(strtolower($last_name),$bytes,$timelimit,$mac);
		$user_list = login_to_hotspot(strtolower($last_name),$mac,$ip_addr);
		sleep(10);
		$user_list = find_hotspot_active_user(strtolower($last_name));
		$total_bytes = $user_list['bytes-in'] + $user_list['bytes-out'];
		$remain_bytes = $user_list['limit-bytes-total'] - $total_bytes;
		
		if($remain_bytes <= 0)
		{
			$user_list = limit_hotspot_user($ip_addr);
		}
	}
}
?>				
	</style>			
</head>
	<body bgcolor="#ffffff" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="loadGuestDetails();autologin();" onFocus="gotFocus();" onBlur="lostFocus();">
		<form action="disconnect.php" method="post">
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
									<div class="unit whole" style="">
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
										<h2>Login Details</h2>
										<hr>
										<div class="grid">
											<div class="unit whole">To start browsing the internet, please minimise this login window and open the new browser window.</div>
										</div>
										<div class="grid">
											<div class="unit half">
												<div class="unit one-third text-right comments">Internet Data Remaining</div>
												<div class="unit two-thirds comments"><?php echo formatSizeUnits($remain_bytes); ?></div>
											</div>
											<div class="unit half">
												<div class="unit one-third text-right comments">Internet Data Consumed</div>
												<div class="unit two-thirds comments"><?php echo formatSizeUnits($total_bytes); ?></div>			
											</div>			
										</div>
										<div class="grid submit">
											<div class="unit half">
												<input type="hidden" value="<?php echo strtolower($last_name); ?>" name="last_name">										
												<input type='submit' name='Submit' value="LOGOUT" class="buttonstyle">
											</div>
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
</html>