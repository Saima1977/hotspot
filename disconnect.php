<?php
require_once ('mikrotik_functions.php');
require_once ('additional_functions.php');

$mac = $_GET['mac_address'];

$user_list = remove_hotspot_active_user($mac);
?>