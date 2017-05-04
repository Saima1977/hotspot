<?php
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Hotspot Admin Utility</title>
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
				$dir_path = $dir."HS_ADMIN_ADD_NOAUTH_".date('dmY',time()).".log";
	
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
				<h2 class="form_title">Add Hotel to No Authentication</h2>
				    <p>&nbsp;</p>
										
					<form class="change_form" id="device_form" name="device_form" method="POST" action="">
					<?php
						require_once("config.php");
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
						<div width='100%'>
							<input id="action" name="action" type="hidden" value="ADD"/>
							<input id='add_hotel_noauth' name='add_hotel_noauth' value='Add Hotel' type='submit' >
						</div>
					</form>					
						
					<?php						
						if($_SERVER['REQUEST_METHOD'] === 'POST')
						{	
							debugLogger("Add Hotel to No Authentication ....... ");			
							
							$hotel_no = ms_escape_string($_POST['hotel_no']);
							
							debugLogger("HOTEL CODE: ");
							debugLogger($hotel_no);

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
								
								debugLogger("ADD HOTEL TO NO AUTHENTICATION .. ");	
								
								$add_sql = "REPLACE INTO hotspot_hotel_noauth(hotel_code) VALUES('".$hotel_no."')";
								
								debugLogger($add_sql);	
								
								if ($db->query($add_sql) != TRUE) 
								{
									$error .= "<li>".$db->error."</li>";
								}									
												
							}

							if(trim($error) != "")
							{
								$error = "<ul>".$error."</ul>";
								$string .= "<table width='100%'><tr><td class='isa_error'>".$error."</td></tr></table>";
							
								debugLogger($error);
							}

							debugLogger("EXISTING HOTELS ... ");
							$sql = "SELECT * FROM hotspot_hotel_noauth LIMIT ".$display_limit.",20";
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
										echo "<script>function confirm_remove() { if(confirm('Are you sure?')){window.location='remove_noauth_hotel.php?hotel_code=".$row['hotel_code']."';} }</script>";
											
										$string .= "<tr><td>".$counter++."</td><td>".$row["hotel_code"]."</td><td>".$row['created_date']."</td><td><a href='javascript:void(0)' onclick='confirm_remove();'>Remove</a></td></tr>";
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
</html>