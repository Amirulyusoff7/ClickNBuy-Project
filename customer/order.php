<!-- add product to table cart -->
<?php include('../connect.php');
session_start();
$qry = "SELECT * FROM customer WHERE username='" . $_SESSION['ses'] . "'";
$result = mysqli_query($conn,$qry);
$rows=mysqli_fetch_array($result);
$cusID = $rows['customerID'];



if(isset($_POST['order'])){
$sql2 = "SELECT MAX(paymentID) FROM payment";
$result2 = $conn->query($sql2);
$fetch3 = mysqli_fetch_array($result2);
$paymentID =  $fetch3["MAX(paymentID)"];
// if(mysqli_num_rows($result2 > 0 ))
// {
//     while($row = $result2->fetch_assoc()){
//         $paymentID =  $row["MAX(paymentID)"];
//     }
// }

$sql="SELECT * FROM address WHERE customerID = '$cusID'";
$result = mysqli_query($conn,$sql);
$fetch2 = mysqli_fetch_array($result);
$aID = $fetch2["addressID"];

$sql="INSERT INTO `order` (orderID,orderDate,orderStatus,totalPrice,addressID,customerID,paymentID) VALUES('',now(),'To ship','$_SESSION[gtotal]','$aID','$cusID','$paymentID')";
$ord = mysqli_query($conn,$sql);
if($ord){
    $sql2 = "SELECT MAX(orderID) FROM `order`;";
    $result2 = $conn->query($sql2);
    $fetch4 = mysqli_fetch_array($result2);
    $orderid =  $fetch4["MAX(orderID)"]; 
    $qw="SELECT * FROM cart, product,productoption
    WHERE cart.productOptionID = productoption.productID AND
    productoption.productID = product.productID AND customerID = '".$cusID."'";
    // $resultList = $conn->$query($qw);
   $resultList=  mysqli_query($conn,$qw);
    if($resultList) {

        while($cart = mysqli_fetch_assoc($resultList)) {
            $totalPrice = $resultlist[unitPrice] * $resultlist[quantity];

            $selleridquery = "SELECT * FROM seller, productOption, product WHERE seller.sellerID = product.sellerID 
            AND productoption.productID = product.productID;";
            $selleridresult = $conn->query($selleridquery);
            $resultRow = mysqli_fetch_array($selleridresult);
            $sellerID =  $resultRow["sellerID"]; 
            echo $orderID." ".$cart["productOptionID"]." ".$cart["quantity"]." ".$totalPrice." ".$sellerID;
            // $insertQw = "INSERT INTO `orderlist`(`orderListID`, `orderID`, `productOptionID`, `quantity`, `totalPrice`, `deliveryID`, `sellerID`) VALUES ('','$orderID', '$cart[productOptionID]', '$cart[quantity]','$totalPrice','','$sellerID')";
            $insertQw = "INSERT INTO orderlist (orderListID, orderID, productOptionID, quantity, totalPrice, deliveryID, sellerID) VALUES ('','$orderID', '$cart[productOptionID]', '$cart[quantity]','$totalPrice','','$sellerID')";
            // $res =$conn->$query($insertQw);
            mysqli_query($conn,$insertQw);
            
        }
    }
}

//  echo $_SESSION["gtotal"]. "".$paymentID."". $aID."". $cusID;
// $opt=$_POST["variation1"];
  // $quantity = $_POST['quantity'];
  // $sql = "INSERT INTO cart (cartID,quantity,customerID,productOptionID)
  // VALUES ('','$quantity','$cusID','$opt')" ;
  // $data= mysqli_query($conn,$sql);
  

}


?>
<!DOCTYPE html>
<html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<h2>Order List</h2>

<?php
$sql="SELECT * FROM address WHERE customerID = '$cusID'";
$result =mysqli_query($conn,$sql);
$fetch = mysqli_fetch_array($result);
                ?>

<div align="center">
<form action = "order.php" method = "post">
            <table border = "1" >
            <tr>
            <th> Name </th>
            <th> Phone Number </th>
            <th> House Number </th>
            <th>Street Name</th>
            <th>City</th>
            <th>Postcode</th>

           </tr>
           
        <tr>
           <td><?php echo $fetch["name"]; ?></td>
            <td><?php echo $fetch["phoneNo"]; ?></td>
            <td><?php echo $fetch["houseNo"]; ?></td>
            <td><?php echo $fetch["streetName"]; ?></td>
            <td><?php echo $fetch["city"]; ?></td>
            <td><?php echo $fetch["postcode"]; ?></td>
           
        <tr>
        </table>
        </div>








  <div align="center">
            <table border = "1" >
            <tr>
                <th> Image </th>
                <th> Name </th>
                <th> Variation 1 </th>
                <th> Variation 2 </th>
                <th>Price per</th>
                <th>Quantity</th>
                <th>Price</th>
                
            </tr>

<?php
       
        $sql="SELECT * FROM cart JOIN productoption ON cart.productOptionID = productoption.productOptionID JOIN product ON product.productID = productoption.productID WHERE cart.customerID = '$cusID'  ";
       
        // $c=mysqli_query($conn,$sql);
        // $item=mysqli_fetch_array($c);
        // $sql="SELECT *, SUM(quantity) FROM cart JOIN productoption ON cart.productOptionID = productoption.productOptionID JOIN product ON product.productID = productoption.productID WHERE cart.customerID = '$cusID'  GROUP BY productOptionID";

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
             
                  
                <td><img src="<?php echo $item["image"]; ?>" class="cart-item-image" /></td>
                <td><?php echo $item["name"]; ?></td>
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
</tr>
<br>

</body>	


<?php  

                }
?>
              <?php  
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
        </div>
         
         
<?php

        }
 ?>
 <br>

 <input type="submit" name="order" style="margin-top: 5px;" class="btn btn-success" value="Homepage" >
 </form>
 <!-- <a href="custhome.php?i=<?php echo $cusID;?>">Back to homepage</a> -->
 
</html>




