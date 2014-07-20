<!DOCTYPE  HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd"> 
<html> 
<head> 
<meta  http-equiv="Content-Type" content="text/html;  charset=iso-8859-1"> 
<title>Heroes Team Bug Page</title> 
<center><img src="Header.png"></img></center>
</head> 
<body style="background-image:url(421815.jpg)"> 
<h3><font color="white">Search  Bugs</font></h3> 
<p><font color="white">You  may search either by player name or bug content</font></p> 
<form  method="post" action="look.php?go"  id="searchform"> 
<input  type="text" name="name"> 
<input  type="submit" name="submit" value="Search"> 
</form> 
<?php 
	  if(isset($_POST['submit'])){ 
	  if(isset($_GET['go'])){ 
	  if(preg_match("/^[  a-zA-Z]+/", $_POST['name'])){ 
	  $name=$_POST['name']; 
	  echo "<p><font color=\"white\">Search results for: ".$name."</font></p>";
	  // Create connection
		$con=mysqli_connect("127.0.0.1","Username","Password","database");

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
?> 
<hr>
<br />
<br />
<?php
// Create connection
$con=mysqli_connect("127.0.0.1","Username","Password","database");

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
?>
</body> 
</html> 
 