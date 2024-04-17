<?php
    
    include('./config/config.php"'); 
    
    session_start();
   
    //$sql="SELECT * FROM product INNER JOIN productoption ON product.productID = productoption.productID WHERE productID='$_GET[product]'";
    // $sql="SELECT * FROM product INNER JOIN productoption WHERE productID='$_GET[productid]'";
    $sql="SELECT * FROM product INNER JOIN productoption ON product.productID = productoption.productID WHERE product.productID ='$_GET[productid]'";
    $rs=mysqli_query($conn,$sql);
    $data=mysqli_fetch_array($rs);

    
    ?>
  
  <?php 
    $var_sql = "SELECT variationName1,variation1,variationName2,variation2, FROM productoption WHERE productID='$_GET[productid]'";
    $result=mysqli_query($conn,$var_sql);
    $row=mysqli_fetch_array($result);
    ?>




<h5>Name:<?php echo $data ['name']; ?></h5>
<h5>Price:<?php echo $data ['unitPrice']; ?></h5>
<h5>Description:<?php echo $data ['description']; ?></h5>
<?php echo $data ['variationName1']; ?> 
<h5><?php echo $data ['variation1']; ?></h5>
<h5><?php echo $data ['variationName2']; ?></h5>
<h5><?php echo $data ['variation2'];?></h5>