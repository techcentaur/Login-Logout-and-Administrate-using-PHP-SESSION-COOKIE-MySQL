<!DOCTYPE html>
<html>
<head>
	<title>Login to Admin Panel</title>
</head>
<body>
	<form action="login-action.php" method="POST">
		<fieldset>
			<legend>Enter Credentials</legend>
			<p>
				<label for="username">Username:</label>
				<input type="text" name="username" id="username">
			</p>
			<p>
				<label for="pass">Password:</label>
				<input type="password" name="pass" id="pass">
			</p>
			<p>
				<label for="remember">
					<input type="checkbox" name="remember" id="remember" value="1">Remember me
				</label>
			</p>
		</fieldset>
		<p>
			<input type="submit" name="submit"	value="Submit"/>
			<input type="reset" name="reset" value="Reset"/>
		</p>
	</form>

</body>
</html>