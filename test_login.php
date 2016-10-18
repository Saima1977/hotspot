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
				@media screen and (max-width: 620px) 
				{            
					/* custom responsive bits*/						
					.header-links a
					{				
						line-height: 40px;			
					}			        
				}
<?php
if(isset($_POST))
{
	$mac=$_POST['mac'];
	$ipaddr=$_POST['ip'];
	$username=$_POST['username'];
	$linklogin=$_POST['link-login'];
	$linkorig=$_POST['link-orig'];
	$error=$_POST['error'];
	$URL_REF = parse_url($_SERVER['HTTP_REFERER']);
	$data = $URL_REF['query'];
	$new_url = substr($data, (strrpos($data, '=') ?: -1) +1);
	$new_url = urldecode($new_url);
	$new_url = "http://forums.whirlpool.net.au/";
	$ipaddr = "192.168.0.252";
	$mac = "5A:5D:83:75:A4:4E";
}
?>				
	</style>			
</head>
	<body bgcolor="#ffffff" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="loadGuestDetails();autologin();" onFocus="gotFocus();" onBlur="lostFocus();">
		<form action="hotspotuser.php" method="post">
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
												<input type='submit' name='submit' class="buttonstyle">
											</div>
										</div>
									</div>
									<div class="unit half">
										<p> 					Welcome to Meriton Serviced Apartments, please enjoy our complimentary internet service. To connect, enter your suite number and surname then click the login button. 				</p>
										<p> 					Please contact guest services on extension 9 if you require any assistance. 				</p>
										<p> 					Complimentary internet access has data cap limits as listed below: 				</p>
										<ul>
											<li>Studio / Suites with 1 Bedroom: 1 GB / day</li>
											<li>Suites with 2 Bedrooms: 2 GB / day</li>
											<li>Suites with 3 Bedrooms: 3 GB / day</li>
										</ul>
										<p> 					Usage resets at midday every day and once data cap has been reached your internet speed will be shaped to 256Kbps. 				</p>
										<br />
										<br />
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