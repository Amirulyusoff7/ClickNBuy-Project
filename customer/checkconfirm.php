<?php include('../connect.php');
session_start();
$qry = "SELECT * FROM customer WHERE username='" . $_SESSION['ses'] . "'";
$result = mysqli_query($conn,$qry);
$rows=mysqli_fetch_array($result);
$cusID = $rows['customerID'];

?>


  <div align="center">
            <h3>Confirm Product</h3>
        <table border = "1" >
<tr>        <th> Image </th>
            <th> Name </th>
            <th> Variation 1 </th>
            <th> Variation 2 </th>
            <th> Quantity </th>
            <th>Price</th>

</tr>
        
        <?php
        $sql="SELECT * FROM cart JOIN productoption ON cart.productOptionID = productoption.productOptionID JOIN product ON product.productID = productoption.productID WHERE cart.customerID = '$cusID' ";
        
        if($result=mysqli_query($conn,$sql)){
            if(mysqli_num_rows($result)>0){
            
                while($item = mysqli_fetch_array($result)){
                   
                  ?>
                  <body>
    <tr>
                    <?php
                   $total_quantity = 0;
                   $total_price=0;
                   $item_price = $item["quantity"]*$item["unitPrice"];
                    ?>
                    <td><img src="<?php echo $item["image"]; ?>" class="cart-item-image" /></td>
                    <td><?php echo $item["name"]; ?></td>
                    <td><?php echo $item["variation1"]; ?></td>
                    <td><?php echo $item["variation2"]; ?></td>
                    <td style="text-align:center;"><?php echo $_SESSION['gquantity'];?></td>
                    
                    <td style="text-align:right;"><?php echo "$ ".number_format( $_SESSION['gtotal'],2); ?></td>
                  
                
                <?php
                }
            }
        }
        
                ?>
    </tr>
   
    </table>
    
    <a href="tocart.php">Back to Cart</a>
</div>
<?php               
$sqladr="SELECT * FROM address WHERE customerID = '$cusID '";
if ($ad = mysqli_query($conn,$sqladr)){
  if  (mysqli_num_rows($ad) > 0){
    while($a = mysqli_fetch_array($ad)){
       ?>
      
<div class="form-group">
<label>Name</label>
<input type="text" name="name" class="form-control" value="<?php echo $a["name"]; ?>"readonly>
</div>
<div class="form-group">
<label>Phone Number</label>
<input type="text" name="phoneNo" class="form-control" value="<?php echo $a["phoneNo"]; ?>"readonly>
</div>
<div class="form-group">
<label>House Number</label>
<input type="text" name="houseNo" class="form-control" value="<?php echo $a["houseNo"]; ?>"readonly>
</div>
<div class="form-group">
<label>Street Name</label>
<input type="text" name="streetName" class="form-control" value="<?php echo $a["streetName"]; ?>"readonly>
</div>
<div class="form-group">
<label>City</label>
<input type="text" name="city" class="form-control" value="<?php echo $a["city"]; ?>"readonly>
</div>
<div class="form-group">
<label>Postal Code</label>
<input type="text" name="postcode" class="form-control" value="<?php echo $a["postcode"]; ?>"readonly>
</div>
 <a onclick="return confirm('Proceed to payment?')" href="paymentMain.php">Payment</a>

        <?php
        }
    }else{
        echo "<script>alert('Please insert address');document.location='orderaddress.php'</script>";
    }
}

?>