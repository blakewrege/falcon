<?php
do{
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


	$menu = menu();
	
	if ($menu == 0) {
		$otheroptions = otheroptions();
		if ($otheroptions == 1) {
		rebuilddb($conn);
		}
		if ($otheroptions == 2) {
		rebuilddb($conn);
		sample();
		}
		if ($otheroptions == 3) {
		addorder_line($conn);
		}
		if ($otheroptions == 4) {
		addpart($conn);
		}
	}

	if ($menu == 1) {
		echo "\nAdd a customer\n";
		addcustomer($conn);
	}
	if ($menu == 2) {
		echo "\nAdd a order\n";
		addorder($conn);
	}
	if ($menu == 3) {
		echo "\nRemove a order\n";
		removeorder($conn);
	}
	if ($menu == 4) {
		echo "\nShip an order\n";
		shiporder($conn);
	}
	if ($menu == 5) {
		echo "\nprint pending order list with customer information\n";
		read($conn);
	}
	if ($menu == 6) {
		echo "\nrestock parts\n";
		stockpart($conn);
	}


} while ( $menu != 7);



function otheroptions(){
	echo "\n\n\n
	\n1.recreate database 
	\n2.recreate database with samples 
	\n3.add orderline
	\n4.add part";
	echo "\nSelect a number: "; $handle0 = fopen ("php://stdin","r"); $otheroptions = trim(fgets($handle0));
	return $otheroptions;
}

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


function read($conn){
	$srows = mysqli_query($conn,"SELECT * FROM customers");
	
	if ($srows->num_rows > 0) {
	        while($row = $srows->fetch_assoc()) {
	        echo "\n\n\nCustomer information: ";
	        echo "cno: " . $row["cno"]. " | cname: " . $row["cname"]. " | street: " . $row["street"].
	        " | zip: " . $row["zip"]. " | phone: " . $row["phone"]."\n";
	        $cnum = $row["cno"];
	
	$orows = mysqli_query($conn,"SELECT * FROM orders where cno LIKE '$cnum' ORDER BY received");
		    echo "\nOrder information for CNO #$cnum: ";
	if ($orows->num_rows > 0) {
	        while($row = $orows->fetch_assoc()) {
	        $ship = $row["shipped"];
	        if ($ship == '') {
	        echo "\nono: " . $row["ono"]. " | received: " . $row["received"]." | shipped: " . $row["shipped"];
			} 
			}
	} else {
	        echo "0 results no orders\n";
	}	
			}
	} else {
	        echo "0 results no customers\n";
	}


}


//Removes an order
function removeorder($conn){
	echo "ONO: "; $handle = fopen ("php://stdin","r"); $ONO = trim(fgets($handle));
	$numono = mysqli_query($conn,"SELECT * FROM orders ORDER BY ONO DESC LIMIT 1");
	if ($numono->num_rows > 0) {
    while($row = $numono->fetch_assoc()) {
	$test=$row["ono"];
    }}
    if ($ONO > $test) {
    echo "\nOrder number does not exist";
    }else{

	$orderqty = mysqli_query($conn,"SELECT qty,pno FROM order_line WHERE ONO ='$ONO'");
	if ($orderqty->num_rows > 0) {
   // output data of each row
    while($row = $orderqty->fetch_assoc()) {
	$QTY=$row["qty"];
	$pnum=$row["pno"];
    }}
	$numparts = mysqli_query($conn,"SELECT qoh FROM parts WHERE PNO ='$pnum'");
	if ($numparts->num_rows > 0) {
   // output data of each row
    while($row = $numparts->fetch_assoc()) {
	$quantity=$row["qoh"];
    }}
    $test = $quantity + $QTY;
    mysqli_query($conn,"UPDATE parts SET qoh=$test WHERE PNO='$pnum'");
	echo "\nQuantity of PNO #$pnum remaining: $test\n";
    mysqli_query($conn,"DELETE FROM order_line WHERE ONO=$ONO");
	mysqli_query($conn,"DELETE FROM orders WHERE ONO=$ONO");
	echo "\n$ONO was deleted\n";
	}
	
}	

