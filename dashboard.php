<?php
	if(session_status() == PHP_SESSION_NONE )
		session_start();
	include 'connection.php';
	if(isset($_POST["logout"]))
	{
		session_unset();
		setcookie("UserCookie",$Username,time()-3600,'/');
		header('Location:index.php');
	}
?>
<!Doctype html>
<head>
<title>User Dashboard</title>
</head>
<body>
	Welcome to Dashboard! <?php echo " ".$_SESSION['GEmail'];?>
	<form method="POST" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
	<input type="submit" name="logout" Value="Log Out" />
	</form>
</body>
</html>
