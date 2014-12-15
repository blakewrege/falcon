<?php
$con = mysqli_connect("localhost","testuser","test623","lab2");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

  echo "Connected to MySQL\n"
?>
