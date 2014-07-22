<?php
session_start();
?>
<!DOCTYPE  HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd"> 
<html> 
<head> 
<meta  http-equiv="Content-Type" content="text/html;  charset=iso-8859-1"> 
<title>Heroes Team Bug Page</title> 
<center><img src="Header.png"></img></center>
<p align="right">
<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    echo "<font color='white'>Welcome to the member's area, " . $_SESSION['username'] . "!</font>";
	echo 
	"<form align='right' action='' method='post'> 
	<input type='submit' href='javascript:document.location.reload();' name='use_button' value='Logout' />
	</form>"; 

if(isset($_POST['use_button'])) 
{ 
		$_SESSION['loggedin'] = false;
		$_SESSION['username'] = null; 
} 
} else {
    if (!isset($_POST['submit'])){
?>
<!-- The HTML login form -->
	<form align="right" action="<?=$_SERVER['PHP_SELF']?>" method="post">
		<font color="white">Username:</font> <input type="text" name="username" /><br />
		<font color="white">Password:</font> <input type="password" name="password" /><br />

		<input type="submit" name="submit" value="Login" href="javascript:document.location.reload();" />
	</form>
	<p align="right"><font color="white">If you don't have an account <a href="register.php">register here</a>.</font></p>
<?php
} else {
	require_once("db_const.php");
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	# check connection
	if ($mysqli->connect_errno) {
		echo "<p>MySQL error no {$mysqli->connect_errno} : {$mysqli->connect_error}</p>";
		exit();
	}

	$username = $_POST['username'];
	$password = $_POST['password'];

	$sql = "SELECT * from users WHERE username LIKE '{$username}' AND password LIKE '{$password}' LIMIT 1";
	$result = $mysqli->query($sql);
	if (!$result->num_rows == 1) {
		echo "<p align='right'><font color='white'>Invalid username/password combination</font></p>";
	} else {
		echo "<p align='right'><font color='white'>Logged in successfully</font></p>";
		$_SESSION['loggedin'] = true;
		$_SESSION['username'] = $username;
	}
}
}
?>
</p>
</head> 
<body style="background-image:url(421815.jpg)"> 
<h3><font color="white">Search  Bugs</font></h3> 
<p><font color="white">You  may search either by player name or bug content</font></p> 
<form  method="post" action="look.php?go"  id="searchform"> 
<input  type="text" name="name"> 
<input  type="submit" name="submit" value="Search"> 
</form> 
<?php 
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
	  if(isset($_POST['submit'])){ 
	  if(isset($_GET['go'])){ 
	  if(preg_match("/^[  a-zA-Z]+/", $_POST['name'])){ 
	  $name=$_POST['name']; 
	  echo "<p><font color=\"white\">Search results for: ".$name."</font></p>";
	  // Create connection
			require_once("db_const.php");
$con=mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		// Check connection
		if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}
		$result1 = mysqli_query($con,"SELECT * FROM BUGS WHERE PNAME LIKE '%".$name."%' OR BUG LIKE '%".$name."%'");
 
	  //-create  while loop and loop through result set	  
	  while($row=mysqli_fetch_array($result1)){ 
	          $ID  =$row['ID']; 
	          $PNAME=$row['PNAME']; 
	          $BUG=$row['BUG']; 
echo "<font color=\"white\"><ul>\n"; 
echo "<li>".$PNAME . " | " . $BUG .  "</li>\n"; 
echo "</ul></font>"; 
} 
} 
else{ 
echo  "<p><font color=\"white\">Please enter a search query</font></p>"; 
} 
} 
}
}else{
echo "<font color=\"white\">You Must Be Logged In To View This</font>";
}
?> 
<hr>
<br />
<br />
<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
// Create connection
	require_once("db_const.php");
$con=mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$result = mysqli_query($con,"SELECT * FROM BUGS");

echo "<table border='1' BORDERCOLORLIGHT=\"#B2B2B2\" BORDERCOLORDARK=\"#7D7D7D\" bgcolor=\"#646464\" cellpadding=\"5\">
<tr>
<th><font color=\"white\">Player Name</font></th>
<th><font color=\"white\">Bug</font></th>
</tr>";

while($row = mysqli_fetch_array($result)) {
  echo "<tr>";
  echo "<td><font color=\"white\">" . $row['PNAME'] . "</font></td>";
  echo "<td><font color=\"white\">" . $row['BUG'] . "</font></td>";
  echo "</tr>";
}

echo "</font></table>";
if (!$result) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}
mysqli_close($con);
}else{
echo "<font color=\"white\">You Must Be Logged In To View This</font>";
}
?>
</body> 
</html> 
 