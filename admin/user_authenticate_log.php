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
				<h2 class="form_title">User Authentication Log</h2>
				    <p>&nbsp;</p>
										
					<form class="change_form" id="authenticate_form" name="authenticate_form" method="POST" action="">
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
							$hotel_code = ms_escape_string($_POST['hotel_code']);
							$room_code = isset($_POST['room_no'])?$_POST['room_no']:$_POST['room_code'];
							
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
					
							//$sql = "SELECT * FROM hotspot_login WHERE hotel_code = '".$hotel_code."' and room_no = '".$room_code."' and created_date < NOW() ORDER BY created_date DESC LIMIT ".$display_limit.",10";
							$sql = "SELECT * FROM hotspot_login WHERE hotel_code = '".$hotel_code."' and room_no = '".$room_code."' and created_date < NOW() ORDER BY id DESC LIMIT ".$display_limit.",10";
							echo "<script>console.log('".$sql."');</script>";
							if ($result = mysqli_query($db, $sql))
							{
								$string = "<table id='login_status'>
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
													Last Name
												</th>
												<th>
													API Output
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
									$counter = 1+$display_limit;
									while($row = mysqli_fetch_assoc($result)) 
									{
		
											$login = ($row['status'] == 1)?"Success":"Failed";
											$string .= "<tr><td>".$counter++."</td><td>".$row["hotel_code"]."</td><td>".$row['room_no']."</td><td>".$row['mac']."</td><td>".$row['last_name']."</td><td name='td_pre'><pre>". htmlentities($row['api_output'])."</pre></td><td>".$login."</td><td>".$row['created_date']."</td></tr>";
									}

									
									$string .= "<tr><td colspan='8'><table><td width='50%'><input id='authenticate_prev' name='authenticate_prev' value='Previous' type='submit' ><input type='hidden' id='row_display' name='row_display' value='".$display_limit."'></td><td><input id='authenticate_next' name='authenticate_next' value='Next' type='submit' ><input type='hidden' id='hotel_code' name='hotel_code' value='".$hotel_code."'><input type='hidden' id='room_code' name='room_code' value='".$room_code."'></td></table></td></tr>";
									
								}
								else
								{
									$string .= "<tr><td colspan='8'>No Records Found!</td></tr>";
								}	
								
									
								
								$string .= "</table>";
							}

							echo $string; 
						}
						else
						{
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
							<p><input id="get_authenticate_log" name="get_authenticate_log" value="Check Authentication Log" type="submit" ></p>
						</div>
					</form>
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