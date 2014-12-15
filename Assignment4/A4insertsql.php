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

$sql = "INSERT INTO customers (CNAME, STREET, ZIP, PHONE)
VALUES ('John','West Main','49008','4280746')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
