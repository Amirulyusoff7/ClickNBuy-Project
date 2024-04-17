<?php
        // Include config file
        include('../connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
     <link rel="icon" href = "./assets/img/logo1.png">
     
     <!-- CSS & JS -->
     <link rel="stylesheet" href="./assets/css/style.css">
     <link rel="stylesheet" href="./assets/css/modal.css">
     <link rel="stylesheet" href="./assets/css/viewBtn.css"></link>
     <!-- <script src="./assets/js/modal.js"></script> -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
   <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
   <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script> -->
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">   -->

<!-- Datatables -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
<script src= "https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<link rel= "stylsheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" >




   <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });

</script> 
<script>
		$(document).ready( function () {
		    $('#table_id').DataTable();
		} );
</script>

    
</head>
<body>
     <?php
          
            include "../seller/bar/sidebarSeller.php";
            ?>

    <div class="wrapper">
        <div class="container-fluid">
             <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix"> 
                         <h2 class="pull-left">Seller Details</h2>

                    </div> 
<?php
                    // Attempt select query execution
                    $sql = "SELECT s.*, SUM(quantity) as productSold, SUM(orderlist.totalPrice) as totalSales
					FROM orderlist, `order`, seller s
					WHERE `order`.`orderID` = orderlist.orderID AND
					`orderlist`.`sellerID` = s.sellerID
					GROUP BY `orderlist`.sellerID ;";

                    if($result = mysqli_query($conn, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<div class= "table-responsive" >';
                            // echo '<div class = "box-user" >';
                            echo '<table id= "table_id" class="table table-striped table-bordered" >';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Seller Name</th>";
                                        echo "<th>Shop Name</th>";
										echo "<th>Product Sold</th>";
                                        echo "<th>Total Sales</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['shopName'] . "</td>";
                                        echo "<td>" . $row['productSold'] . "</td>";
										echo "<td>RM" . $row['totalSales'] . "</td>";
                                        echo "<td> <button id='my_Btn' onclick='showTableModal()'>View Table</button> </td>";

                                    echo "</tr>";
                                }
                                echo "</tbody>";
                            echo "</table>";
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
                    // mysqli_close($conn);
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
     <script type="text/javascript" src="./assets/js/ajaxWork.js"></script>
    <script type="text/javascript" src="./assets/js/script.js"></script> 
    <!--<script src="https://code.jquery.com/jquery-3.1.1.min.js" ></script>-->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script> 
    
   <?php
             include "../admin/bar/adminfooter.php";

    ?>   

<!-- Trigger/Open The Modal -->
<!-- <button id="myBtn">View Details</button> -->

<!-- The Modal -->
<div id="sales_modal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <?php
	// Attempt select query execution
	$sql = "SELECT product.name, sum(orderlist.quantity) as ProductSold, SUM(orderlist.totalPrice) as TotalSales
    FROM product, orderlist, `order`, productoption, seller
    WHERE product.productID = productoption.productID AND
    orderlist.productOptionID = productoption.productOptionID AND
    orderlist.`orderID` = `order`.orderID AND 
    seller.sellerID = `order`.`sellerID` AND
    `order`.`sellerID`= 
    GROUP BY product.name";

	if($result = mysqli_query($conn, $sql)){
		if(mysqli_num_rows($result) > 0){
	echo '<table id= "table_id" class="table table-striped table-bordered" >';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Product Name</th>";
                                        echo "<th>Product Sold</th>";
                                        echo "<th>Total Sales</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['ProductSold'] . "</td>";
                                        echo "<td>" . $row['TotalSales'] . "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                            echo "</table>";
							}
						}
							?>
    
  </div>
</div>

<script>
    // Get the modal
var modal = document.getElementById("sales_modal");

// Get the button that opens the modal
var btn = document.getElementById("my_Btn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>

</body>
</html
