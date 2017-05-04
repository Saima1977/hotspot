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
				<h2 class="form_title">Find Room</h2>
				    <p>&nbsp;</p>
										
					<form class="change_form" id="authenticate_form" name="authenticate_form" method="POST" action="">
						<div id="post_msg" name="post_msg"></div>
						<div>
							<label for='room_no'>MAC Address <span class='required'>(required)</span></label>
							<input type='text' name='mac_add' id='mac_add' placeholder='00:00:00:00:00:00' value="<?php echo (isset($_POST['mac_add']))?$_POST['mac_add']:""; ?>" required />

							<input type="hidden" name="jq_bit" id="jq_bit" value="" />
						</div>
						<div>
							<p><label id="error_label"></label></p>
						</div>							
						<div>
							<p><input id="get_room" name="get_room" value="Find Room" type="submit" ></p>
						</div>					
					<?php
						require_once("config.php");
						$display_limit = 0;
								
						$string = "";
						
						$db = mysqli_connect($MYSQLSVR,$MYSQLUSR,$MYSQLPWD,$MYSQLDBS);
	
						if($db->connect_error) 
						{
							echo "<script>console.log('".$db->connect_error."');</script>";
							die('Error : ('.$db->connect_errno.')'.$db->connect_error);
						}
											
						if($_SERVER['REQUEST_METHOD'] === 'POST')
						{	
							$mac_add = ms_escape_string($_POST['mac_add']);
							
							if(isset($_POST['rooms_prev']))
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
							if(isset($_POST['rooms_next']))
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
					
							//$sql = "SELECT * FROM hotspot_login WHERE hotel_code = '".$hotel_code."' and room_no = '".$room_code."' and created_date < NOW() ORDER BY created_date DESC LIMIT ".$display_limit.",10";
							$sql = "SELECT * FROM hotspot_log WHERE UPPER(mac) = '".strtoupper($mac_add)."' ORDER BY id DESC LIMIT ".$display_limit.",10";
	
							if ($result = mysqli_query($db, $sql))
							{
								$string = "<table id='login_status' width='100%'>
											<tr>
												<th>&nbsp;&nbsp;#&nbsp;&nbsp;</th>											
												<th>
													Hotel
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
													Arrival
												</th>
												<th>
													Departure
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
		
											$login = ($row['status'] == 1)?"Success":"Failed";
											$string .= "<tr><td>".$counter++."</td><td>".$row["hotel_code"]."</td><td>".$row['room_no']."</td><td>".$row['mac']."</td><td>".$row['first_name']."</td><td>".$row['last_name']."</td><td>".$row['arrival']."</td><td>".$row['departure']."</td><td>".$row['log_date']."</td></tr>";
									}

									
									$string .= "<tr><td colspan='9'><table><td width='50%'><input id='rooms_prev' name='rooms_prev' value='Previous' type='submit' ><input type='hidden' id='row_display' name='row_display' value='".$display_limit."'></td><td><input id='rooms_next' name='rooms_next' value='Next' type='submit' ></td></table></td></tr>";
								}
								else
								{

									$string .= "<tr><td colspan='9'>No Records Found!</td></tr>";

								}	
								
									
								
								$string .= "</table>";
							}

							echo $string; 
						}
					?>
					</form>

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
	});
	</script>
</html>