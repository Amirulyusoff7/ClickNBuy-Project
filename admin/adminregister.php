<?php include('adminvalidation.php');?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin Register</title>
	<link rel="stylesheet" type="text/css" href="cssadmin/styleadm.css"/>
	
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<body>
	
		<div class="wrapper2 ">
	<div id="formContent">
		<h2 class="active"> ADMIN REGISTER </h2>
		<h5>*Must fill all the requirement*</h5>
	
	<form id="regisadmin" method="post" action="<?=$_SERVER['PHP_SELF'];?>">

	<div>
 	<input type="text"  name="id" id="id" style="color:red"  value="<?php echo $admid ; ?>" readonly>
   	</div> 
		

		<div>
      <input type="text" name="name" placeholder="name"><br>
      <span style="color:red"><?php echo $nameErr;?></span>
   		</div> 
		
		   <div>
    <input type="tel" name="icNo"placeholder="IC Number(xxxxxx-xx-xxxx)"><br>
    <span style="color:red"><?php echo $icNoErr;?></span>
    </div>


	<div>
    <input type="tel" name="phoneNo"placeholder="PhoneNo(xxx-xxxxxxxxx)"><br>
    <span style="color:red"><?php echo $phoneNoErr;?></span>
    </div>
	<div>
	<input type="text" name="email" placeholder="email"><br>
	<span style="color:red"><?php echo $emailErr;?></span> 
	</div>
	<div>
	<input type="password" name="password" placeholder="password"><br>
	<span style="color:red"><?php echo $passwordErr;?></span>
	</div>
	<div>
	<h5>*Are you a manager ?*</h5>
	<input type="checkbox" class="choose" name = "isManager" value ="Yes"><span>Manager</span>
  	<input type="checkbox" class="choose" name = "isManager" value ="No"><span>Staff</span>

  	<br><span style="color:red"><?php echo $isManagerErr?></span>
	</div>


		<script type="text/javascript">
	$('.choose').click(function() {
		$(this).siblings('input:checkbox').prop('checked',false);
	})
</script>
  		<br>
		<div>
			<input type= "submit" name="register" onclick="return confirm('Are you sure you want to proceed?')" class="btn"></button>
		</div>





	</form>
<br>
	<div id="formFooter">
	<a href="../admin/adminlogin.php">back</a>
</div>
</div>
</body>
</html>