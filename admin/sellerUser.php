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
     
     <!-- CSS  -->
     <link rel="stylesheet" href="./assets/css/style.css">
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
            include "./bar/adminHeader.php";
            include "./bar/sidebar.php";
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
                    $sql = "SELECT * from seller ;";
                    if($result = mysqli_query($conn, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<div class= "table-responsive" >';
                            // echo '<div class = "box-user" >';
                            echo '<table id= "table_id" class="table table-striped table-bordered" >';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Seller Name</th>";
                                        echo "<th>Shop Name</th>";
                                        echo "<th>Email</th>";
                                        echo "<th>Phone Number</th>";
                                        echo "<th>Username</th>";
                                        echo "<th>Password</th>";
                                        echo "<th>Pick Up Address</th>";
                                        // echo "<th>Secret Pin</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['shopName'] . "</td>";
                                        echo "<td>" . $row['email'] . "</td>";
                                        echo "<td>" . $row['phoneNo'] . "</td>";
                                        echo "<td>" . $row['username'] . "</td>";
                                        echo "<td>" . $row['password'] . "</td>";
                                        echo "<td>" . $row['pickUpAddress'] . "</td>";
                                        // echo "<td>" . $row['pin'] . "</td>";
                                        echo "<td>";
                                            echo '<a href="updateSeller.php?sellerID='. $row['sellerID'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '&nbsp';
                                            echo '<a href="deleteSeller.php?sellerID='. $row['sellerID'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";
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
     <script type="text/javascript" src="./assets/js/ajaxWork.js"></script>
    <script type="text/javascript" src="./assets/js/script.js"></script> 
    <!--<script src="https://code.jquery.com/jquery-3.1.1.min.js" ></script>-->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script> 
    
   <?php
             include "./bar/adminfooter.php";

    ?>   

</body>
</html>