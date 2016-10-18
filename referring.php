<?php
require_once ('mikrotik_functions.php');
$user_list = limit_hotspot_user('192.168.0.252');

		echo "<pre>";
		print_r($user_list);
		echo "</pre>";
?>