<!--PHP Code Begins-->

<?php
	if(session_status() == PHP_SESSION_NONE )
		session_start();
	include 'connection.php';
	$FNameErr=$LNameErr=$EmailErr=$PasswordErr=$UsernameErr="";
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
	if(!filter_var($_POST["Email"],FILTER_VALIDATE_EMAIL))
		$EmailErr = "Enter valid Email";
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
			$Username = "Username Cannot be Empty. (Your Email is your username)";
		else
			$Username = test_input($_POST["Username"]);
		if(empty($_POST["Password"]))
			$PasswordErr = "Password can't be empty.";
		else
			$Password=md5($_POST("Password"));
		
		$Query = "SELECT * FROM UserList WHERE Email = '$Username' AND Password = '$Password';";
		$result = mysqli_query($conn, $Query);
		$count = mysqli_num_rows($result);
		if($count = 1)
		{
			$_SESSION["GEmail"]=$Username;
			header("location: dashboard.php");
		}
		else
		{
			echo "Error! Multiple Records Found!";
		}
	}
?>
	
<!--PHP code ends here, HTML Begins -->

<!Doctype HTML>
<html>
<head>
	<title>Simple Database System</title>
</head>
<body>
	<!--LOGIN FORM-->
	<div id="LoginForm">
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
			Username (Email) : </br>
			<input type="text" name="Username" /> </br>
			Password : </br>
			<input type="password" name="LPassword" /></br>
			<input type="submit" value="Login" name="Login" /></br></br>
		</form>
	</div>
	<!--REGISTRATION FORM-->
	<div id="RegistrationForm">
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
			First Name : </br>
			<input type="text" name="FirstName" />
			<span class="Error"> <?php echo $FNameErr ?> </span>
			</br>
			Last Name : </br>
			<input type="text" name="LastName" />
			<span class="Error"> <?php echo $LNameErr ?> </span>
			</br>
			Email : </br>
			<input type="text" name="Email" />
			<span class="Error"> <?php echo $EmailErr ?> </span>
			</br>
			Password : </br>
			<input type="password" name="Password" /></br>
			Confirm Password : </br>
			<input type="password" name="CPassword" />
			<span class="Error"> <?php echo $PasswordErr ?> </span>
			</br>
			<input type="submit" value="Register" name="Register" /></br></br>
		</form>
	</div>
</body>
</html>
