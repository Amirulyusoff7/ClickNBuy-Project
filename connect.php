<?php 

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$db_name = "clicknbuy";


// Create connection 
$conn = mysqli_connect($servername, $username, $password, $db_name); 

// Check connection 
if (!$conn) { die("Connection failed: " . mysqli_connect_error()); 
} 
//echo "Connected to mySQL";

//mysqli_close($conn); 

//REGISTER
// if(isset($_POST['Submit'])) {	
// 	$name = mysqli_real_escape_string($conn, $_POST['name']);
// 	$icNo = mysqli_real_escape_string($conn, $_POST['icNo']);
// 	$phoneNo = mysqli_real_escape_string($conn, $_POST['phoneNo']);
// 	$email = mysqli_real_escape_string($conn, $_POST['email']);
// 	$isManager = mysqli_real_escape_string($conn, $_POST['isManager']);
		
// 	// checking empty fields
// 	if(empty($name) || empty($icNo) || empty($phoneNo) || empty($email)  || empty($isManager) ) {
				
// 		if(empty($name)) {
// 			echo "<font color='red'>Name field is empty.</font><br/>";
// 		}
		
// 		if(empty($icNo)) {
// 			echo "<font color='red'>Age field is empty.</font><br/>";
// 		}
		
// 		if(empty($phoneNo)) {
// 			echo "<font color='red'>Email field is empty.</font><br/>";
// 		}

// 		if(empty($email)) {
// 			echo "<font color='red'>Email field is empty.</font><br/>";
// 		}

// 		if(empty($isManager)) {
// 			echo "<font color='red'>Email field is empty.</font><br/>";
// 		}
		
// 		//link to the previous page
// 		echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
// 	} else { 
// 		// if all the fields are filled (not empty) 
			
// 		//insert data to database	
// 		$result = mysqli_query($conn, "INSERT INTO admin(name,icNo, phoneNo, email, isManager) VALUES('$name','$icNo', '$phoneNo', '$email', '$isManager')");
// 		mysqli_query($conn, $result);
// 		//display success message
// 		echo "<font color='green'>Data added successfully.";
// 		echo "<br/><a href='index.php'>View Result</a>";
// 	}
// }
?>
</body>
</html>

