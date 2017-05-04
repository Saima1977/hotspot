<?php
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Hotspot Admin Utility Login</title>
		<link rel="stylesheet" href="css/style.css" media="screen" type="text/css" />
	    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,700">
	</head>
	<?php
		require_once(__DIR__."/config.php");

		$_SESSION['successful'] = 0;
		$status = "";
		
		if(isset($_POST["uname"]) && isset($_POST["pword"]))
		{
    		$myusername = ms_escape_string($_POST["uname"]);
			$mypassword = ms_escape_string($_POST["pword"]);

			foreach($admin as $key=>$val)
			{
				if(($key == $myusername)&&($val == $mypassword))
				{
					$_SESSION['successful'] = 1;
					$_SESSION['username'] = $myusername;
					$_SESSION['password'] = $mypassword;
			
					$StringExplo=explode("/",$_SERVER['REQUEST_URI']);
					//$HeadTo=$StringExplo[0]."/admin.php";
					$HeadTo=$StringExplo[0]."/admin/admin.php";
					Header("Location: ".$HeadTo);					
				}
				else
				{
					$status = "<div class='isa_error'><i class='fa fa-times-circle'></i>Incorrect Login</div>";
				}				
			}
			
			/*
			if(($myusername === $admin_uname)&&($mypassword === $admin_pword))
			{
				$_SESSION['successful'] = 1;
				$StringExplo=explode("/",$_SERVER['REQUEST_URI']);
				//$HeadTo=$StringExplo[0]."/admin.php";
				$HeadTo=$StringExplo[0]."/admin/admin.php";
				Header("Location: ".$HeadTo);
			}
			else
			{
				$status = "<div class='isa_error'><i class='fa fa-times-circle'></i>Incorrect Login</div>";
			}
			*/
		}
	?>
	<body bgcolor="#e6e6e6">
		<div class="header-container overlay">
			<div class="txt-container">
				<p>Hotspot Utility Tool</p>
			</div>
		</div>
		<div class="container">
			<div id="login">
				<form action="" method="POST">
					<fieldset class="clearfix">
						<p><span class="fontawesome-user"></span><input type="text" name="uname" value="Username" onBlur="if(this.value == '') this.value = 'Username'" onFocus="if(this.value == 'Username') this.value = ''" required></p> <!-- JS because of IE support; better: placeholder="Username" -->
						<p><span class="fontawesome-lock"></span><input type="password" name="pword" value="Password" onBlur="if(this.value == '') this.value = 'Password'" onFocus="if(this.value == 'Password') this.value = ''" required></p> <!-- JS because of IE support; better: placeholder="Password" -->
						<?php echo $status; ?>
						<p><input type="submit" value="Log In"></p>
					</fieldset>
				</form>
			</div> <!-- end login -->
		</div>
	</body>
</html>