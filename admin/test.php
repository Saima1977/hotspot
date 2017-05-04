<?php
			function debugLogger($stmt)
			{
				$dir = "/var/www/hotspot/log/";
				$dir_path = $dir."HS_ADMIN_DEVICE.log";
	
				if (!file_exists($dir) ) 
				{
					$oldmask = umask(0);  // helpful when used in linux server  
					mkdir($dir, 0744);
				}
				else
				{
					echo $dir_path." File Exists!<br/>";
				}
	
				$logLine = "\n".date("Y-m-d  H:i:s")."\tDEBUG\t".print_r($stmt, true)."\n\r";	

				$size = file_put_contents($dir_path, $logLine, FILE_APPEND |LOCK_EX);

				if ($size == FALSE)
				{
					return "Error writing file<br/>";
				}
				else
				{
					return 1;
				}
			}
			
			$return = debugLogger("HELLO THERE");
			echo $return;
?>