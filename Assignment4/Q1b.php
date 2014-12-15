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



addcustomer($conn);


//checks for employee by ENO
function checkemployee($conn, $ENO){
$sql = mysqli_query($conn,"SELECT ENO FROM employees WHERE ENO LIKE '$ENO'");
$num_rows = mysqli_num_rows($sql);	

if($num_rows == 0){
echo "\nDoes not exist, create a new employee record for $ENO\n";
echo "ENAME: "; $handle = fopen ("php://stdin","r"); $ENAME = trim(fgets($handle));
echo "ZIP: "; $handle2 = fopen("php://stdin","r"); $ZIP = trim(fgets($handle2));
zipcheck($conn, $ZIP);
echo "HIRE_DATE: "; $handle3 = fopen("php://stdin","r"); $HIRE_DATE = trim(fgets($handle3));

mysqli_query($conn,"INSERT INTO employees (ENO, ENAME, ZIP, HIRE_DATE)
VALUES ('$ENO','$ENAME', '$STREET', '$ZIP', '$HIRE_DATE')");
echo "\nEmployee added: $ENO | $ENAME | $STREET | $ZIP | $HIRE_DATE\n";
}}


//checks for customer by CNO
function customercheck($conn, $CNO){
$sql = mysqli_query($conn,"SELECT CNO FROM customers WHERE CNO LIKE '$CNO'");
$num_rows = mysqli_num_rows($sql);

if($num_rows == 0){
echo "\nDoes not exist, create a new customer record for $CNO\n";
echo "cname: "; $handle = fopen ("php://stdin","r"); $CNAME = trim(fgets($handle));
echo "street: "; $handle2 = fopen ("php://stdin","r"); $STREET = trim(fgets($handle2));
echo "ZIP: "; $handle3 = fopen("php://stdin","r"); $ZIP = trim(fgets($handle3));
zipcheck($conn, $ZIP);
echo "phone: "; $handle4 = fopen("php://stdin","r"); $PHONE = trim(fgets($handle4));

mysqli_query($conn,"INSERT INTO customers (CNO, CNAME, STREET, ZIP, PHONE)
VALUES ('$CNO', '$CNAME', '$STREET', '$ZIP', '$PHONE')");
echo "\nCustomer added: $CNO | $CNAME | $STREET | $ZIP | $PHONE\n";
}}

//adds a customer
function addcustomer($conn){
echo "cname: "; $handle = fopen ("php://stdin","r"); $CNAME = trim(fgets($handle));
echo "street: "; $handle2 = fopen ("php://stdin","r"); $STREET = trim(fgets($handle2));
echo "ZIP: "; $handle3 = fopen("php://stdin","r"); $ZIP = trim(fgets($handle3));
zipcheck($conn, $ZIP);
echo "phone: "; $handle4 = fopen("php://stdin","r"); $PHONE = trim(fgets($handle4));

mysqli_query($conn,"INSERT INTO customers (CNAME, STREET, ZIP, PHONE)
VALUES ('$CNAME', '$STREET', '$ZIP', '$PHONE')");
echo "\nCustomer added: $CNAME | $STREET | $ZIP | $PHONE\n";
}

//checks for zipcode by ZIP
function zipcheck($conn, $ZIP){
$sql = mysqli_query($conn,"SELECT zip FROM zipcodes WHERE zip LIKE '$ZIP'");
$num_rows = mysqli_num_rows($sql);

if($num_rows == 0){
echo "\nDoes not exist, create a new zipcode record for $ZIP \ncity:";
$handle5 = fopen("php://stdin","r");
$CITY = trim(fgets($handle5));

mysqli_query($conn,"INSERT INTO zipcodes (CITY, ZIP)
    VALUES ('$CITY','$ZIP')");
echo "\nZIPcode added: $CITY | $ZIP\n";
}}

$conn->close();
?>

