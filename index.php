<?php
  ini_set('display_errors',true);
  //Including connection file for connection with database.
  include 'connection.php';

  //Checking whether the submit button is pressed.
  $error1 = "";
  if(isset($_POST['submit']))
  {
    //Storing all input data in variables.
    $FName = trim($_POST['FName']);
    $LName = trim($_POST['LName']);
    $Email = trim($_POST['Email']);
    $Password = $_POST['Password'];
    $CPassword = $_POST['CPassword'];
    //Now Verifying the values of all variables.
    if(!filter_var($Email, FILTER_VALIDATE_EMAIL))
    {
        $error1 = "Enter a valid Email Address.";
    }
    elseif($Password!==$CPassword)
    {
        $error1 = "Passwords don't match.";
    }
    else {
      $error1 = "Successfully Registered!";
      $insertQuery = 'INSERT INTO User_List(FirstName, LastName, Email, Password) VALUES ("$FName","$LName","$Email","$Password")';
      mysqli_query($conn, $insertQuery);

    }

  }
 ?>

<!Doctype html>
<html>
  <head>
    <title> Baddu Login System </title>
    <link rel="stylesheet" href="style.css" />
  </head>

  <body>
    <div id ='error'>
      <?php
            echo $error1;
       ?>
    </div>
    <div id='MainContent'>
      This is My first website with Login and database features! Stay Calm and Enjoy.
      <div id='Form'>
        <form method="POST" action="index.php">
        First Name:<br/>
        <input type='text' name='Fname' /> <br/><br/>
        Last Name:<br/>
        <input type='text' name='Lname'/><br/><br/>
        Email:<br/>
        <input type='text' name='Email'/><br/><br/>
        Password:<br/>
        <input type='password' name='password'/><br/><br/>
        Confirm Password:<br/>
        <input type='password' name='Cpassword'/><br/><br/>

        <input type='submit' name='Submit' value='Submit' /><br/>
        </form>
      </div>
    </div>

  </body>
</html>
