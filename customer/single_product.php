   <?php
include('../connect.php'); 
session_start();
$qry = "SELECT * FROM customer WHERE username='" . $_SESSION['ses'] . "'";
$result = mysqli_query($conn,$qry);
$rows=mysqli_fetch_array($result);
$username=$_SESSION['ses'] ;

?> 

<!DOCTYPE html>
<html lang="en">


  <meta charset="UTF-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title> HOMEPAGE </title>
  <!-- <link rel="stylesheet" type="text/css" href="../general.css"/> -->
  <link rel="stylesheet" type="text/css" href="csscust/stylehome.css"/>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />
  <link rel="stylesheet" type="text/css" href="csscust/cart-css.css"/>
  <head>
  <ul>
        <li><a> CLICKNBUY</a></li>
        <li class = "rightactive">
            <a href="#"><?php echo $username;?>▾</a>
            <ul class="dropdown">
                <li><a href="../seller/sellerregister.php">Register seller</a></li>
                <li><a href="custedit.php?i=<?php echo $rows['customerID'];?>">Profile</a>
                <li><a href="logoutcust.php">Logout</a></li>
            </ul>
        </li>
        <li class="rightactive"><a href="tocart.php"><i class="fas fa-shopping-cart"></i> <span id="cart-item" class="badge badge-danger"></span></a>
        </li>
        
    </ul>
</head>

        <?php
        
        include('../connect.php'); 
        
        //session_start();
    
        //$sql="SELECT * FROM product INNER JOIN productoption ON product.productID = productoption.productID WHERE productID='$_GET[product]'";
        // $sql="SELECT * FROM product INNER JOIN productoption WHERE productID='$_GET[productid]'";
        $sql="SELECT * FROM product INNER JOIN productoption ON product.productID = productoption.productID WHERE product.productID ='$_GET[productid]' ";
        $rs=mysqli_query($conn,$sql);
        $data=mysqli_fetch_array($rs);
        ?>

<img src="<?= $row['image'] ?>" class="cart-img" height="250">




<div class= form-cart>
    
<form method="post" action="tocart.php?pid=<?php echo $_GET['productid']; ?>">
<!-- <form method="post" action="<?=$_SERVER['PHP_SELF'];?>"> -->



<h5>Name: <?php echo $data ['name']; ?></h5>
<h5>Price:</h5>

<!-- <label for="unitPrice"><?php echo $data['unitPrice']; ?></label> -->

<?php
$sq="SELECT min(unitPrice), max(unitPrice) FROM productoption, product WHERE product.productID = productoption.productID AND product.productID='$_GET[productid]'";
$res = mysqli_query($conn, $sq);
if (mysqli_num_rows($res) > 0) {
    while($rows= mysqli_fetch_assoc($res)) {
        echo "RM".$rows["min(unitPrice)"] ."-" . $rows["max(unitPrice)"];
    }
} else {
    echo "<option value=''>No Results</option>";
}
?>

<script>
    document.getElementById("variation1").addEventListener("change", function() {
        var combobox = document.getElementById("variation1");
        var selectedIndex = combobox.selectedIndex;
        document.getElemetById("pricedis").value=
        // <?php
        //  echo $priceArr[ 
        //     ?>
        //     selectedIndex
            
        //     <?php 
        //     ]
        //     ?>
          
});
</script>


<div class="description-box">
    <h5>Description:</h5>
    <p><?php echo $data['description']; ?></p>
</div>


<label for="variation1"><?php echo $data['variationName1']; ?></label>
    <select name="variation1" id="variation1">
        <?php
        $sql = "SELECT * FROM productoption WHERE productID = '$_GET[productid]'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $priceArr;
                array_push($priceArr,$row["unitPrice"]);
                if($row["variation1"] == NULL){
                    $opt="";
                }elseif ($row["variation1"] != NULL && $row["variation2"]==NULL){
                    $opt=$row["variation1"];
                }elseif ($row["variation1"] != NULL && $row["variation2"]!=NULL){
                    $opt=$row["variation1"].", ".$row["variation2"];
                }
                echo "<option value='" . $row["productOptionID"]. "'>" . $opt . "</option>";
            }
        } else {
            echo "<option value=''>No Results</option>";
        }
        ?>
    </select>
    <!-- <label for="variation2"><?php echo $data['variationName2']; ?></label>
    <select name="variation2" id="variation2">
        <option value="-">-</option>
        <?php
        $sql = "SELECT variation2 FROM productoption WHERE productID = '$_GET[productid]'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row["variation2"]. "'>" . $row["variation2"] . "</option>";
            }
        } else {
            echo "<option value=''>No Results</option>";
        }
        ?>
    </select> -->
    <label for="quantity">Quantity:</label>
    <input type="number" name="quantity" id="quantity" min="1" value="1">
    <br>
    <!-- <label id="pricedis">RM-</label> -->
    <input type="submit" name="add" style="margin-top: 5px;" class="btn btn-success" value="addtocart">
    <button type="button" onclick="history.back();" >Back</button>

    </div>
    <br>
    <br>



