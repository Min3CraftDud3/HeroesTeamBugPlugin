<html>
<head><title>Installer for Heroes Team Bug Plugin web Interface</title></head>
<body><center>
<p>Installer for Heroes Team Bug Plugin Web Interface</p>
<p>You will need your MySQL information handy.<br /> 
Just fill out the form below and it will do the rest.</p>
<form method="POST" action=''>
MySQL IP: <input type="text" name="ip"/><br />
MySQL UserName: <input type="text" name="user"/><br />
MySQL PassWord: <input type="text" name="pass"/><br />
MySQL Database Name: <input type="text" name="db"/><br />
<hr>
Admin Login:<br />
Username: <input type="text" name="fuser"/><br />
PassWord: <input type="text" name="fpass"/><br />
First Name: <input type="text" name="ffname"/><br />
Last Name: <input type="text" name="flname"/><br />
Email: <input type="text" name="femail"/><br />
<input type="submit" name="button1"  value="Create Table and Admin Account">
</form>

<?php
if (isset($_POST['button1'])) 
{
	$ip 		= $_POST['ip'];
	$user 		= $_POST['user'];
	$pass 		= $_POST['pass'];
	$db 		= $_POST['db'];
	$fuser	= $_POST['fuser'];
	$fpass	= $_POST['fpass'];
	$ffname	= $_POST['ffname'];
	$flname	= $_POST['flname'];
	$femail		= $_POST['femail'];
	
$con=mysqli_connect($ip,$user,$pass,$db);
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$sql="CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";

// Execute query
if (mysqli_query($con,$sql)) {
  echo "Table created successfully <br />";
  mysqli_query($con,"INSERT INTO users (id, username, password, first_name, last_name, email)
	VALUES (null,'{$fuser}','{$fpass}','{$ffname}','{$flname}','{$femail}')");
	echo "Admin Account Created! <br />";
	echo "Please DELETE install.php from your web directory. <br />";
	echo "Please add your MySQL info to the db_const.php file.";
} else {
  echo "Error creating table: " . mysqli_error($con);
}
}
?>
</center>
</body>
</htmL>