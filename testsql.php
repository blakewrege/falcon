<?php
$cookie_name = "user";
$cookie_value = "John Doe";
setcookie($cookie_name, $cookie_value, time() + (86400 * 30)); // 86400 = 1 day
?>
<html>
<body>

<?php
if(!isset($_COOKIE[$cookie_name])) {
          echo "Cookie named '" . $cookie_name . "' is not set!";
} else {
          echo "Cookie '" . $cookie_name . "' is set!<br>";
                echo "Value is: " . $_COOKIE[$cookie_name];
}
?>

<p><strong>Note:</strong> You might have to relaod the page to see the value of the cookie.</p>
<br><br>



<form method="post" action="page3.php">
     <input type="text" name="req">
      <input type="hidden" name="holdname" value="<?php $_POST["name"] ?>"> 
       ////////you can start by making the field visible and see if it holds the value
      <input type="submit">
</form>


</body>
</html>

<?php
$servername = "localhost";
$username = "testuser";
$password = "test623";
$dbname = "testdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name=$_POST["name"];
$email=$_POST["email"];


$sql = "INSERT INTO testmail (name,email)
VALUES ('$name','$email')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully\n";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();


?>





<html>
<body>

Welcome <?php echo $_POST["name"]; ?><br>
Your email address is: <?php echo $_POST["email"]; 





$con = mysqli_connect("localhost","testuser","test623","testdb");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

  echo "  Connected to MySQL"

?>



</body>
</html>
