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
				<h2 class="form_title">Hotspot User Status</h2>
				    <p>&nbsp;</p>
										
					<form class="change_form" id="status_form" name="status_form" method="POST" action="">
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
							<p><input id="user_status" name="user_status" value="Hotspot User Status" type="submit" ></p>
						</div>
					</form>
					<?php
						if($_SERVER['REQUEST_METHOD'] === 'POST')
						{	
							$hotel_code = ms_escape_string($_POST['hotel_code']);
							$room_code = $_POST['room_no'];
					
							$sql = "SELECT * FROM hotspot_log WHERE hotel_code = '".$hotel_code."' AND room_no = '".$room_code."' ORDER BY id DESC";
							//echo "<script>console.log('".$sql."');</script>";
							if ($result = mysqli_query($db, $sql))
							{
								$string = "<br/><br/><br/><table id='login_status' width='100%'>
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
													First Name
												</th>												
												<th>
													Last Name
												</th>
												<th>
													IP
												</th>
												<th>
													Idle Time
												</th>
												<th>
													Time Left
												</th>												
												<th>
													Login Status
												</th>
												<th>
													Date/Time
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
											$string .= "<tr><td>".$counter++."</td><td>".$row["hotel_code"]."</td><td>".$row['room_no']."</td><td>".$row['mac']."</td><td>".$row['first_name']."</td><td>".$row['last_name']."</td><td>".$user_status[0]['address']."</td><td>".$user_status[0]['idle-time']."</td><td>".$user_status[0]['session-time-left']."</td><td>".$login_status."</td><td>".subtract_time_from_current($user_status[0]['uptime'])."</td></tr>";
										}
										else
										{
											$login_status = "NOT LOGGED IN";
											$string .= "<tr><td>".$counter++."</td><td>".$row["hotel_code"]."</td><td>".$row['room_no']."</td><td>".$row['mac']."</td><td>".$row['first_name']."</td><td>".$row['last_name']."</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>".$login_status."</td><td>".$row['log_date']."</td></tr>";
											
										}
									}
								}
								else
								{
									$string .= "<tr><td colspan='11'>No Records Found!</td></tr>";
								}	
								
									
								
								$string .= "</table>";
							}

							echo $string; 
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