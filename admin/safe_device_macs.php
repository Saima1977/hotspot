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
			session_start();
			
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
				<h2 class="form_title">House Keeping(HK) Devices</h2>
				    <p>&nbsp;</p>
										
					<form class="change_form" id="device_form" name="device_form" method="POST" action="">
					<?php
						require_once("config.php");
						require_once("mikrotik_functions.php");
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
						<div id="add_action">
							<label for='add_action'>Action <span class='required'>(required)</span></label>
							<select id="action" name="action"  required>
								<option value="SEARCH">Search HK MAC</option>
								<option value="ADD">Add HK MAC</option>
								<!--option value="DELETE">Delete Safe MAC</option-->
							</select>
						</div>							
						<div id="add_mac">
							<label for='room_no'>MAC Address <span class='required'>(required)</span></label>
							<input type='text' name='mac_add' id='mac_add' placeholder='00:00:00:00:00:00' value="<?php echo (isset($_POST['mac_add']))?$_POST['mac_add']:""; ?>" required />

							<input type="hidden" name="jq_bit" id="jq_bit" value="" />
						</div>						
						<div width='100%'>
							<input id='search_safe_macs' name='search_safe_macs' value='Start' type='submit' >
						</div>
					</form>					
						
					<?php						
						if($_SERVER['REQUEST_METHOD'] === 'POST')
						{	
							$hotel_code = ms_escape_string($_POST['hotel_code']);
							
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
								$mac_add = ms_escape_string($_POST['mac_add']);
								$add_sql = "INSERT INTO hotspot_safe(mac,hotel_code) VALUES('".$mac_add."','".$hotel_code."')";
								
								if ($db->query($add_sql) != TRUE) 
								{
									//echo "Error: ".$add_sql."<br>".$db->error;
									$string .= "<table width='100%'><tr><td>".$db->error."</td></tr></table>";
								}
							}
					
					
							$sql = "SELECT * FROM hotspot_safe WHERE hotel_code = '".$hotel_code."' LIMIT ".$display_limit.",20";

							if ($result = mysqli_query($db, $sql))
							{
								$string .= "<br/><br/><br/><br/><table width='100%' id='login_status'>
											<tr>
												<th>&nbsp;&nbsp;#&nbsp;&nbsp;</th>											
												<th>
													Hotel Code
												</th>
												<th>
													MAC
												</th>
												<th>
													Status
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
											}
											else
											{
												$login_status = "LOGGED OFF";
											}
											
											$string .= "<tr><td>".$counter++."</td><td>".$row["hotel_code"]."</td><td>".$row['mac']."</td><td>".$login_status."</td><td>".$row['created_date']."</td></tr>";
									}

									
									$string .= "<tr><td colspan='5'><table><td width='50%'><input id='authenticate_prev' name='authenticate_prev' value='Previous' type='submit' ><input type='hidden' id='row_display' name='row_display' value='".$display_limit."'></td><td><input id='authenticate_next' name='authenticate_next' value='Next' type='submit' ><input type='hidden' id='hotel_code' name='hotel_code' value='".$hotel_code."'></td></table></td></tr>";
									
								}
								else
								{
									$string .= "<tr><td colspan='5'>No Records Found!</td></tr>";
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
				<!--div style="display:inline-block;width:50%;">
					<input id="cancel" value="Cancel" onclick="window.location='admin.php';" type="button">
				</div>
				<div id="right_div" name="right_div" style="display:inline-block;">
					<input id="logout" value="Log Out" onclick="window.location='index.php';" type="button">
				</div-->
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
		$('#add_mac').hide();
		$('#mac_add').prop('required', false);
		
		$("#action").change(function() 
		{
			if($(this).val() == 'ADD')
			{
				$('#add_mac').show();
				$('#mac_add').val("");
				$('#mac_add').prop('required', true);
			}
			else
			{
				$('#add_mac').hide();
				$('#mac_add').prop('required', false);				
			}
		});
		
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
		});
	});	
	</script>
</html>