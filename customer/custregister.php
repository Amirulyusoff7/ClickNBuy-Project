<?php include('custvalidation.php');?>

<!DOCTYPE html>
<html> 
    <head>
        <title> CUSTOMER REGISTER </title>
        <link rel="stylesheet" type="text/css" href="csscust/style.css"/>

    </head>

    <body>
<div class="box">
<div class="wrapper3">
<div id="formContent">
<h3> REMEMBER</h3>
<h5> name must uppercase</h5>
<h5> Phone number must digit, contain 10 - 12 digit </h5>
<h5> must user email format </h5>
<h5> Username allow letter & digit </h5>
<h5> Password must at least 5 character,1 number,1 capital letter,1 lower case & 1 special character </h5>
</div>
</div>
    <div class="wrapper2">
	<div id="formContent">
        <h2> CUSTOMER REGISTER </h2>
        <h5 style="color:Red;">*Must fill all the data </h5>


        <form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
 	  <div>
 	      <input type="text"name="id" id="id" style="color:green"  value="<?php echo $custid ; ?>" readonly>
   	</div> 
   		<br>

    <div><input type="text" name="name" placeholder="name"><br>
      <span style="color:red"><?php echo $nameErr;?></span>
    </div> 

    <div>
    <input type="tel" name="phoneNo"placeholder="PhoneNo(xxx-xxxxxxxxx)"><br>
    <span style="color:red"><?php echo $phoneNoErr;?></span>
    </div>

    <div>
	<input type="text" name="email" placeholder= "Email"><br>
	<span style="color:red"><?php echo $emailErr;?></span>
	</div>

     <div>
      <input type="text" name="username" placeholder="username" ><br>
      <span style="color:red"><?php echo $usernameErr;?></span>
    </div> 

    <div>
    <input type="password" name="password" placeholder="Password"><br>
    <span style="color:red"><?php echo $passwordErr;?></span>
    </div>
    <br>
    <div>
    <input type= "submit" name="register"  onclick="return confirm('Are you sure you want to proceed?')"></button>
    </div>
    </form>
    <br>



	<div id="formFooter">
	<a href="custlogin.php">back</a>
	</div>
</div>
</div>

</div>
</body>
</html>

</html>