<!DOCTYPE html>
<html>
<head>
  <title>Admin</title>
  <link rel="icon" href = "./assets/img/logo1.png"> 
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
       <link rel="stylesheet" href="./assets/css/style.css"></link>
       <link rel="stylesheet" href="./assets/css/btnUser.css"></link>

  </head>
</head>
<body >

<?php
include("../connect.php");
include("../seller/bar/headerSeller.php");
include("../seller/bar/sidebarSeller.php");
session_start();

$qry = "SELECT * FROM `seller` WHERE username='" . $_SESSION['username'] . "'";
$result = mysqli_query($conn,$qry);
$rows=mysqli_fetch_array($result);
$username=$_SESSION['username'] ;
 $sellerID = $rows['sellerID'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="icon" href = "./assets/img/logo1.png">
     
     <!-- CSS  -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="./assets/css/style.css">

    <!-- colored link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
        rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
        crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous">
      </script>

    <!-- Datatables Library-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
    <script src= "https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel= "stylsheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" >

   <script>
        var orderID1;
            function changeWindow(orderID1) {
                window.location.href = "deliveryForm.php?orderID1=" + orderID1;
            }

        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });

        //Datatables ActivatePlugin 
		$(document).ready( function () {
		    $('#table_id').DataTable();
		} );
</script>

    
</head>
<body>
    <div class="container">
    <div class="wrapper">
        <div class="container-fluid">
             <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix"> 
                    </div>
                         <h2 class="pull-left">My Order(s)</h2>
                    </div>
                    <div class="orderHeader">
                        <a href="../seller/completedOrder.php" class="link-primary">All</a>&nbsp&nbsp
                        <a href="../seller/unpaidOrder.php" class="link-primary">Unpaid</a>&nbsp&nbsp
                        <a href="../seller/toShipOrder.php" class="link-primary">To ship</a>&nbsp&nbsp
                        <a href="../seller/shippingOrder.php" class="link-primary">Shipping</a>&nbsp&nbsp
                        <a href="../seller/completedOrder.php" class="link-primary">Completed</a><br>
                    <?php
                    // Attempt select query execution
                    $query ="SELECT * FROM `order`,`payment` WHERE `payment`.paymentID = `order`.paymentID AND paymentStatus = 'Unpaid' AND sellerID = '".$sellerID."'ORDER BY orderID DESC";
                    $result = mysqli_query($conn,$query);
                    $sn = 1;
                    if($result){
                        if(mysqli_num_rows($result) > 0){
                            
                            echo '<div class= "table-responsive">';
                            echo '<div class= "table table-bordered">';
                            echo '<table border="1" id= "table_id" class="table table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>No</th>";
                                        echo "<th>Order Date</th>";
                                        echo "<th>Product(s)</th>";
                                        echo "<th>Quantity</th>";
                                        echo "<th>Shipping Status</th>";
                                        // echo "<th>Payment Status</th>";
                                        echo "<th>Shipping Details</th>";
                                        echo "<th>Action(s)</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_assoc($result)) {
                                    $listQuery = "SELECT * FROM `orderlist`, `product`, `productOption`, `payment`, `order`
                                                WHERE `orderlist`.productOptionID = `productOption`.productOptionID AND
                                                `productOption`.productID = `product`.productID AND
                                                `order`.paymentID = `payment`.paymentID AND
                                                `order`.orderID = `orderlist`.orderID AND
                                                `order`.orderID =" .$row['orderID'].";";
                                    $resultList = mysqli_query($conn,$listQuery);
                                    if($resultList) {
                                        $count = mysqli_num_rows($resultList);
                                        if($count > 0) {
                                        $i = 0;
                                        $j = 0;
                                        echo "<tr>";
                                        
                                        while($product = mysqli_fetch_assoc($resultList)) {
                                            if($j<1) {
                                                echo "<td rowspan='$count'>".$sn."</td>";
                                                echo "<td rowspan='$count'>".$row['orderDate']."</td>";
                                                $j++;
                                                }
                                            echo "<td>" . $product['name']."</td>";
                                            echo "<td>" . $product['quantity']."</td>";
                                            // echo "<td rowspan='$count'>".$row['orderID']."</td>";
                                            if($i<1) {
                                                echo "<td rowspan='$count'>".$row['orderStatus']."</td>";

                                                $sn++;
            
                                                $addressQuery = "SELECT * FROM `address`
                                                WHERE addressID = ".$row['addressID'].";";
                                                $resultAddress = mysqli_query($conn,$addressQuery);
                                                if($resultAddress){
                                                    while($add = mysqli_fetch_assoc($resultAddress)){
                                                        echo "<td rowspan='$count'>".$add['name']."<br>".$add['phoneNo']."<br>".$add['houseNo'].",".$add['streetName']."<br>".$add['city'].",".$add['postcode']."</td>";
                                                    }
                                                }
                                                echo "<input type='hidden' name='orderId' value='".$row['orderID']."'>";
                                                if($row['orderStatus']=="To ship"){
                                                    if($product['paymentStatus']=="Paid") {
                                                        // echo "<td rowspan='$count'><input type='button' name='btn-ship' value='Ship parcel' onclick='window.open(\"deliveryForm.php?orderID1=".$row['orderID']." \", \"Ship Parcel\", \"height=600,width=800\")'></td>";
                                                        echo "<td rowspan='$count'><input type='button' name='btn-ship' value='Ship parcel' onclick='changeWindow(".$row['orderID'].")'></td>";
                                                    }
                                                    if($product['paymentStatus']=="Unpaid"){
                                                        echo "<td rowspan='$count'>Unpaid</td>";
                                                    }
                                                } else {
                                                    if($product['orderStatus']=="Shipping"){
                                                        echo "<td rowspan='$count'>Shipped</td>";
                                                    }
                                                    if($product['paymentStatus']=="Unpaid"){
                                                        echo "<td rowspan='$count'>Unpaid</td>";
                                                    }
                                                }
                                                $i++; 
                                                echo "</tr>";
                                            }
                                        }
                                    }
                                    }
                                }
                                echo "</tbody>";
                            echo "</table>";
                            echo "</div>";
                            echo "</div>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }

                    // Close connection
                    mysqli_close($conn);
                    ?>

                    <style>
                    .table table-bordered table-striped td {
                        width: fit-content;
                    }
                    </style>
                </div>
            </div> 
        </div>
    </div>
    </div>
    
     <script type="text/javascript" src="./assets/js/ajaxWork.js"></script>
    <script type="text/javascript" src="./assets/js/script.js"></script> 
    <!--<script src="https://code.jquery.com/jquery-3.1.1.min.js" ></script>-->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script> 

    <script type="text/javascript" src="./assets/js/ajaxWork.js"></script>    
    <script type="text/javascript" src="./assets/js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    
  
</body>
</html>