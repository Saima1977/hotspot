<?php
if(isset($_POST))
{
	$mac=$_POST['mac'];
	$ipaddr=$_POST['ip'];
	$username=$_POST['username'];
	$linklogin=$_POST['link-login'];
	$linkorig=$_POST['link-orig'];
	$error=$_POST['error'];
	$URL_REF = parse_url($_SERVER['HTTP_REFERER']);
	$data = $URL_REF['query'];
	$new_url = substr($data, (strrpos($data, '=') ?: -1) +1);
	$new_url = urldecode($new_url);
}
?>
<html>
<body>
	<h2>Login</h2>
	<form action="hotspot.php" method="post">
			 <fieldset>
			<legend>Login Form</legend> 
			<p>Room No: <input type="text" size="30" name="room_no"></p>     
			<p>Surname: <input type="text" size="30" name="lname"></p> 
			<p><input type="hidden" value="<?php echo $mac; ?>" name="mac"></p>
			<p><input type="hidden" value="<?php echo $ipaddr; ?>" name="ipaddr"></p>
			<p><input type="hidden" value="<?php echo $new_url; ?>" name="referrer"></p>
			<p><input type="submit" name="submit"></p>
			</fieldset>
	</form>
</body>
</html>