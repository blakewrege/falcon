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


$sql = mysqli_query($conn,"SELECT zip FROM zipcodes WHERE zip LIKE '49001'");
$num_rows = mysqli_num_rows($sql);

echo "$num_rows"."\n";

$conn->close();
?>
