<?php include ('../connect.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Update/edit Profile</title>
	<!--<link rel="stylesheet" type="text/css" href="csscust/style2.css"/>-->
</head>
<body>
	<div align="center">
			<h3>Update profile</h3>
		</div> 
<?php 
session_start();

$nameErr = $phoneNoErr = $emailErr = $usernameErr =  $passwordErr = "";
$name = $phoneNo = $email = $username =  $password = "" ;
$errors = array();



if($_SERVER["REQUEST_METHOD"]=="POST"){


	if(empty($_POST["name"])) {
		$nameErr = "Your Name is required";
	} else {
		$name = test_input($_POST["name"]);
		if(!preg_match ("/^[A-Z ]*$/", $name) ){
			$nameErr = "Must uppercase";
		}
	}

	
	if(empty($_POST["phoneNo"])){
		$phoneNoErr = "Phone Number is required";
		
	} else {
		$phoneNo = test_input($_POST["phoneNo"]);


		if(!preg_replace("/[^\d]/","",$phoneNo)){
			$phoneNoErr = "Allow only digit!";
		}
		elseif(!preg_match('/^[0-9]{3}-[0-9]{7}$/',$phoneNo)&&!preg_match('/^[0-9]{3}-[0-9]{8}$/',$phoneNo)&&!preg_match('/^[0-9]{3}-[0-9]{9}$/',$phoneNo)){
			$phoneNoErr = "Must contain between 10 and 12 !";
		}
		
		}
		

	if(empty($_POST["email"])){
		$emailErr = "Email is required";
	} else {
		$email = test_input($_POST["email"]);
		if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
			$emailErr = "Invalid email format";
		}
		// else{
		// 	$query2 = mysqli_query($conn,"SELECT * FROM customer WHERE email='$email'");
		// 	if(mysqli_num_rows($query2)>0)
		// 		{
		// 			$emailErr = "Email already taken. Please try another one";
		
		// 		}
			
		// }
	}

	if(empty($_POST["username"])) {
		$usernameErr = "Username is required";
		
	} else {
			$username = test_input($_POST["username"]);
			if(!preg_match("/^[a-z0-9]*$/",$username)){
				$usernameErr = "Only letters, digit and white space allowed";
		} 
			else 
			{ 
				$query3 = mysqli_query($conn,"SELECT * FROM customer WHERE username='$username'");
				if(mysqli_num_rows($query3)>0)
					{
						$usernameErr = "Username already taken. Please try another one";
		
					}
				
		}
	}
	

	
	if(!empty($_POST["password"]) && isset( $_POST['password'] )) {
		$password = test_input($_POST["password"]);
		
		if (mb_strlen($_POST["password"]) <= 5) {
			$passwordErr = "Your Password Must Contain At Least 5 Characters!";
		}
		elseif(!preg_match("#[0-9]+#",$password)) {
			$passwordErr = "Your Password Must Contain At Least 1 Number!";
		}
		elseif(!preg_match("#[A-Z]+#",$password)) {
			$passwordErr = "Your Password Must Contain At Least 1 Capital Letter!";
		}
		elseif(!preg_match("#[a-z]+#",$password)) {
			$passwordErr = "Your Password Must Contain At Least 1 Lowercase Letter!";
		}
		elseif(!preg_match("#[\W]+#",$password)) {
			$passwordErr = "Your Password Must Contain At Least 1 Special Character!";
		} 
	} else {
		$passwordErr = "Password is required";
	}	





    if($nameErr =='' and $phoneNoErr =='' and $emailErr =='' and $usernameErr =='' and $passwordErr == ''){
		
        $update = "UPDATE customer SET customer.name='$name',customer.phoneNo='$phoneNo',customer.email='$email',customer.username='$username',customer.password='$password' WHERE customer.customerID='$_GET[i]'";
		$data=mysqli_query($conn,$update);
        if ($data) {
           echo "<script>alert('Profile has been updated');window.location='custedit.php'</script>";
			
        
        }else{
            echo 'Update Failed';
        }

       
	}
}
	
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// function cancelShipping() {
// 	fetch("deliveryForm.php")
// 	.then(response => {
// 		if (response.ok) {
// 			window.location.href = "manageOrder.php"
// 		}
// 	})
// 	.catch(error => console.log(error));
// }



$qry = "SELECT * FROM customer WHERE username='" . $_SESSION['ses'] . "'";
$result = mysqli_query($conn,$qry);
$row=mysqli_fetch_array($result);
?> 




<form  method="POST" >
<div align="center">Your Profile</div>
<table align="center">
<tr>
<td> <div>Customer id:</div> </td>
<td><input type="text" name="id1" style="color:mediumseagreen"  value="<?php echo $row['customerID'];?>" readonly></td>
</tr>
<tr>
<td><div>Name:</div></td>
<td><input type="text" name="name" value="<?php echo $row['name']; ?>" placeholder="Name"><br>
<span style="color:red"><?php echo $nameErr;?></span>
</td>
</tr>
<tr>
<td><div>Username:</div></td>
<td><input type="text" name="username" value="<?php echo $row['username']; ?>" placeholder="Username"><br>
<span style="color:red"><?php echo $usernameErr;?></span>
</td>
</tr>
<tr>
<td>Password:</div></td>
<td><input type="text" name="password" value="<?php echo $row['password']; ?>" placeholder="Password"><br>
<span style="color:red"><?php echo $passwordErr;?></span>
</td>
</tr>
<tr>
<td>Email:</div></td>
<td><input type="text" name="email" value="<?php echo $row['email']; ?>" placeholder="Email"><br>
<span style="color:red"><?php echo $emailErr;?></span>
</td>
</tr>
<tr>
<td><div>Phone Number:</div></td>
<td><input type="text" name="phoneNo" value="<?php echo $row['phoneNo']; ?>" placeholder="PhoneNo(xxx-xxxxxxx)"><br>
<span style="color:red"><?php echo $phoneNoErr;?></span>
</td>
</tr>
<tr>

</table>

<div align="center">
<a href="custhome.php"><button type="button">Back</button></a>
<button type="submit" name="update" onclick="return confirm('Are you sure you want to proceed?')">Update</button>
</div>
	
	</form>

</div>
</body>
</html>
