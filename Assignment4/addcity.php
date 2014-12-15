<html>
<body>
<?php
$servername = "localhost";
$username = "testuser";
$password = "test623";
$dbname = "lab2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$ZIP=$_POST["ZIP"];
$CITY=$_POST["CITY"];


$sql = "INSERT INTO zipcodes (ZIP,CITY)
VALUES ('$ZIP','$CITY')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully\n";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

<br>
ZIP: <?php echo $_POST["ZIP"]; ?><br>
CITY: <?php echo $_POST["CITY"]; ?><br> 
<br>

</body>
</html>
