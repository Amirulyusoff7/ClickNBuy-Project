
 <?php include('../connect.php');

session_start();


$email = "";
$errors = array();



if(isset($_POST['send'])){
$email = ($_POST['email']);
$phoneNo = ($_POST['phoneNo']);
$pin = ($_POST['pin']);

	if(count($errors) == 0){
		$check = "SELECT * FROM admin WHERE email='".$email."' AND phoneNo='".$phoneNo."'";
		$result = mysqli_query($conn,$check);

		if (mysqli_num_rows($result)==1){
			
				
				$check2="SELECT * FROM admin WHERE pin='".$pin."'";
				$result2 = mysqli_query($conn,$check2);
				if(mysqli_num_rows($result2)==1){
					// log user in
				header('location:custresetpass.php?email='.$email);
				}elseif($pin!=$result);{
					array_push($errors, "Wrong pin!");
				}
			}else{
				array_push($errors, "Does not exist");
			}




	}
}

?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="cssadmin/styleadm.css"/>
</head>
<body>
	

  	<br>
	  <div class="wrapper2 ">
	<div id="formContent">
	<form method="post">
<?php include('../errors.php');?>
		<div>
			
			<input type="text" name="email" placeholder="Enter your email">
		</div>
		<div>
			
		<input type="tel" name="phoneNo"placeholder="PhoneNo(xxx-xxxxxxxxx)"><br>
		</div>
		<br>
		<div>
			
			<input type="text" name="pin" placeholder="Enter your given pin">
		</div>
		<div>
			<input type = "submit" name="send" class="btn"></button>
		</div>		
	</form>
	<br>
	<div id="formFooter">
	<a href="../admin/adminlogin.php">back</a>
</div>
</div>
</body>
</html>

