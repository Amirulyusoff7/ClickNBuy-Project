<?php include('../connect.php');

session_start();




$query ="SELECT * FROM customer ORDER BY customerID DESC limit 1";
$result = mysqli_query($conn,$query);
$row = mysqli_fetch_array($result);


$lastid=$row['customerID']?? null;

if($lastid==" ")
{
	$custid="CUS1";
}
else
{	
	$custid=substr($lastid,3);
	$custid=intval($custid);
	$custid="CUS" . ($custid + 1);
}




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
		else{
			$query2 = mysqli_query($conn,"SELECT * FROM customer WHERE email='$email'");
			if(mysqli_num_rows($query2)>0)
				{
					$emailErr = "Email already taken. Please try another one";
		
				}
			
		}
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

	

	





	/*if(empty($_POST["address"])){
		$addressErr = "Address is required";
	}else {
		$address = test_input($_POST["address"]);
	}*/

	


	$secret = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
	$pin = substr(str_shuffle($secret),0,5);
	
	if($nameErr =='' and $phoneNoErr =='' and $emailErr =='' and $usernameErr =='' and $passwordErr == ''){
		
		$sql = "INSERT INTO customer (customerID,name,phoneNo,email,username,password,pin)
				VALUES ('$custid','$name','$phoneNo','$email','$username','$password','$pin')" ;
		mysqli_query($conn,$sql);

		//echo "<script>alert('Thank you for register');document.location='custregister.php'</script>";
		echo "<script>alert('Thank you for register');document.location='pin.php'</script>";
	}
}
	
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}














//log user in from login page
if(isset($_POST['login'])){
$username = ($_POST['input']);
$password = ($_POST['password']);

		$query = "SELECT * FROM customer WHERE (username='$username' OR email='$username' OR customerID='$username') AND password='$password'";
		$result = mysqli_query($conn,$query);
		
		$user_data = mysqli_fetch_array($result);
		
		 unset($user_data['password']);
		$_SESSION['user_data'] = $user_data;

		if (mysqli_num_rows($result) == 1){
			// log user in
			// Storing username in session variable 
			$_SESSION['ses'] = $username; 
			echo "<script>alert('You are logged in');document.location='custhome.php'</script>";
		}else{
			array_push($errors,  "User does not exist");
		}
}








?>