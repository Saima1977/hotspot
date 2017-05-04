<?php
require_once ('mikrotik_functions.php');

$user = list_hotspot_users();
$active_user = list_hotspot_active_users();

foreach($user as $num=>$arr)
{
	if(isset($arr['mac-address']))
	{
		if($arr['mac-address'] == 'D0:22:BE:D9:BF:66')
		{
			echo "-HEY WE MATCHED-\n";
		}
	}
}

?>