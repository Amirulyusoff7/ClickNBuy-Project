<?php include('../admin/adminvalidation.php'); 
// include('../admin/bar/adminheader.php');
?>

<!DOCTYPE html>
<html>
<head>
<title>ADMIN</title>

<nav>
<a class = "rightactive" href="../admin/adminlogin.php">Admin</a>
<a href="../customer/custlogin.php">Customer</a>
<a href="../seller/sellerlogin.php">Seller</a> 
</nav>
<link rel="stylesheet" type="text/css" href="cssadmin/styleadm.css"/>
</head>

  <br><br><br><br><br><br>
<body>
  
  <div class="wrapper">
  <div id="formContent">
    <!-- Tabs Titles -->
    <h2 class="active"> Admin Login </h2>
    <!-- Login Form -->
    <form method="post" action="adminlogin.php">
    <?php include('../errors.php');?> 
    <div>
     
      <input type="text" name="email" placeholder="email" required >
    </div>
    <br>
    <div>
      
      <input type="password" name="password" placeholder="password" required>
    </div>
    <br>
    
      <input type= "submit" name="login" value="Login">
   
  </form>
   <br>
   
    <!-- reset Password -->
    <div id="formFooter">
      <a href="adminemailphonecheck.php">Forgot Password?</a> 
      <a href="adminregister.php">Register?</a> 
    </div>
  </div>
</div>
</body>
</html>


