<?php
//main admin file which should be restricted to the logged in administrator only. If not logged in, then this should redirect to the login page.
include_once('admin-class.php');
$admin = new itg_admin();
$admin -> _authenticate();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Administrator Page</title>
</head>
<body>
	<fieldset>
		<legend>Welcome <?php echo $admin->get_nicename();?></legend>
		<p>Here are some of the basic features of the login system</p>
		<p>Username: <?php echo $_SESSION['admin_login'];?>
		</p>
		<p>Email: <?php echo $admin->get_email(); ?></p>
	</fieldset>
	<p>
		<input type="button" name="logout" onclick="javascript:window.location.href='logout.php'" value="Logout"/>
	</p>

</body>
</html>