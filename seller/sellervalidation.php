<?php include('../connect.php');

session_start();




$query ="SELECT * FROM seller ORDER BY sellerID DESC limit 1";
$result = mysqli_query($conn,$query);
$row = mysqli_fetch_array($result);

//for old phpmyadmin remove "?? null"
$lastid=$row['sellerID']?? null;

if($lastid==" ")
{
	$sellid="SEL1";
}
else
{	
	$sellid=substr($lastid,3);
	$sellid=intval($sellid);
	$sellid="SEL" . ($sellid + 1);
}
$addressErr = $icNoErr = $passwordErr = $shopnameErr="";
$address = $icNo = $password = $shopname="";
$errors = array();


if($_SERVER["REQUEST_METHOD"]=="POST"){

	if(!empty($_POST["password"]) && isset( $_POST["password"] )) {
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

	if(empty($_POST["pickUpAddress"])){
		$addressErr = "Address is required";
	}else {
		$address = test_input($_POST["pickUpAddress"]);
	}

	if(empty($_POST["icNo"])){
		$icNoErr = "IC Number is required";
		
	} else {
		$icNo = test_input($_POST["icNo"]);


		if(!preg_replace("/[^\d]/","",$icNo)){
			$icNoErr = "Allow only digit!";
		}
		elseif(!preg_match('/^[0-9]{6}-[0-9]{2}-[0-9]{4}$/',$icNo)){
			$icNoErr = "Wrong IC number !";
		}
		
		}

		if(empty($_POST["shopName"])) {
			$shopnameErr = "Shopname is required";
			
		} else {
				$shopname = test_input($_POST["shopName"]);
				if(!preg_match("/^[a-z,A-Z]*$/",$shopname)){
					$shopnameErr = "Only uppercase and lowercase allowed";
			} 
				else 
				{ 
					$query3 = mysqli_query($conn,"SELECT * FROM seller WHERE shopName='$shopname'");
					if(mysqli_num_rows($query3)>0)
						{
							$shopnameErr = "shopname already taken. Please try another one";
			
						}
					
			}
		}


	$custid=$_POST["custid"];
	$username=$_POST["username"];
	$name=$_POST["name"];
	$phoneNo=$_POST["phoneNo"];
	$email= $_POST["email"]; 
  	$secret = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
	$pin = substr(str_shuffle($secret),0,5);
	
	if($addressErr ==''and $icNoErr ==''and $passwordErr =='' and $shopnameErr ==''){
		
		$sqlsell = "INSERT INTO seller (sellerID,icNo,shopName,name,phoneNo,email,pickUpAddress,username,password,pin,customerID)
				VALUES ('$sellid','$icNo','$shopname','$name','$phoneNo','$email','$address','$username','$password','$pin','$custid')";
			// $sql = "INSERT INTO seller (sellerID,icNo,shopName,pickUpAddress,password,pin)
			// VALUES ('$sellid','$icNo','$shopname','$address','$password','$pin')";
		mysqli_query($conn,$sqlsell);

		
		 echo "<script>alert('Thank you for register');document.location='sellerpin.php'</script>";
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
	$username = ($_POST['username']);
	$password = ($_POST['password']);
	
			$query = "SELECT * FROM seller WHERE (username='$username' OR email='$username') AND password='$password'";
			$result = mysqli_query($conn,$query);
			
			$user_data = mysqli_fetch_array($result);
			
			 unset($user_data['password']);
			$_SESSION['user_data'] = $user_data;
	
			if (mysqli_num_rows($result) == 1){
				// log user in
				// Storing username in session variable 
				$_SESSION['username'] = $username; 
				// echo "<script>alert('You are logged in');document.location='sellerhome.php'</script>";
				echo "<script>alert('You are logged in');document.location='sellerhome.php'</script>";
			}else{
				array_push($errors,  "User does not exist");
			}
	}
	
	
	
	



?>
 