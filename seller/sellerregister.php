<?php include('sellervalidation.php');?>

<!DOCTYPE html>
<html> 
    <head>
        <title> SELLER REGISTER </title>
        <link rel="stylesheet" type="text/css" href="csscust/style.css"/>

    </head>

    <body>
        <h2> ACCOUNT REGISTER </h2>
       <!-- <h5>*Must have customer account first, if want to be a seller </h5>-->
        <h5>*Must fill all the requirement </h5>




    <?php
    $qry = "SELECT * FROM customer WHERE username='" . $_SESSION['ses'] . "'";
    $result = mysqli_query($conn,$qry);
    $row=mysqli_fetch_array($result);
    ?> 

    <form method="post" action="<?=$_SERVER['PHP_SELF'];?>">

 	<div> 
  
 	<input type="text"  name="id" id="id" style="color:blue" value="<?php echo $sellid ; ?>" readonly>
   	</div> 
   
    <div>
    <input type="tel" name="icNo" placeholder="IC Number(xxxxxx-xx-xxxx)"><br>
    <span style="color:red"><?php echo $icNoErr;?></span>
    </div>

    <div>
 	<input type="text" name="username" style="color:green"  value="<?php echo $row['username']; ?>" readonly>
   	</div> 

    <div>
      <input type="text" name="name" style="color:green"value="<?php echo $row['name']; ?>"readonly> 
      <br>
    </div> 

    <div>
    <input type="tel" name="phoneNo"style="color:green"value="<?php echo $row['phoneNo']; ?>"readonly>
    <br>
    
    </div>

    <div>
	<input type="text" name="email" style="color:green"value="<?php echo $row['email']; ?>"readonly>
    <br>
	</div>

    <div>
    <input type="text" name="shopName" placeholder="shopname"><br>
    <span style="color:red"><?php echo $shopnameErr;?></span>
    </div> 

    <div>
    <input type ="text" rows="-3" cols="30" name="pickUpAddress" placeholder="Address"><br>
    <span style="color:red"><?php echo $addressErr?></span>
    </div>

    <div>
    <input type="password" name="password" placeholder="Password"><br>
    <span style="color:red"><?php echo $passwordErr;?></span>
    <div>

    <div>
 	<input type="text"  name="custid" id="id" style="color:green"  value="<?php echo $row['customerID']; ?>" readonly>
   	</div> 

    <div>
    <button type= "submit" name="register"  onclick="return confirm('Are you sure you want to proceed?')">Register</button>
    </div>
    
    </form>
    <br>
    
	<div id="formFooter">
	<a href="../customer/custhome.php">back</a>
	</div>

</body>
</html>


