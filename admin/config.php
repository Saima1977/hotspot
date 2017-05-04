<?php
$admin = array(
			"hotspot_admin" => "0pt1m1zed",
			"raghur@fuzenet.com.au" => "dJDbDnjv",
			"mujtabas@fuzenet.net.au" => "YQb76ryi",
			"abdulh@fuzenet.net.au" => "FKnKRwZg",
			"alik@fuzenet.net.au" => "V0vYzSDi",
			"arunb@fuzenet.net.au" => "LzATn6BQ",
			"chetanm@fuzenet.net.au" => "0NpSerON",
			"erikp@fuzenet.net.au" => "FpLAHlEI",
			"gagans@fuzenet.net.au" => "Sz7fUgmI",
			"immadk@fuzenet.net.au" => "vpdc2Zes",
			"sudans@fuzenet.net.au" => "FISTVUzm",
			"omerm@fuzenet.net.au" => "GPCJOngw",
			"ravikanthc@fuzenet.net.au" => "6WphJuhN",
			"shas@fuzenet.net.au" => "z5iiSJvg",
			"sunnyg@fuzenet.net.au" => "hoR2iU2i",
			"syeda" => "ecPeTV38",
			"jamilm" => "rd54sk3Q",
			"rahulm" => "U5Mwb6a7",
			"mohammeda" => "4FUcJ8rG",
			"beckys" => "NyyYbDd1",
			"shariqm" => "KkrYX1bF"	
);

$admin_uname = "hotspot_admin";
$admin_pword = "0pt1m1zed";
define("MERITON_API_URL","https://ggws.meriton.com.au");
define("HOTSPOT", "163.53.34.1");
define("HS_USER", "wifiapi");
define("HS_PASSWORD", "meta2498");
define("HOTSPOT_DB_HOST","172.20.184.72");
define("HOTSPOT_DB_USER","saimas");
define("HOTSPOT_DB_PW","4UDwLszVLeRVDYuU");
define("HOTSPOT_DB", "hotspot");
define("HOTSPOT_TABLE","hotspot_log");
$MYSQLSVR = "172.20.184.72";
$MYSQLUSR = "saimas";
$MYSQLPWD = "4UDwLszVLeRVDYuU";
$MYSQLDBS = "hotspot";

function ms_escape_string($data) 
{
 	if ( !isset($data) or empty($data) ) return '';
    if ( is_numeric($data) ) return $data;

    $non_displayables = array(
            '/%0[0-8bcef]/',            // url encoded 00-08, 11, 12, 14, 15
            '/%1[0-9a-f]/',             // url encoded 16-31
            '/[\x00-\x08]/',            // 00-08
            '/\x0b/',                   // 11
            '/\x0c/',                   // 12
            '/[\x0e-\x1f]/'             // 14-31
        );
    
	foreach($non_displayables as $regex)
    	$data = preg_replace( $regex, '', $data );
     
	$data = str_replace("'", "''", $data );
	return $data;
}
?>
