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

$sql = "SET FOREIGN_KEY_CHECKS=0;";
$sql .= "drop table customers;";
$sql .= "create table customers (cno integer auto_increment primary key, cname varchar(30), street varchar(30), zip varchar(9), phone    varchar(12), foreign key (zip) references zipcodes(zip));";
$sql .= "SET FOREIGN_KEY_CHECKS=1;";

if ($conn->multi_query($sql) === TRUE) {
        echo "records deleted successfully";
} else {
        echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

</body>
</html>

