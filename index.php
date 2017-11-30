<!--PHP Code Begins-->

<?php
	if(session_status() == PHP_SESSION_NONE )
		session_start();
	include 'connection.php';
	if(isset($_COOKIE["UserCookie"]))
	{
		header('location:dashboard.php');
	}

	$FNameErr=$LNameErr=$EmailErr=$LPasswordErr=$PasswordErr=$Username=$UsernameErr=$LoginErr="";
	//Registration Code Starts Here.
	if(isset($_POST["Register"]))
	{
	if(empty($_POST["FirstName"]))
		$FNameErr = "First Name shouldn't be empty";
	else
		$FirstName= test_input($_POST["FirstName"]);
	if(empty($_POST["LastName"]))
		$LNameErr = "Last name shouldn't be empty";
	else 
		$LastName = test_input($_POST["LastName"]);
	
	//Email Verification
	$Dummy = $_POST['Email'];
	$Email2 = "SELECT * from UserList WHERE Email='$Dummy';";
	$run2 = mysqli_query($conn, $Email2);
	$CountEmail = mysqli_num_rows($run2);
	if(!filter_var($_POST["Email"],FILTER_VALIDATE_EMAIL)|| $CountEmail >0)
	{
		if($CountEmail)
			$EmailErr = "Email Already in Use";
		else
			$EmailErr = "Enter valid Email";
	}
	else
		$Email = $_POST["Email"];
	if($_POST["Password"]===$_POST["CPassword"])
		$Password = md5($_POST["Password"]);
	else	
		$PasswordErr = "Passwords do not match.";
	
	//Inserting registration data into table
	if(isset($FirstName)&&isset($LastName)&&isset($Email)&&isset($Password))
	{
		$Query = "INSERT INTO userlist (FirstName, LastName, Email, Password) VALUES ('$FirstName', '$LastName', '$Email', '$Password');";
		$run = mysqli_query($conn, $Query);
		if(!$run)
		{
			echo "Error Inserting Details into Table.";
		}
	}
	}
	
	function test_input($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	//LOGIN Code Starts Here
	if(isset($_POST["Login"]))
	{
		if(empty($_POST["Username"]))
			$UsernameErr = "Username Cannot be Empty. (Your Email is your username)";
		else
			$Username = test_input($_POST["Username"]);
		if(empty($_POST["LPassword"]))
			$LPasswordErr = "Password can't be empty.";
		else
		{
			$Password=md5($_POST["LPassword"]);
			$Query = "SELECT * FROM UserList WHERE Email = '$Username' AND Password = '$Password';";
			$result = mysqli_query($conn, $Query);
			$count = mysqli_num_rows($result);
			if($count == 1)
			{
				$_SESSION["GEmail"]=$Username;
				setcookie("UserCookie",$Username,time()+3600,'/');
				header("location: dashboard.php");
			}
			else
			{
				$LoginErr = "Email (or) Password Wrong! Please Retry.";
			}
		}
		
	}
?>
	
<!--PHP code ends here, HTML Begins -->

<!Doctype HTML>
<html>
<head>
	<title>Simple Database System</title>
	<link rel="stylesheet" href="style.css" />
	<!--Bootstrap 3 linking-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!--Bootstrap 3 linking ends here-->
</head>
<body>
	<!--Normal content goes here-->
	
	<center><h1>Welcome To Social Network 007</h1></center>
	
	<!--Normal Content Ends here-->
	<!--LOGIN FORM-->
	<div id="LoginForm">
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
			Username (Email) : </br>
			<input type="text" name="Username" /><span class='Error'></br><?php echo $UsernameErr  ?></br></span>
			Password : </br>
			<input type="password" name="LPassword" /><span class='Error'></br><?php echo $LPasswordErr ?></br></span>
			<span class='Error'><?php echo $LoginErr ?></br></span>
			<input type="submit" value="Login" class="btn btn-info" name="Login" /></br></br>
		</form>
	</div>
	<!--REGISTRATION FORM-->
	<div id="RegistrationForm">
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
			First Name : </br>
			<input type="text" name="FirstName" />
			<span class="Error"></br> <?php echo $FNameErr ?> </span>
			</br>
			Last Name : </br>
			<input type="text" name="LastName" />
			<span class="Error"></br> <?php echo $LNameErr ?> </span>
			</br>
			Email : </br>
			<input type="text" name="Email" />
			<span class="Error"></br> <?php echo $EmailErr ?> </span>
			</br>
			Password : </br>
			<input type="password" name="Password" /></br></br>
			Confirm Password : </br>
			<input type="password" name="CPassword" />
			<span class="Error"></br> <?php echo $PasswordErr ?> </span>
			</br>
			<input type="submit" value="Register" class="btn btn-success" name="Register" /></br></br>
		</form>
	</div>
</body>
</html>
