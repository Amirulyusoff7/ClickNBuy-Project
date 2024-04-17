<?php include('custvalidation.php'); ?>

<!DOCTYPE html>
<html>
<head>
<title>CUSTOMER</title>
<nav>
<a href="../admin/adminlogin.php">Admin</a>
<a href="../customer/custlogin.php">Customer</a>
<a href="../seller/sellerlogin.php">Seller</a> 
</nav>
<link rel="stylesheet" type="text/css" href="csscust/style.css"/>
</head>

  <br><br><br><br><br><br>
<body>
  
  <div class="wrapper">
  <div id="formContent">
    <!-- Tabs Titles -->
    <h2 class="active"> Login </h2>
    <!-- Login Form -->
    <form method="post" action="custlogin.php">
    <?php include('../errors.php');?> 
    <div>
     
      <input type="text" name="input" placeholder="username/email/id" required >
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
      <a href="emailphonecheck.php">Forgot Password?</a> 
      <a href="custregister.php">Register?</a> 
    </div>
  </div>
</div>
</body>

</html>


