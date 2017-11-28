<?php

	$conn = mysqli_connect("localhost","root","","php_prac");
	if(mysqli_connect_errno())
	{
		echo "Error Connecting to Database".mysqli_connect_error(); 
	}

?>
