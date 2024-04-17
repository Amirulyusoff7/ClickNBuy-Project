<?php include('../connect.php'); 

session_start();
$newpassErr = "";
$newpass = "";


if($_SERVER["REQUEST_METHOD"]=="POST"){
   
   
    
if(!empty($_POST["newpass"]) && isset( $_POST['newpass'] )) {
    $newpass = test_input($_POST["newpass"]);
    
    if (mb_strlen($_POST["newpass"]) <= 5) {
        $newpassErr = "Your Password Must Contain At Least 5 Characters!";
    }
    elseif(!preg_match("#[0-9]+#",$newpass )) {
        $newpassErr = "Your Password Must Contain At Least 1 Number!";
    }
    elseif(!preg_match("#[A-Z]+#",$newpass )) {
        $newpassErr = "Your Password Must Contain At Least 1 Capital Letter!";
    }
    elseif(!preg_match("#[a-z]+#",$newpass )) {
        $newpassErr = "Your Password Must Contain At Least 1 Lowercase Letter!";
    }
    elseif(!preg_match("#[\W]+#",$newpass )) {
        $newpassErr= "Your Password Must Contain At Least 1 Special Character!";
    } 
} else {
    $newpassErr = "Password is required";
}




//reset password 
  
    if($newpassErr == ''){
        //$email=$_GET['email'];
        $email = $_SESSION["email"];
	    $changepass = "UPDATE customer SET password='$newpass' WHERE email='$email'";
	    mysqli_query($conn,$changepass);
        //echo "<script>alert('Your password has been changed');document.location='custlogin.php'</script>";
        echo "<script>alert('Your password has been changed');</script>";
    }
}


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  



?>