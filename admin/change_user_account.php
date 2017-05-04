<?php
	session_start();
	date_default_timezone_set('Australia/Sydney');
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
			require_once ('/var/www/hotspot/docroot/mikrotik_functions.php');
			require_once ('/var/www/hotspot/docroot/additional_functions.php');	
			require_once("config.php");			
			
			$change_room = true;
			
			if($_SESSION['successful'] == 1)
			{
		?>
		<div class="header-container overlay">
			<div class="txt-container">
				<p>Hotspot Utility Tool</p>
			</div>
		</div>	
		<div id="pagewrap">
			<section id="content_form">
				<h2 class="form_title">Change Account Type</h2>
				    <p>&nbsp;</p>
										
					<form class="change_form" id="change_account_form" name="change_account_form" method="POST" action="">
			<?php

								
								
				$string = "";
				$departure = "";
						
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
										
								<option value="<?php echo $val[0]; ?>"><?php echo $val[1]." (".$state.")"; ?></option>
				<?php
						}
					}
				?>
							</select>
						</div>
						<div>
							<label for='room_no'>Room No <span class='required'>(required)</span></label>
							<input type="hidden" name="room_code" id="room_code" value="" />
							<input type='text' name='room_no' id='room_no' placeholder='Room No #' required />

							<input type="hidden" name="jq_bit" id="jq_bit" value="" />
						</div>
						<div>
							<label for='room_no'>Account Type <span class='required'>(required)</span></label>
							<select name="account_type" id="account_type" required>
							<option value="">---</option>
							<option value="standard">Standard</option>
							<option value="premium">Premium</option>
							</select>
							<input type="hidden" name="jq_bit" id="jq_bit" value="" />
						</div>						
						<div>
							<p><input id="change_account" name="change_account" value="Change User Account" type="submit" ></p>
						</div>
					</form>
				<?php
				if($_SERVER['REQUEST_METHOD'] === 'POST')
				{
					$hotel_code = ms_escape_string($_POST['hotel_code']);
					$room_code = ms_escape_string($_POST['room_code']);
					$account_type = ms_escape_string($_POST['account_type']);
														
					$stmt = " Request to remove current account from Room: ".$room_code." from Hotel Code ".$room_code." to type ".$account_type."\r\n";

					
					$url = "https://ggws.meriton.com.au";
					$Web_Service_URL = $url.'/?hotel='.$hotel_code.'&room='.$room_code;
	
					// Init the cURL session
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $Web_Service_URL);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
					curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_0); 
					curl_setopt($ch, CURLOPT_HEADER, 0); // Don’t return the header, just the html
	
					if(strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') 
					{
						$crt = substr(__FILE__, 0, strrpos( __FILE__, '\\'))."\crt\cacert.pem"; // WIN
					}
					else
					{
						$crt = str_replace('\\', '/', substr(__FILE__, 0, strrpos( __FILE__, '/')))."/crt/cacert.pem"; // *NIX
					}

					// The cert path is relative to this file
					curl_setopt($ch, CURLOPT_CAINFO, $crt); // Set the location of the CA-bundle
					curl_setopt($ch, CURLOPT_TIMEOUT, 60);
					curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

					if(($result = curl_exec($ch)) === FALSE) 
					{
						$data['result'] = 0;
						die('cURL error: '.curl_error($ch)."<br />");
					}	 

					curl_close($ch);

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
								
						$string = "<div class='centered'><table id='account_status'>
										<tr>
											<th align='center'>
												Hotel Code
											</th>
											<th align='center'>
												Room #
											</th>
											<th align='center'>
												MAC
											</th>
											<th align='center'>
												First Name
											</th>											
											<th align='center'>
												Last Name
											</th>
											<th align='center'>
												Arrival Date
											</th>											
											<th align='center'>
												End Date
											</th>											
											<th align='center'>
												Account
											</th>											
										</tr>";
	
						if(count($xml->children() > 0))
						{
							$data['result'] = 1;
							$data['first_name'] = $first_name;
							$data['last_name'] = $last_name;
							$data['rate_plan'] = $rate_plan;
							$data['arrival'] = $arrival;
							$data['departure'] = $departure;
							$data['hotel_code'] = $hotel_code;
							$data['room_no'] = $room_code;
						}
						else
						{
							$data['result'] = 0;
						}
						
						$stmt .= date('d-m-Y H:i:s')." MERITON API returned ".$result."\r\n";
						

						if($data['result'] == 1)	
						{
							$departure = explode(" ", $departure);
					
							$departure = date_create_from_format('d/m/Y', $departure[0]);
							if($departure != FALSE)
							{
								$departure = date_format($departure, 'Y-m-d');					
							}

					
							$stmt .= date('d-m-Y H:i:s')." Departure Date: ".$departure."\r\n";
							$stmt .= date('d-m-Y H:i:s')." Today's Date: ".date('Y-m-d',time())."\r\n";
								
							if($departure > date('Y-m-d',time()))
							{
								$sql0 = "SELECT * FROM hotspot_log WHERE hotel_code = '".$hotel_code."' AND room_no = '".$room_code."' AND departure > CURDATE()";
								$stmt .= date('d-m-Y H:i:s')." Running Query ".$sql0."\r\n";
								
								if($result0 = mysqli_query($db, $sql0))
								{
									if (mysqli_num_rows($result0) > 0) 
									{												
										if(strtoupper($account_type) == "PREMIUM")
										{
											$account_arr = array(
												"hotel_code" => $hotel_code,
												"room_no" => $room_code,
												"end_date" => date("Y-m-d H:i:s",strtotime($departure))
											);
					
											$sql = "INSERT INTO hotspot_premium(".implode(",",array_keys($account_arr)).") VALUES ('".implode("','", $account_arr)."')";
											$stmt .= date('d-m-Y H:i:s').": Running Query ".$sql."\r\n";

											if($result = mysqli_query($db, $sql))
											{
												$sql1 = "SELECT hl.hotel_code hotel_code, hl.room_no room_no, hl.mac mac, hl.first_name first_name, hl.last_name last_name, hl.arrival arrival, hl.departure departure, 'PREMIUM' as 'status' FROM hotspot_log hl JOIN hotspot_premium hp ON hl.room_no = hp.room_no AND hl.hotel_code = hp.hotel_code WHERE hl.departure >= CURDATE() AND hl.hotel_code = '".$hotel_code."' AND hl.room_no = '".$room_code."'";
												$stmt .= date('d-m-Y H:i:s').": Running Query ".$sql1."\r\n";
											
												if($result1 = mysqli_query($db, $sql1))
												{
													$stmt .= date('d-m-Y H:i:s').": Rows returned ".mysqli_num_rows($result1)."\r\n";
													
													if (mysqli_num_rows($result1) > 0) 
													{									
														while($row1 = mysqli_fetch_assoc($result1)) 
														{
															$string .= "<tr><td>".$row1["hotel_code"]."</td><td>".$row1['room_no']."</td><td>".$row1['mac']."</td><td>".$row1['first_name']."</td><td>".$row1['last_name']."</td><td>".$row1['arrival']."</td><td>".$row1['departure']."</td><td>".$row1['status']."</td></tr>";
														}
													}
												}
												else												
												{
													$string .= "<tr><td colspan='8'>No Records Found!</td></tr>";
													$stmt .= date('d-m-Y H:i:s').": No Records Found!\r\n";
													$change_room = false;
												}
											}	
											else
											{
												$string .= "<tr><td colspan='8'>Customer account found as Premium.</td></tr>";
												$stmt .= date('d-m-Y H:i:s').": Customer account found as Premium.\r\n";
												$change_room = false;
											}
										}
										else
										{
											$sql = "DELETE FROM hotspot_premium WHERE hotel_code = '".$hotel_code."' AND room_no = '".$room_code."'";
											$stmt .= date('d-m-Y H:i:s').": Running Query ".$sql."\r\n";
											$result = mysqli_query($db, $sql);
									
											if(mysqli_affected_rows($result) > 0)
											{
												$sql1 = "SELECT hotel_code, room_no, mac, first_name, last_name, arrival, departure, 'STANDARD' as 'status' FROM hotspot_log WHERE departure > CURDATE() AND hotel_code = '".$hotel_code."' AND room_no = '".$room_code."'";
											
												$stmt .= date('d-m-Y H:i:s').": Running Query ".$sql1."\r\n";
											
												if($result1 = mysqli_query($db, $sql1))
												{
													$stmt .= date('d-m-Y H:i:s').": Rows returned ".mysqli_num_rows($result1)."\r\n";
													
													if (mysqli_num_rows($result1) > 0) 
													{									
														while($row1 = mysqli_fetch_assoc($result1)) 
														{
															$string .= "<tr><td>".$row1["hotel_code"]."</td><td>".$row1['room_no']."</td><td>".$row1['mac']."</td><td>".$row1['first_name']."</td><td>".$row1['last_name']."</td><td>".$row1['arrival']."</td><td>".$row1['departure']."</td><td>".$row1['status']."</td></tr>";
														}
																		
														$string .= "<tr><td colspan='8'>Record is removed from Premium</td></tr>";
														$stmt .= date('d-m-Y H:i:s').": Record is removed from Premium\r\n";								
													}
													else												
													{
														$string .= "<tr><td colspan='8'>No Records Found!</td></tr>";
														$stmt .= date('d-m-Y H:i:s').": No Records Found!\r\n";
														$change_room = false;
													}							
												}
												else												
												{
													$string .= "<tr><td colspan='8'>No Records Found!</td></tr>";
													$stmt .= date('d-m-Y H:i:s').": No Records Found!\r\n";
													$change_room = false;
												}					
											}
											else
											{
												$string .= "<tr><td colspan='8'>Customer account found as Standard.</td></tr>";
												$stmt .= date('d-m-Y H:i:s').": Customer account found as Standard.\r\n";
												$change_room = false;
											}	
										}
										
										if($change_room == true)
										{
											$sql2 = "REPLACE INTO hotspot_remove(room_no, hotel_code) VALUES('".$room_code."', '".$hotel_code."')";

											$stmt .= date('d-m-Y H:i:s').": Request to remove Room No: ".$room_code." from Hotel Code ".$hotel_code." From Hotspot\r\n";
											$stmt .= date('d-m-Y H:i:s').": Running Query ".$sql2."\r\n";

											if ($result2 = mysqli_query($db, $sql2))
											{
												$stmt .= date('d-m-Y H:i:s').": Room ".$room_code." from Hotel Code ".$hotel_code." queued to be removed from Hotspot\r\n";
											}
											else
											{
												echo "ERROR: Could not execute $sql2. ".mysqli_error($db);
												$data['error'] = mysqli_error($db);	
												$stmt .= date('d-m-Y H:i:s').": ".$data['error']."\r\n";
											}

											$sql3 = "UPDATE hotspot_log SET active = 0, status = 'D' WHERE room_no = '".$room_code."' AND hotel_code = '".$hotel_code."'";
											//$sql3 = "DELETE FROM hotspot_log WHERE room_no = '".$room_code."' AND hotel_code = '".$hotel_code."' AND departure > CURDATE()";
											$stmt .= date('d-m-Y H:i:s').": Request to deactivate Room No: ".$room_code." from Hotel Code ".$hotel_code." from Database\r\n";
											$stmt .= date('d-m-Y H:i:s').": Running Query ".$sql3."\r\n";

											if ($result2 = mysqli_query($db, $sql3))
											{
												$stmt .= date('d-m-Y H:i:s').": Room ".$room_code." from Hotel Code ".$hotel_code." is removed from Database\r\n";
											}
											else
											{
												echo "ERROR: Could not execute $sql3. ".mysqli_error($db);
												$data['error'] = mysqli_error($db);	
												$stmt .= date('d-m-Y H:i:s').": ".$data['error']."\r\n";
											}											
										}
									}
									else
									{
										$string .= "<tr><td colspan='8'>No active account is found.</td></tr>";
										$stmt .= date('d-m-Y H:i:s').": No active account is found.\r\n";
									}								
								}
							}
							else
							{
								$string .= "<tr><td colspan='8'>No Records can be found for future dates.</td></tr>";	
								$stmt .= date('d-m-Y H:i:s').": No Records can be found for future dates.\r\n";	
							}			
						}
						else
						{
							$string .= "<tr><td colspan='8'>Room is not currently occupied.</td></tr>";	
							$stmt .= date('d-m-Y H:i:s')." Room is not currently occupied.\r\n";	
						}
						
						$string .= "</table></div>";
						echo $string; 
						//mysqli_close($db);
					}
					else
					{
						$stmt .= date('d-m-Y H:i:s').": Meriton API Failed.\r\n";
					}
					
					$dir = "/var/www/hotspot/log/";
					$dir_path = $dir."HS_ADMIN_CHANGE_ACCOUNT_".date('dmY',time()).".log";
	
					if(!file_exists($dir) ) 
					{
						$oldmask = umask(0);  // helpful when used in linux server  
						mkdir($dir, 0744);
					}	
	
					$logLine = "\n".date("Y-m-d  H:i:s")."\tDEBUG\t".print_r($stmt, true)."\n\r";

					$success = file_put_contents($dir_path, $logLine, FILE_APPEND);
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
	$("#hotel_no").change(function() 
	{
		$("#hotel_code").val($("#hotel_no").val());
	});
	
	$("#room_no").change(function() 
	{
		$("#room_code").val($("#room_no").val());
	});	
	
	</script>
</html>