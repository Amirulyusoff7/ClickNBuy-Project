<?php include('../connect.php');

session_start();




$query ="SELECT * FROM admin ORDER BY adminID DESC limit 1";
$result = mysqli_query($conn,$query);
$row = mysqli_fetch_array($result);

//for old phpmyadmin remove "?? null"
$lastid=$row['adminID']?? null;

if($lastid==" ")
{
	$admid="ADM1";
}
else
{	
	$admid=substr($lastid,3);
	$admid=intval($admid);
	$admid="ADM" . ($admid + 1);
}

$nameErr = $icNoErr = $phoneNoErr = $emailErr = $isManagerErr = $passwordErr ="";
$name = $icNo = $phoneNo = $email = $isManager = $password ="";

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
		elseif(!preg_match('/^[0-9]{3}-[0-9]{7}$/',$phoneNo)&&!preg_match('/^[0-9]{3}-[0-9]{9}$/',$phoneNo)){
			$phoneNoErr = "Must contain between 10 and 12 !";
		}
		
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




	if(empty($_POST["email"])){
		$emailErr = "Email is required";
	} else {
		$email = test_input($_POST["email"]);
		if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
			$emailErr = "Invalid email format";
		}
		else{
			$query2 = mysqli_query($conn,"SELECT * FROM admin WHERE email='$email'");
			if(mysqli_num_rows($query2)>0)
				{
					$emailErr = "Email already taken. Please try another one";
		
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




	if(empty($_POST["isManager"])){
		$isManagerErr = "Position required";
	}else {
		$isManager = test_input($_POST["isManager"]);


	$secret = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
	$pin = substr(str_shuffle($secret),0,5);
	


	if($nameErr =='' and $icNoErr =='' and $phoneNoErr =='' and $emailErr =='' and $isManagerErr =''and $passwordErr = ''){	
		$sql = "INSERT INTO admin (adminID,name,icNo,phoneNo,email,isManager,password,pin)
				VALUES ('$admid','$name','$phoneNo','$email','$isManager','$password','$pin')" ;
		mysqli_query($conn,$sql);

		
		echo "<script>alert('Thank you for register');document.location='pin.php'</script>";
	}
}

	
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}













//log user in from loginadmin page
if(isset($_POST['login'])){
	$email = ($_POST['email']);
	$password = ($_POST['password']);
	
	if(empty($_POST["isManager"])){
		$isManagerErr = "Position required";
	}else {
		$isManager = test_input($_POST["isManager"]);

	}
	
	
	if($pstnErr==''){
		
			$query = mysqli_query($conn,"SELECT * FROM admin WHERE email='$email' AND password='$password'AND isManager='$isManager'");
			$result = mysqli_fetch_array($query);
	
			if ($result){
	
	
				if($password==$result['password']){
					
					$_SESSION['email']=$result['email'];
					$_SESSION['isManager']=$result['isManager'];
	
					if($pstn=="Yes"){
						echo "<script>alert('You are logged in');</script>";
						header('location=adminindex.php');
					}elseif($pstn=="No"){
						echo "<script>alert('You are logged in');</script>";
						header('location=../admin/adminindex.php');
					}
				} 
	
			}else{
				array_push($errors,  "User does not exist");
			}
		
	}
	}

}



?>
