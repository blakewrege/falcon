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

$sql = "SELECT cno, cname, street, zip, phone FROM customers";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
       //  output data of each row
        while($row = $result->fetch_assoc()) {
        echo "cno: " . $row["cno"]. " | cname: " . $row["cname"]. " | street: " . $row["street"]. " | zip: " . $row["zip"]. " | phone: " . $row["phone"]. "<br>";
                                 }
} else {
        echo "0 results";
}
$conn->close();
?>
