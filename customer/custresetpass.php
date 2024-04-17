<?php include('resetpassvalidation.php'); ?>
<!DOCTYPE html>
<html>
<head>
	
	<link rel="stylesheet" type="text/css" href="csscust/style.css"/>
</head>
<body>
	<br><br><br><br><br><br>
	
  	<br>
	<form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
			
		<div>
			<label>New Password</label>
			<input type="password" name="newpass" placeholder="Enter your new password">
           <span style="color:red"><?php echo $newpassErr;?></span>
		</div>
       
		<div>
			<button name="submit" class="btn">Change</button>
		</div>
	</form>	
	
</div>
</div>
</body>
</html>