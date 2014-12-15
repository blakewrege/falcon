<html>
<body>
<?php
$servername = "localhost";
$username = "testuser";
$password = "test623";
$dbname = "lab2";

//Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$CNO=$_POST["CNO"];
settype($CNO, "integer");
$CNAME=$_POST["CNAME"];
$STREET=$_POST["STREET"];
$ZIP=$_POST["ZIP"];
$PHONE=$_POST["PHONE"]"

$sql = "INSERT INTO customers (CNAME, STREET, ZIP, PHONE)
VALUES ('$CNAME', '$STREET', '$ZIP', '$PHONE')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully\n";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
</p>


CNO:<?php echo $_POST["CNO"]; ?><br> 
CNAME:<?php echo $_POST["CNAME"]; ?><br> 
STREET:<?php echo $_POST["STREET"]; ?><br> 
ZIP:<?php echo $_POST["ZIP"]; ?><br> 
PHONE:<?php echo $_POST["PHONE"]; ?><br> 



<br>


</body>
</html>
