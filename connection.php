<?php
  $conn = mysqli_connect('localhost','root','toor123','BadduRegistration');

  if(mysqli_connect_errno())
  {
    echo "Error While Connectng to database \n Error Description: ".mysqli_connect_errno();
  }
?>
