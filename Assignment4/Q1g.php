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





do {
$menu = menu();
echo "\n$menu\n";


if ($menu == 1) {
	addcustomer($conn);
}




} while ( $menu != 7);






function menu(){
echo "
		\n############# ASSIGNMENT 4 MENU ##############\n\n
		\n0. other options
		\n1. add a customer
		\n2. add an order
		\n3. remove an order
		\n4. ship an order
		\n5. print pending order list with customer information
		\n6. restock parts
		\n7. exit";
	echo "\nSelect a number: "; $handle0 = fopen ("php://stdin","r"); $menu = trim(fgets($handle0));
	return $menu;
}


function removeorder ($conn){
	echo "ONO: "; $handle = fopen ("php://stdin","r"); $ONO = trim(fgets($handle));
	checkorder($conn, $ONO);
}	
	
	
function addorder_line($conn){
	echo "ONO: "; $handle = fopen ("php://stdin","r"); $ONO = trim(fgets($handle));
	checkorder($conn, $ONO);
	echo "PNO: "; $handle2 = fopen ("php://stdin","r"); $PNO = trim(fgets($handle2));
	echo "QTY: "; $handle3 = fopen ("php://stdin","r"); $QTY = trim(fgets($handle3));
}



//Checks if order exists
function checkorder($conn, $ONO){
	$sql = mysqli_query($conn,"SELECT ONO FROM order_line WHERE ONO LIKE '$ONO'");
	$num_rows = mysqli_num_rows($sql);	
	if($num_rows == 0){
	echo "\nDoes not exist, create a new order record for $ONO\n";
	echo "CNO: "; $handle2 = fopen ("php://stdin","r"); $CNO = trim(fgets($handle2));
	customercheck($conn, $CNO);
	echo "ENO: "; $handle3 = fopen ("php://stdin","r"); $ENO = trim(fgets($handle3));
	checkemployee($conn, $ENO);
	echo "SHIPPED: "; $handle4 = fopen ("php://stdin","r"); $SHIPPED = trim(fgets($handle4));
	
	mysqli_query($conn,"INSERT INTO orders (ONO, CNO, ENO, RECEIVED, SHIPPED)
	VALUES ('$ONO','$CNO', '$ENO', NOW(), '$SHIPPED')");
	$nowtime = time();
	echo "\nOrder added: $ONO | $CNO | $ENO | $nowtime | $SHIPPED\n";
}}

//Creates a new order
function addorder($conn){
	echo "ONO: "; $handle = fopen ("php://stdin","r"); $ONO = trim(fgets($handle));
	echo "CNO: "; $handle2 = fopen ("php://stdin","r"); $CNO = trim(fgets($handle2));
	customercheck($conn, $CNO);
	echo "ENO: "; $handle3 = fopen ("php://stdin","r"); $ENO = trim(fgets($handle3));
	checkemployee($conn, $ENO);
	echo "SHIPPED: "; $handle4 = fopen ("php://stdin","r"); $SHIPPED = trim(fgets($handle4));
	
	mysqli_query($conn,"INSERT INTO orders (ONO, CNO, ENO, RECEIVED, SHIPPED)
	VALUES ('$ONO','$CNO', '$ENO', NOW(), '$SHIPPED')");
	$nowtime = time();
	echo "\nOrder added: $ONO | $CNO | $ENO | $nowtime | $SHIPPED\n";
}


//checks for employee by ENO
function checkemployee($conn, $ENO){
	$sql = mysqli_query($conn,"SELECT ENO FROM employees WHERE ENO LIKE '$ENO'");
	$num_rows = mysqli_num_rows($sql);	
	if($num_rows == 0){
	echo "\nDoes not exist, create a new employee record for $ENO\n";
	echo "ENAME: "; $handle = fopen ("php://stdin","r"); $ENAME = trim(fgets($handle));
	echo "zip: "; $handle2 = fopen("php://stdin","r"); $zip = trim(fgets($handle2));
	zipcheck($conn, $zip);
	echo "hdate: "; $handle3 = fopen("php://stdin","r"); $hdate = trim(fgets($handle3));
	
	mysqli_query($conn,"INSERT INTO employees (ENO, ENAME, zip, hdate)
	VALUES ('$ENO','$ENAME', '$zip', '$hdate')");
	echo "\nEmployee added: $ENO | $ENAME | $zip | $hdate\n";
}}


//checks for customer by CNO
function customercheck($conn, $CNO){
	$sql = mysqli_query($conn,"SELECT CNO FROM customers WHERE CNO LIKE '$CNO'");
	$num_rows = mysqli_num_rows($sql);
	if($num_rows == 0){
	echo "\nDoes not exist, create a new customer record for $CNO\n";
	echo "cname: "; $handle = fopen ("php://stdin","r"); $CNAME = trim(fgets($handle));
	echo "street: "; $handle2 = fopen ("php://stdin","r"); $STREET = trim(fgets($handle2));
	echo "zip: "; $handle3 = fopen("php://stdin","r"); $zip = trim(fgets($handle3));
	zipcheck($conn, $zip);
	echo "phone: "; $handle4 = fopen("php://stdin","r"); $PHONE = trim(fgets($handle4));
	
	mysqli_query($conn,"INSERT INTO customers (CNO, CNAME, STREET, zip, PHONE)
	VALUES ('$CNO', '$CNAME', '$STREET', '$zip', '$PHONE')");
	echo "\nCustomer added: $CNO | $CNAME | $STREET | $zip | $PHONE\n";
}}

//adds a customer
function addcustomer($conn){
	echo "cname: "; $handle = fopen ("php://stdin","r"); $CNAME = trim(fgets($handle));
	echo "street: "; $handle2 = fopen ("php://stdin","r"); $STREET = trim(fgets($handle2));
	echo "zip: "; $handle3 = fopen("php://stdin","r"); $zip = trim(fgets($handle3));
	zipcheck($conn, $zip);
	echo "phone: "; $handle4 = fopen("php://stdin","r"); $PHONE = trim(fgets($handle4));
	
	mysqli_query($conn,"INSERT INTO customers (CNAME, STREET, zip, PHONE)
	VALUES ('$CNAME', '$STREET', '$zip', '$PHONE')");
	echo "\nCustomer added: $CNAME | $STREET | $zip | $PHONE\n";
}

//checks for zipcode by zip
function zipcheck($conn, $zip){
	$sql = mysqli_query($conn,"SELECT zip FROM zipcodes WHERE zip LIKE '$zip'");
	$num_rows = mysqli_num_rows($sql);
	if($num_rows == 0){
	echo "\nDoes not exist, create a new zipcode record for $zip \ncity:";
	$handle5 = fopen("php://stdin","r");
	$CITY = trim(fgets($handle5));

	mysqli_query($conn,"INSERT INTO zipcodes (CITY, zip)
    VALUES ('$CITY','$zip')");
	echo "\nzipcode added: $CITY | $zip\n";
}}

//rebuilds the entiredb
function rebuilddb($conn){
	mysqli_query($conn,"drop database lab2");
	mysqli_query($conn,"create database lab2");
	mysqli_query($conn,"use lab2");
	mysqli_query($conn,"create table zipcodes(
	  zip      varchar(9),
	  city     varchar(40),
	  primary key (zip)
	)");
	mysqli_query($conn,"create table parts(
	  pno      integer primary key,
	  pname    varchar(30),
	  qoh      integer check(qoh >= 0),
	  price    decimal(6,2) check(price >= 0.0),
	  level    integer
	)");
	mysqli_query($conn,"create table customers (
	  cno      integer auto_increment primary key,
	  cname    varchar(30),
	  street   varchar(30),
	  zip      varchar(9),
	  phone    varchar(12),
	  foreign key (zip) references zipcodes(zip)
	)");
	mysqli_query($conn,"create table orders (
	  ono      integer auto_increment primary key,
	  cno      integer,
	  eno      integer,
	  received timestamp default now(),
	  shipped  timestamp null,
	  foreign key (cno) references customers(cno),
	  foreign key (eno) references employees(eno)
	)");
	mysqli_query($conn,"create table order_line (
	  ono      integer,
	  pno      integer,
	  qty      integer check(qty > 0),
	  primary key (ono,pno),
	  foreign key (ono) references orders(ono),
	  foreign key (pno) references parts(pno)
	)");
}





	echo "done";
$conn->close();
?>
