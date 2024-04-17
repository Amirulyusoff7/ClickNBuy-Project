<?php include('sellervalidation.php');?>
<!DOCTYPE html>
<html>
<head>
	<title>Secret Pin</title>
	<link rel="stylesheet" type="text/css" href="../csscust/style.css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</head>
<body>
	<div class="wrapper ">
	<div id="formContent">

<h2 class="active"> Secret Pin </h2>
 <form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
		<?php include ('../connect.php'); 
		
			$qry = "SELECT pin FROM seller";
			$result = mysqli_query($conn,$qry);
			if(mysqli_num_rows($result)>0){
				
					?>
					<input type="text"  name="id" id="id" style="color:green"  value="<?php echo $row['pin'] ; ?>" readonly>
					<?php
				
			}
			?>


	
   	<div id="formFooter">
	<a href="sellerlogin.php"  onclick="autoClick()">SELLER LOGIN</a>
	</div>
   	 
   		<br>
 </form>
</div>
</div>
<script> function autoClick(){
  alert("Please remember your pin!!!");
}
</script>


</body>
</html>
