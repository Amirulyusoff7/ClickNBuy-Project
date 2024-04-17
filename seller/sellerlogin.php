<?php include('sellervalidation.php'); ?>

<!DOCTYPE html>
<html>
<head>
<title>CUSTOMER</title>
<nav>
<a href="../admin/adminlogin.php">Admin</a>
<a href="../customer/custlogin.php">Customer</a>
<a href="../seller/sellerlogin.php">Seller</a> 
</nav>
<link rel="stylesheet" type="text/css" href="csssell/stylesell.css"/>
</head>

  <br><br><br><br><br><br>
<body>
  
  <div class="wrapper">
  <div id="formContent">
    <!-- Tabs Titles -->
    <h2 class="active">Seller Login </h2>
    <!-- Login Form -->
    <form method="post" action="sellerlogin.php">
    <?php include('../errors.php');?> 
    <div>
     
      <input type="text" name="username" placeholder="username/email" required >
    </div>
    <br>
    <div>
      
      <input type="password" name="password" placeholder="password" required>
    </div>
    <br>
    
      <input type= "submit" name="login" value="Login">
   
  </form>
   <br>
   
    <!-- Remind Password -->
    <div id="formFooter">
      <h5> Be customer to register </h5>
      <a href="sellemailphonecheck.php">Forgot Password?</a> 
      
  </div>
</div>
</body>
</html>


