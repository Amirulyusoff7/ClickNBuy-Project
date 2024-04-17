<?php include('../connect.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Profile Account</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="csscust/style2.css"/>
</head>
<body>


<?php
session_start();
$qry = "SELECT * FROM customer WHERE username='" . $_SESSION['username'] . "'";
$result = mysqli_query($conn,$qry);
$rows=mysqli_fetch_array($result);


?>

<div align="center"><h1>Your Profile</h1></div>
<div align="center">
<table border="1">
  <tr>
    <td>Customer ID</td>
    <td>Username</td>
    <td>Email</td>
    <td>Phone Number</td>
    <td>Home Address</td>
    <td>Password</td>
    <td>Secret Pin</td>
  </tr>


  <tr>
    <td><?php echo $rows['customerID']; ?></td>
    <td><?php echo $rows['name']; ?></td>
    <td><?php echo $rows['phoneNo']; ?></td>
    <td><?php echo $rows['email']; ?></td>
    <td><?php echo $rows['username']; ?></td>
    <td><?php echo $rows['password']; ?></td>
    <td><?php echo $rows['pin']; ?></td>
  </tr>
</table>
</div>


<br><br><br><br>
<div align="center">
<a href="custedit.php?i=<?php echo $rows['customerID']; ?>">
<!-- <a href="custedit.php?i=<?php echo $rows['customerID']; ?>"> -->
<button type="button" >Update Profile</button>
<a href="custhome.php">
<button type="button">Back</button></a>
</a>
</div>


</br>
  <script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
}
</script>
</div>
</body>
</html> 