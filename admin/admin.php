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
	</head>
    <body bgcolor="#e6e6e6">
		<?php
			if($_SESSION['successful'] == 1)
			{
		?>
		<div class="header-container overlay">
			<div class="txt-container">
				<p>Hotspot Utility Tool</p>
			</div>
		</div>	
		<div id="pagewrap">
			<header>
			</header>
			<section id="content">
				<h2>Remove Room Accounts</h2>
				<p>Current room details will be removed from database in order to sync with new details in next login.</p>
				<p><input id="change_room" value="Change Details" onclick="window.location='change_room.php';" type="button"></p>
			</section>
			<section id="middle">
				<h2>User Authentication Log</h2>
				<p>Hotel and Room number is used for the customer to authenticate the status by using Meriton API.</p>
				<p><input id="authenticate_customer" value="Authentication Log" onclick="window.location='user_authenticate_log.php';" type="button"></p>	
			</section>
			<aside id="sidebar">
				<h2>Change Account Type</h2>
				<p>Customer account type is changed to Standard/Premium as requested by customer.</p>
				<p><input id="change_account" value="Change Account" onclick="window.location='change_user_account.php';" type="button"></p>
			</aside>
			<section id="content">
				<h2>Find Room Number</h2>
				<p>Customer MAC is provided to find originating room.</p>
				<p><input id="find_room" value="Find Room" onclick="window.location='find_room.php';" type="button"></p>
			</section>
			<section id="middle">
				<h2>Hotspot User Status</h2>
				<p>Hotel and Room number is required to find the status of the devices.</p>
				<p><input id="authenticate_customer" value="User Status" onclick="window.location='user_status.php';" type="button"></p>	
			</section>
			<aside id="sidebar">
				<h2>House Keeping MAC(s)</h2>
				<p>MAC of the devices are added to skip initial authentication.</p>
				<p><input id="safe_mac" value="Safe MAC(s)" onclick="window.location='safe_device_macs.php';" type="button"></p>
			</aside>
			<section id="content">
				<h2>Add/Remove Device(s)</h2>
				<p>Devices such as Apple TV can be added through MAC along with Hotel and Room.</p>
				<p><input id="add_device" value="Add Device(s)" onclick="window.location='add_device_macs.php';" type="button"></p>
			</section>			
			<footer>
				<p><input id="log_out" value="Log Out" onclick="window.location='index.php';" type="button"></p>
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