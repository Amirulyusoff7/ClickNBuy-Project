<?php include ('../connect.php');   
session_start();
if(isset($_POST['update'])){
	//by row
	$id=$_GET['id'];
	//table brand
	$quantity=$_POST['quantity'];
	
   
    
  
  // $updStck = "UPDATE productoption SET  WHERE productOptionID = '$_GET[pid]'";
	//$update =  "UPDATE productoption,cart SET stockQuantity = stockQuantity -'$quantity', quantity='$quantity' WHERE productOptionID = '$prodOptId'";
	$update =  "UPDATE cart SET quantity='$quantity' WHERE cartID = '$id'";

	$data = mysqli_query($conn,$update);
				if ($data) {
					header('location:../customer/tocart.php');
				}else{
					echo 'Update Failed';
				}
            }

?>


<form  method="post">
<label for="quantity">Quantity:</label>
<input type="number" name="quantity" id="quantity" min="1" value="1">


<input type="submit" name="update" value="update data"  onclick="return confirm('Are you sure you want to proceed?')">
</form>