//Adds more qoh to the PNO
function stockpart($conn){
	echo "PNO: "; $handle2 = fopen ("php://stdin","r"); $PNO = trim(fgets($handle2));
	$sql = mysqli_query($conn,"SELECT PNO FROM parts WHERE PNO LIKE '$PNO'");
	$num_rows = mysqli_num_rows($sql);	
	if($num_rows == 0){
	echo "\nDoes not exist, create a new part record for $PNO\n";
	echo "PNAME: "; $handle2 = fopen ("php://stdin","r"); $PNAME = trim(fgets($handle2));
	echo "QOH: "; $handle3 = fopen ("php://stdin","r"); $QOH = trim(fgets($handle3));
	echo "PRICE: "; $handle4 = fopen("php://stdin","r"); $PRICE = trim(fgets($handle4));
	echo "LEVEL: "; $handle5 = fopen("php://stdin","r"); $LEVEL = trim(fgets($handle5));
	mysqli_query($conn,"INSERT INTO parts (PNO, PNAME, QOH, PRICE, LEVEL)
	VALUES ('$PNO', '$PNAME', '$QOH' , '$PRICE', '$LEVEL')");
	echo "\nPart added: $PNO | $PNAME | $QOH | $PRICE | $LEVEL\n";
	}
	echo "How much stock would you like to add?: "; $handle3 = fopen ("php://stdin","r"); $QTY = trim(fgets($handle3));
	$numparts = mysqli_query($conn,"SELECT qoh FROM parts WHERE PNO ='$PNO'");
	if ($numparts->num_rows > 0) {
   // output data of each row
    while($row = $numparts->fetch_assoc()) {
	$quantity=$row["qoh"];
    }}
    $test = $quantity + $QTY;
    mysqli_query($conn,"UPDATE parts SET qoh=$test WHERE PNO=$PNO");
	echo "\nQuantity of PNO #$PNO is now: $test\n";



}

//creates new order line	
function addorder_line($conn){
	echo "ONO: "; $handle = fopen ("php://stdin","r"); $ONO = trim(fgets($handle));
	
	echo "PNO: "; $handle2 = fopen ("php://stdin","r"); $PNO = trim(fgets($handle2));
	echo "QTY: "; $handle3 = fopen ("php://stdin","r"); $QTY = trim(fgets($handle3));
	checkpart($conn, $PNO, $QTY);
	mysqli_query($conn,"INSERT INTO order_line (ONO, PNO, QTY)
	VALUES ('$ONO', '$PNO', '$QTY')");
	echo "\nOrder_Line added: $ONO | $PNO | $QTY\n";
}
//ship an order
function shiporder($conn){
	echo "ONO: "; $handle = fopen ("php://stdin","r"); $ONO = trim(fgets($handle));
	checkorder($conn, $ONO);
	mysqli_query($conn,"UPDATE orders SET shipped=NOW() WHERE ONO=$ONO");	
	$nowtime = time();
	echo "\nOrder shipped: $ONO | $nowtime\n";
}


//checks if part exists
function checkpart($conn, $PNO, $QTY){
	$sql = mysqli_query($conn,"SELECT PNO FROM parts WHERE PNO LIKE '$PNO'");
	$num_rows = mysqli_num_rows($sql);	
	if($num_rows == 0){
	echo "\nDoes not exist, create a new part record for $PNO\n";
	echo "PNAME: "; $handle2 = fopen ("php://stdin","r"); $PNAME = trim(fgets($handle2));
	echo "QOH: "; $handle3 = fopen ("php://stdin","r"); $QOH = trim(fgets($handle3));
	echo "PRICE: "; $handle4 = fopen("php://stdin","r"); $PRICE = trim(fgets($handle4));
	echo "LEVEL: "; $handle5 = fopen("php://stdin","r"); $LEVEL = trim(fgets($handle5));
	mysqli_query($conn,"INSERT INTO parts (PNO, PNAME, QOH, PRICE, LEVEL)
	VALUES ('$PNO', '$PNAME', '$QOH' , '$PRICE', '$LEVEL')");
	echo "\nPart added: $PNO | $PNAME | $QOH | $PRICE | $LEVEL";
	}

	$numparts = mysqli_query($conn,"SELECT qoh FROM parts WHERE PNO ='$PNO'");
	if ($numparts->num_rows > 0) {
   // output data of each row
    while($row = $numparts->fetch_assoc()) {
	$quantity=$row["qoh"];
    }}
    $test = $quantity - $QTY;
    if ($test < '0') {
    	echo "\nNot enough parts\n";
    	return 0;
    }
    mysqli_query($conn,"UPDATE parts SET qoh=$test WHERE PNO=$PNO");
	echo "\nQuantity of PNO #$PNO remaining: $test\n";
	return 1;
}


//Creates a part
function addpart($conn){
	echo "PNO:	 "; $handle = fopen ("php://stdin","r"); $PNO = trim(fgets($handle));
	echo "PNAME: "; $handle2 = fopen ("php://stdin","r"); $PNAME = trim(fgets($handle2));
	echo "QOH: "; $handle3 = fopen ("php://stdin","r"); $QOH = trim(fgets($handle3));
	echo "PRICE: "; $handle4 = fopen("php://stdin","r"); $PRICE = trim(fgets($handle4));
	echo "LEVEL: "; $handle5 = fopen("php://stdin","r"); $LEVEL = trim(fgets($handle5));

	mysqli_query($conn,"INSERT INTO parts (PNO, PNAME, QOH, PRICE, LEVEL)
	VALUES ('$PNO', '$PNAME', '$QOH' , '$PRICE', '$LEVEL')");
	echo "\nPart added: $PNO | $PNAME | $QOH | $PRICE | $LEVEL";
}

//Checks if order exists
function checkorder($conn, $ONO){
	$sql = mysqli_query($conn,"SELECT ONO FROM orders WHERE ONO LIKE '$ONO'");
	$num_rows = mysqli_num_rows($sql);	
	if($num_rows == 0){
	echo "\nDoes not exist, create a new order record for $ONO\n";
	echo "CNO: "; $handle2 = fopen ("php://stdin","r"); $CNO = trim(fgets($handle2));
	customercheck($conn, $CNO);
	echo "ENO: "; $handle3 = fopen ("php://stdin","r"); $ENO = trim(fgets($handle3));
	checkemployee($conn, $ENO);
	echo "PNO: "; $handle4 = fopen ("php://stdin","r"); $PNO = trim(fgets($handle4));
	echo "QTY: "; $handle5 = fopen ("php://stdin","r"); $QTY = trim(fgets($handle5));
	$parts = checkpart($conn, $PNO, $QTY);
	if ($parts == 1) {
	mysqli_query($conn,"INSERT INTO orders (ONO, CNO, ENO, RECEIVED)
	VALUES ('$ONO','$CNO', '$ENO', NOW())");
	$nowtime = time();
	echo "\nOrder added: $ONO | $CNO | $ENO | $nowtime | NULL\n";
	mysqli_query($conn,"INSERT INTO order_line (ONO, PNO, QTY)
	VALUES ('$ONO', '$PNO', '$QTY')");
	echo "\nOrder_Line added: $ONO | $PNO | $QTY\n";
	}
}}

//Creates a new order
function addorder($conn){
	echo "CNO: "; $handle2 = fopen ("php://stdin","r"); $CNO = trim(fgets($handle2));
	customercheck($conn, $CNO);
	echo "ENO: "; $handle3 = fopen ("php://stdin","r"); $ENO = trim(fgets($handle3));
	checkemployee($conn, $ENO);
	$numono = mysqli_query($conn,"SELECT * FROM orders ORDER BY ONO DESC LIMIT 1");
	if ($numono->num_rows > 0) {
    while($row = $numono->fetch_assoc()) {
	$ONO=$row["ono"]+1;
    }}
	echo "PNO: "; $handle4 = fopen ("php://stdin","r"); $PNO = trim(fgets($handle4));
	echo "QTY: "; $handle5 = fopen ("php://stdin","r"); $QTY = trim(fgets($handle5));
	$parts = checkpart($conn, $PNO, $QTY);
	if ($parts == 1) {
	mysqli_query($conn,"INSERT INTO orders (CNO, ENO, RECEIVED)
	VALUES ('$CNO', '$ENO', NOW())");
	$nowtime = time();
	echo "\nOrder added: $ONO | $CNO | $ENO | $nowtime | NULL";

	mysqli_query($conn,"INSERT INTO order_line (ONO, PNO, QTY)
	VALUES ('$ONO', '$PNO', '$QTY')");
	echo "\nOrder_Line added: $ONO | $PNO | $QTY\n";
	}

}


//Checks for employee by ENO
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


//Checks for customer by CNO
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

//Adds a customer
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

//Checks for zipcode by zip
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

//Rebuilds the entiredb
function rebuilddb($conn){
	mysqli_query($conn,"drop database lab2");
	mysqli_query($conn,"create database lab2");
	mysqli_query($conn,"use lab2");
	mysqli_query($conn,"create table zipcodes(
	  zip      varchar(9),
	  city     varchar(40),
	  primary key (zip)
	)");
	
	mysqli_query($conn,"create table employees(
	  eno      integer primary key, 
	  ename    varchar(30),
	  zip      varchar(9),
	  hdate    date,
	  foreign key (zip) references zipcodes(zip)
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

function sample() {
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

	$CITY = "kalamazoo";
	$zip = "49008";
	mysqli_query($conn,"INSERT INTO zipcodes (CITY, zip)
    VALUES ('$CITY','$zip')");
	echo "\nzipcode added: $CITY | $zip";

	$CNAME = "Joe";
	$STREET = "Main Street";
	$PHONE = "4280746";
	mysqli_query($conn,"INSERT INTO customers (CNAME, STREET, zip, PHONE)
	VALUES ('$CNAME', '$STREET', '$zip', '$PHONE')");
	echo "\nCustomer added: $CNAME | $STREET | $zip | $PHONE";
	$CNO = "1";
	$ENO = "1";
	$ENAME = "Boss";
	$hdate = "1999-01-01";
	mysqli_query($conn,"INSERT INTO employees (ENO, ENAME, zip, hdate)
	VALUES ('$ENO','$ENAME', '$zip', '$hdate')");
	echo "\nEmployee added: 1 | $ENO | $ENAME | $zip | $hdate";

	mysqli_query($conn,"INSERT INTO orders (CNO, ENO, RECEIVED)
	VALUES ('$CNO', '$ENO', NOW())");
	$nowtime = time();
	echo "\nOrder added: 1 | $CNO | $ENO | $nowtime | null";
	
	$ONO = "1";
	$PNO = "1";
	$PNAME = "screwdriver";
	$PRICE = "5.12";
	$QOH = "2";
	$LEVEL = "1";
	mysqli_query($conn,"INSERT INTO parts (PNO, PNAME, QOH, PRICE, LEVEL)
	VALUES ('$PNO', '$PNAME', '$QOH' , '$PRICE', '$LEVEL')");
	echo "\nPart added: $PNO | $PNAME | $QOH | $PRICE | $LEVEL";

	$QTY = "12";
	mysqli_query($conn,"INSERT INTO order_line (ONO, PNO, QTY)
	VALUES ('$ONO', '$PNO', '$QTY')");
	echo "\nOrder_Line added: $ONO | $PNO | $QTY\n";
}



	echo "\ndone\n";
$conn->close();
?>