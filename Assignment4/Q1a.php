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



echo "cno: "; $handle0 = fopen ("php://stdin","r"); $CNO = trim(fgets($handle0));
echo "cname: "; $handle = fopen ("php://stdin","r"); $CNAME = trim(fgets($handle));
echo "street: "; $handle2 = fopen ("php://stdin","r"); $STREET = trim(fgets($handle2));
echo "zip: "; $handle3 = fopen("php://stdin","r"); $ZIP = trim(fgets($handle3));
echo "phone: "; $handle4 = fopen("php://stdin","r"); $PHONE = trim(fgets($handle4));
echo "$CNO | $CNAME | $STREET | $ZIP | $PHONE";


zipcheck($conn, $ZIP);

mysqli_query($conn,"INSERT INTO customers (CNO, CNAME, STREET, ZIP, PHONE)
VALUES ('$CNO', '$CNAME', '$STREET', '$ZIP', '$PHONE')");



//checks for zipcode
function zipcheck($conn, $ZIP){
$sql = mysqli_query($conn,"SELECT zip FROM zipcodes WHERE zip LIKE '$ZIP'");
$num_rows = mysqli_num_rows($sql);

if($num_rows == 0){
echo "Create new zipcode record for $ZIP \ncity:";
$handle5 = fopen("php://stdin","r");
$CITY = trim(fgets($handle5));

mysqli_query($conn,"INSERT INTO zipcodes (CITY, ZIP)
    VALUES ('$CITY','$ZIP')");
}}

$conn->close();
?>
