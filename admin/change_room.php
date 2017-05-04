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
			date_default_timezone_set('Australia/Sydney');
			
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
				<h2 class="form_title">Remove Room Accounts</h2>
				    <p>&nbsp;</p>
					<?php
						require_once("config.php");
								
						$db = mysqli_connect($MYSQLSVR,$MYSQLUSR,$MYSQLPWD,$MYSQLDBS);
	
						if($db->connect_error) 
						{
							echo "<script>console.log('".$db->connect_error."');</script>";
							die('Error : ('.$db->connect_errno.')'.$db->connect_error);
						}
						
						echo "<script>console.log('REQUEST: ".$_SERVER['REQUEST_METHOD']." JQ BIT: ".$_POST['jq_bit']."');</script>";
						
						if(($_SERVER['REQUEST_METHOD'] == 'POST') && (!isset($_POST['hidden_btn'])) && ($_POST['jq_bit'] == '1'))
						{	
							$string = "User Account has been removed from the system. Customer will need to log on to Hotspot with their new details.";
						?>
							<p name="acct_msg" id="acct_msg" class="change_form"><?php echo $string; ?></p>						
						<?php
						}
						else
						{
					?>
					
					<form class="change_form" id="change_room_form" name="change_room_form" method="POST" action="">
						<div id="post_msg" name="post_msg"></div>
						<div>
							<label for='hotel_no'>Hotel <span class='required'>(required)</span></label>
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
							<input type="hidden" name="hotel_code" id="hotel_code" value="" />
						</div>
						<div>
							<label for='room_no'>Room No <span class='required'>(required)</span></label>
							<input type='text' name='room_no' id='room_no' placeholder='Room No #' required />
							<input type="hidden" name="room_code" id="room_code" value="" />
							<input type="hidden" name="jq_bit" id="jq_bit" value="" />
						</div>
						<div>
							<label for='last_name'>Last Name  <span class='required'>(required)</span></label>
							<input type='text' name='last_name' id="last_name" placeholder='Last name here' required />
						</div>
						<div>
							<span id="loading-state"><img src="/images/loading.gif"/>Loading...</span>
						</div>
						<div>
							<p><input id="change_room" name="change_room" value="Remove Room Account" type="button" ></p>
							<p><button id="hidden_btn" name="hidden_btn" type="submit" class="hide" ></button></p>
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
	$(document).ready(function ($) 
	{
		$("#loading-state").hide();
	});
	
	$("#hotel_no").change(function() 
	{
		$("#hotel_code").val($("#hotel_no").val());
	});
	
	$("#room_no").change(function() 
	{
		$("#room_code").val($("#room_no").val());
	});	
	
	$("#last_name").change(function() 
	{
		$("#last").val($("#last_name").val());
	});
	
	
	$("#change_room").click(function()
	{
		var hotel = $("#hotel_code").val();
		var room = $("#room_code").val();
		var last_name = $("#last").val();
		
		if((hotel != "")&&(room != "")&&(last_name != ""))
		{
			$("#loading-state").show();
			
			$.ajax(
			{
				type: 'POST',
				url: 'user_info.php',
				dataType: "json",
				data:
				{
					'hotel_no': hotel,
					'room_no': room,
					'last_name': last_name
				},
				success: function(data)
				{					
					if(data.result == 1)
					{
						$("#post_msg").text("");
						$("#jq_bit").val("1");
						last = data.last_name;
						room = data.room_no;
						hotel = data.hotel_code;
						var error = data.error;


						$.ajax(
						{
							url: "db_remove_hotspot_user.php",
							type: "GET",
							data: { 
								last_name: last,
								room_no: room,
								hotel_no: hotel 	
							},
							success: function(response) 
							{
								var data = $.parseJSON(response);

								$.ajax(
								{
									url: 'log_rec.php',
									type: 'post',
									data: { 
										"log_line": data.log
									},
									success: function(response) 
									{ 
										console.log(response);
								
										if(data.error == "")
										{
											$("#jq_bit").val("1");
										}
										else
										{
											$("#jq_bit").val("0");
										}								
									}
								});	
								
								$("#jq_bit").val("1");		
							},
							complete: function (data) 
							{	
								if($("#jq_bit").val()==1)
								{
									$("#change_room_form").submit();
								}
							}							
							//timeout: 60000	
						});						
					}
				},
				complete: function(data)
				{
					$("#loading-state").hide();
				}
			});		
		}
		else
		{
			$('#change_room_form [type="submit"]').trigger('click');
		}	
	});
	</script>
</html>