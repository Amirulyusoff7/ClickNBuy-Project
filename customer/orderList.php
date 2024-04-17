<!-- add product to table cart -->
<?php include('../connect.php');
session_start();
$qry = "SELECT * FROM customer WHERE username='" . $_SESSION['ses'] . "'";
$result = mysqli_query($conn,$qry);
$rows=mysqli_fetch_array($result);
$cusID = $rows['customerID'];



if(isset($_POST['add'])){

    $opt=$_POST["variation1"];
    $quantity = $_POST['quantity'];
    $sql = "INSERT INTO cart (cartID,quantity,customerID,productOptionID)
    VALUES ('','$quantity','$cusID','$opt')" ;
    $data= mysqli_query($conn,$sql);
    

}



?>
<!DOCTYPE html>
<html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<h2>In Cart</h2>
  <div align="center">
            <table border = "1" >
            <tr>
             
                <th> Name </th>
                <th> Variation 1 </th>
                <th> Variation 2 </th>
                <th>Price per</th>
                <th>Quantity</th>
                <th>Price</th>
                
            </tr>
<!-- view product in page tocart.php -->
<?php
       
        $sql="SELECT * FROM cart JOIN productoption ON cart.productOptionID = productoption.productOptionID JOIN product ON product.productID = productoption.productID WHERE cart.customerID = '$cusID'  ";
        // $c=mysqli_query($conn,$sql);
        // $item=mysqli_fetch_array($c);
        

        if($result=mysqli_query($conn,$sql)){
        if(mysqli_num_rows($result)>0){
            $gtotal = 0;
            $gquantity = 0;
            while($item = mysqli_fetch_array($result)){
               
              ?>
              <body>
<tr>
                <?php
               $total_quantity = 0;
               $total_price=0;
               $item_price = $item["quantity"]*$item["unitPrice"];
              

                ?>
             
                  
           
				<td><img src="<?php echo $item["image"]; ?>" class="cart-item-image" /><?php echo $item["name"]; ?></td>
                <td><?php echo $item["variation1"]; ?></td>
                <td><?php echo $item["variation2"]; ?></td>
				<td><?php echo "$ ".$item["unitPrice"]; ?></td>
                <td><?php echo $item["quantity"]; ?></td>
              
				<td  style="text-align:right;"><?php echo "$ ". number_format($item_price,2); ?></td>
				
				<?php
                
				$total_quantity += $item["quantity"];
				$total_price += ($item["unitPrice"]*$item["quantity"]);
                $gtotal+=$item_price;
                $gquantity+=$total_quantity;
                ?>

       
            <!-- <td align="right"><?php echo $total_quantity; ?></td>
            <td><strong><?php echo "$ ".number_format($total_price, 2); ?></strong></td> -->
</tr>
<br>

</body>	
<?php  
                }
            }
            ?>
            </table>
            <br>
            <div align="center">
            <table border = "1" >
            <tr>
            <th> Grand Total Quantity </th>
            <th> Grand Total Price</th>
               
           </tr>
           
            <td  style="text-align:right;"><?php echo $gquantity; ?></td>
            <td style="text-align:right;"><?php echo "$ ".number_format($gtotal,2); ?></td>
        </table>
            <?php
            
            $_SESSION['gquantity']=($gquantity);
            $_SESSION['gtotal']=($gtotal);

        }
    

 ?>
 <br>
 <form>
 <a href="checkconfirm.php?customerid=<?php echo $cusID?>" name ="select" class="btn btn-primary btn-sm">Next</a>

</form>
<a href="custhome.php">Homepage</a>
</html>



