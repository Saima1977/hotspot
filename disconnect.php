<?php
require_once ('mikrotik_functions.php');
require_once ('additional_functions.php');

$last_name = $_POST['last_name'];
$user_list = remove_hotspot_active_user($last_name);
?>