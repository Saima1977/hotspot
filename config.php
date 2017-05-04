<?php
//define("HOTSPOT", "172.20.200.169");
//define("HOTSPOT", "172.25.60.125");
define("HOTSPOT", "163.53.34.1");
define("HS_USER", "wifiapi");
define("HS_PASSWORD", "meta2498");
define("APP_PREFIX", "HOTSPOT_");
define("HOTSPOT_PREFIX", "ROUTER_LOG_");
define("ADMIN_PREFIX", "HOTSPOT_ADMIN_");
define("LOG_EXT", ".log");
define("WIN_LOG_DIR", "C:\\tmp\\");
//define("LOG_DIR", "/tmp/");
define("LOG_DIR", "/var/www/hotspot/log/");
define("HOTSPOT_DB_HOST","172.20.184.72");
define("HOTSPOT_DB_USER","saimas");
define("HOTSPOT_DB_PW","4UDwLszVLeRVDYuU");
define("HOTSPOT_DB", "hotspot");
define("HOTSPOT_TABLE","hotspot_log");
define("MERITON_API_URL","https://ggws.meriton.com.au");

if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') 
{
	$crt = substr(__FILE__, 0, strrpos( __FILE__, '\\'))."\crt\cacert.pem"; // WIN
}
else
{
	$crt = str_replace('\\', '/', substr(__FILE__, 0, strrpos( __FILE__, '/')))."/crt/cacert.pem"; // *NIX
}

define("SSL_CERT_PATH", $crt);

?>
