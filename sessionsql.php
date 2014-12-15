<html>
<body>

Welcome <?php echo $_POST["name"]; ?><br>
Your email address is: <?php echo $_POST["email"]; ?>
<?php
session_start();
$_SESSION['name'] = $_POST['name'];
$_SESSION['email'] = $_POST['email'];

?>

<li><a href="http://t4ls.duckdns.org:8080/p3.php">p3</a></li>

</body>
</html>
