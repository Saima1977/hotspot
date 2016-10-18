<?php
define("HOTSPOT", "172.20.200.169");
define("HS_USER", "admin");
define("HS_PASSWORD", "s3cur3BSR");
define("APP_PREFIX", "HOTSPOT_");
define("LOG_EXT", ".log");
define("WIN_LOG_DIR", "C:\\tmp\\");
define("LOG_DIR", "/tmp/");
define("HOTSPOT_DB_HOST","127.0.0.1");
define("HOTSPOT_DB_USER","root");
define("HOSTSPOT_DB_PW","");
define("HOTSPOT_DB", "test");
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