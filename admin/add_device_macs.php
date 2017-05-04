<?php
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Hotspot Admin Utility Login</title>
		<link rel="stylesheet" href="css/style.css" media="screen" type="text/css" />
	    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,700">
		<script src="https://code.jquery.com/jquery-3.1.1.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
    <body bgcolor="#e6e6e6">
		<?php
			function debugLogger($stmt)
			{
				$dir = "/var/www/hotspot/log/";
				$dir_path = $dir."HS_ADMIN_ADD_DEVICE_".date('dmY',time()).".log";
	
				if (!file_exists($dir) ) 
				{
					$oldmask = umask(0);  // helpful when used in linux server  
					mkdir($dir, 0744);
				}
	
				$logLine = "\n".date("Y-m-d  H:i:s")."\tDEBUG\t".print_r($stmt, true)."\n\r";	

				$size = file_put_contents($dir_path, $logLine, FILE_APPEND);

				if ($size == FALSE)
				{
					return "Error writing file.";
				}
				else
				{
					return 1;
				}
			}
			
			
			
			
			if(isset($_SESSION['successful']) && ($_SESSION['successful'] == 1))
			{
		?>
		<div class="header-container overlay">
			<div class="txt-container">
				<p>Hotspot Utility Tool</p>
			</div>
		</div>	
		<div id="pagewrap">
			<section id="content_form">
				<h2 class="form_title">Add Room Device(s)</h2>
				    <p>&nbsp;</p>
										
					<form class="change_form" id="device_form" name="device_form" method="POST" action="">
					<?php
						require_once("config.php");
						require_once("mikrotik_functions.php");
						require_once("additional_functions.php");
						$display_limit = 0;
								
								
						$string = "";
						
						$db = mysqli_connect($MYSQLSVR,$MYSQLUSR,$MYSQLPWD,$MYSQLDBS);
	
						if($db->connect_error) 
						{
							echo "<script>console.log('".$db->connect_error."');</script>";
							die('Error : ('.$db->connect_errno.')'.$db->connect_error);
						}
					?>
						<div id="post_msg" name="post_msg"></div>
						<div>
							<label for="hotel_no">Hotel <span class="required">(required)</span></label>
							<input type="hidden" id="row_display" name="row_display" value='0'>
							<input type="hidden" name="hotel_code" id="hotel_code" value="" />
							<select name="hotel_no" id="hotel_no" required>
								<option value="">---</option>
						<?php
							$results = $db->query("SELECT hotel_id, UPPER(description) FROM hotspot_hotel_range GROUP BY hotel_id");
	
							$row_cnt = $results->num_rows;
								
							$records = $results->fetch_all();
	
							if($row_cnt > 0)
							{
								foreach($records as $key=>$val)
								{
									if (preg_match('#^BNE#i', $val[0]) === 1) 
									{
										$state = "Brisbane";
									}
									elseif(preg_match('#^OOL#i', $val[0]) === 1)
									{
										$state = "Goldcoast";
									}
									elseif(preg_match('#^PAR#i', $val[0]) === 1)
									{
										$state = "Parramatta";
									}											
									else
									{
										$state = "Sydney";
									}
						?>										
								<option value="<?php echo $val[0]; ?>" <?php if($val[0] == $_POST['hotel_no']) echo "selected"; ?>><?php echo $val[1]." (".$state.")"; ?></option>
						<?php
								}
							}
						?>
							</select>
						</div>
						<div>
							<label for='room_no'>Room No <span class='required'>(required)</span></label>
							<input type='text' name='room_no' id='room_no' placeholder='Room No #' value="<?php echo (isset($_POST['room_no']))?$_POST['room_no']:""; ?>" required />
							<input type="hidden" name="room_code" id="room_code" />
						</div>						
						<div id="add_mac">
							<label for='mac_add'>MAC Address</label>
							<input type='text' name='mac_add' id='mac_add' placeholder='00:00:00:00:00:00' value="<?php echo (isset($_POST['mac_add']))?$_POST['mac_add']:""; ?>" />
						</div>
						<div>
							<label for='device_desc'>Description</label>
							<input type='text' name='device_desc' id='device_desc' placeholder='For e.g. Apple TV / Camera' value="<?php echo (isset($_POST['device_desc']))?$_POST['device_desc']:""; ?>"/>
						</div>						
						<div width='100%'>
							<input id="action" name="action" type="hidden" value="ADD"/>
							<input id='search_room_devices' name='search_room_devices' value='Add Device' type='submit' >
						</div>
					</form>					
						
					<?php						
						if($_SERVER['REQUEST_METHOD'] === 'POST')
						{	
							debugLogger("Add Room Device(s) ....... ");			
							
							$hotel_no = ms_escape_string($_POST['hotel_no']);
							$room_no = ms_escape_string($_POST['room_no']);
							$mac_add = ms_escape_string($_POST['mac_add']);
							$device_desc = ms_escape_string($_POST['device_desc']);
							
							debugLogger("HOTEL CODE: ");
							debugLogger($hotel_no);
							debugLogger("ROOM NO: ");
							debugLogger($room_no);
							debugLogger("MAC ADDRESS: ");
							debugLogger($mac_add);
							
							if(isset($_POST['authenticate_prev']))
							{	 
								if($_POST['row_display'] >= 10)
								{
									$display_limit = $_POST['row_display']-10;
								}
								else
								{
									$display_limit = 0;
								}
							}
							else
							if(isset($_POST['authenticate_next']))
							{
								if($_POST['row_display'] >= 0)
								{
									$display_limit = $_POST['row_display'] + 10;
								}
								else
								{
									$display_limit = 0;
								}
							}
					
							if($_POST['action'] == 'ADD')
							{
								if($mac_add != "")
								{
									$Web_Service_URL = MERITON_API_URL.'/?hotel='.$hotel_no.'&room='.$room_no;
									// Init the cURL session
									$result = postCurl($Web_Service_URL);
									$xml=simplexml_load_string($result) or die("Error: Cannot create object");	

									debugLogger($Web_Service_URL);
									debugLogger("API RESPONSE .. ");
									debugLogger($xml);

									$arrival = strtr($xml->Guest->Arrival, '/', '-');
									$departure = strtr($xml->Guest->Departure, '/', '-');
									$first_name = $xml->Guest->FirstNames;
									$last_name = $xml->Guest->LastName;
									$rate_plan = $xml->Guest->RatePlan;
								
									if(trim($xml->Guest->Identifier) != "")
									{
										debugLogger("ADD DEVICE .. ");	
										$add_sql = "REPLACE INTO hotspot_device(hotel_code,room_no,mac, description, arrival, departure) VALUES('".$hotel_no."', '".$room_no."', '".$mac_add."', '".$device_desc."', '".date('Y-m-d H:i:s', strtotime($arrival))."', '".date('Y-m-d H:i:s', strtotime($departure))."')";
										debugLogger($add_sql);	
								
										if ($db->query($add_sql) != TRUE) 
										{
											$error .= "<li>".$db->error."</li>";
										}									
									
										if(!get_user_db($hotel_no, $room_no, $mac_add))
										{
											$log_arr = array(
														"remote_addr" => "000.000.000.000",
														"hotel_code" => $hotel_no,
														"ip_addr" => "000.000.000.000",
														"mac" => $mac_add,						
														"user_name" => $mac_add,
														"room_no" => $room_no,
														"first_name" => (string) $first_name[0],
														"last_name" => (string) $last_name[0],
														"rate_plan" => (string) $rate_plan[0],
														"bytes_in" => 0,
														"bytes_out" => 0,
														"arrival" => date('Y-m-d H:i:s', strtotime($arrival)),
														"departure" => date('Y-m-d H:i:s', strtotime($departure)),
														"status" => "A"
													);	
										
											debugLogger("ADD DEVICE TO DATABASE");
											debugLogger($log_arr);													
											$reply = log_hotspot_user($log_arr);
											debugLogger($reply);	
										}

										debugLogger("FIND DEVICE IN HOTSPOT");
									
										$find_user = find_hotspot_user($mac_add);
									
										debugLogger($find_user);
									
										if(empty($find_user))
										{
											$premium = get_user_premium($hotel_no, $room_no);
						
											if($premium === true)
											{
												$profile = "premium";
											}
											else
											{
												$profile = "standard";
											}
										
											$timelimit = floor((strtotime($departure) - time())/3600/24);
											$timelimit = $timelimit + 1;
											$timelimit = $timelimit."d";
											$bytes = convertToBytes((string) $rate_plan[0]);
						
											debugLogger("ADD DEVICE TO HOTSPOT ...");							
											$login_args = $mac_add."-".$bytes."-".$timelimit."-".$mac_add."-".$profile;
											debugLogger($login_args);
										
											$user_list = add_user_to_hotspot($mac_add,$bytes,$timelimit,$mac_add,$profile);
						
											debugLogger($user_list);
						
											if($user_list != "0")
											{
												$status = "DEVICE ADDED TO HOTSPOT WITH PROFILE ".$profile." SUCCESSFULLY";
												debugLogger($status);

												$user_host = remove_hotspot_host($mac_add);	
											}
										}					
									}
									else
									{
										$error .= "<li>Room NOT occupied.</li>";
									}
								}
							}

							if(trim($error) != "")
							{
								$error = "<ul>".$error."</ul>";
								$string .= "<table width='100%'><tr><td class='isa_error'>".$error."</td></tr></table>";
							
								debugLogger($error);
							}

							debugLogger("EXISTING DEVICES ... ");
							$sql = "SELECT * FROM hotspot_device WHERE hotel_code = '".$hotel_no."' AND room_no = '".$room_no."' LIMIT ".$display_limit.",20";
							debugLogger($sql);	

							if ($result = mysqli_query($db, $sql))
							{
								$string .= "<br/><br/><br/><br/><table width='100%' id='login_status'>
											<tr>
												<th>&nbsp;&nbsp;#&nbsp;&nbsp;</th>											
												<th>
													Hotel Code
												</th>
												<th>
													Room #
												</th>												
												<th>
													MAC
												</th>
												<th>
													Status
												</th>
												<th>
													Description
												</th>												
												<th>
													Date/Time
												</th>
												<th>
													&nbsp;
												</th>
											</tr>";
									
								if (mysqli_num_rows($result) > 0) 
								{		
									$counter = 1;
									while($row = mysqli_fetch_assoc($result)) 
									{
											$user_status = array();
											$user_status = find_hotspot_active_user($row['mac']);
											
											if(($user_status != 0)&&(!empty($user_status)))
											{
												$login_status = "LOGGED IN";
											}
											else
											{
												$login_status = "LOGGED OFF";
											}
											
											debugLogger("DEVICE STATUS: ");
											debugLogger($login_status);
											
											echo "<script>function confirm_remove() { if(confirm('Are you sure?')){window.location='remove_device.php?hotel_code=".$row['hotel_code']."&room_no=".$row['room_no']."&mac=".$row['mac']."';} }</script>";
											
											$string .= "<tr><td>".$counter++."</td><td>".$row["hotel_code"]."</td><td>".$row["room_no"]."</td><td>".$row['mac']."</td><td>".$login_status."</td><td>".$row['description']."</td><td>".$row['created_date']."</td><td><a href='javascript:void(0)' onclick='confirm_remove();'>Remove</a></td></tr>";
									}
									
									$string .= "<tr><td colspan='8'><table><td width='50%'><input id='authenticate_prev' name='authenticate_prev' value='Previous' type='submit' ><input type='hidden' id='row_display' name='row_display' value='".$display_limit."'></td><td><input id='authenticate_next' name='authenticate_next' value='Next' type='submit' ><input type='hidden' id='hotel_code' name='hotel_code' value='".$hotel_code."'><input type='hidden' id='room_code' name='room_code' value='".$room_code."'></td></table></td></tr>";
									
								}
								else
								{
									$string .= "<tr><td colspan='8'>No Records Found!</td></tr>";
									debugLogger("No Records Found!");
								}	
								
									
								
								$string .= "</table>";
							}

							echo $string; 
						}
						else
						{
					?>

					<?php
						}
					?>
					<input type="hidden" name="last" id="last" value="" />
			</section>
			<footer>
				<table id="footer_table" width="100%">
					<tr>
						<td>
							<input id="cancel" value="Cancel" onclick="window.location='admin.php';" type="button">
						</td>
						<td>
							<input id="logout" value="Log Out" onclick="window.location='index.php';" type="button">
						</td>
					</tr>
				</table>
			</footer>
		</div>
		<?php
			}
			else
			{
				echo "<script>window.location='index.php';</script>";
			}
		?>
    </body>
	<script>
	$(document).ready(function ($) 
	{	
		$("#mac_add").change(function() 
		{
			$("#row_display").val(0);		

			var regexp = /^(([A-Fa-f0-9]{2}[:]){5}[A-Fa-f0-9]{2}[,]?)+$/i;
			var mac_address = $(this).val();
			
			if(!regexp.test(mac_address)) 
			{
				$("#error_label").empty();
				$("#error_label").html("<span class='isa_error'>Please use correct MAC address</span>");				
				//invalid!
			}
			else
			{
				$("#error_label").empty();
			}			
		});
		
		$("#hotel_no").change(function() 
		{
			$("#hotel_code").val($("#hotel_no").val());
			$("#mac_add").val("");
			$("#room_no").val("");
			$("#device_desc").val("");
		});
		
		$("#room_no").change(function() 
		{
			$("#room_code").val($("#room_no").val());
		});		
		
	});	
	</script>
</html>