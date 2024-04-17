<?php
include('../connect.php');
include("../seller/bar/headerSeller.php");
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
    <title>Dashboard</title>
    <link rel="icon" href = "./assets/img/logo1.png">

    <link rel="stylesheet" href="./assets/css/style.css">
  
    <!-- Datatables Library-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
    <script src= "https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel= "stylsheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" >

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
   <script>
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
                         <h2 class="pull-left">My Product(s)</h2>

                    </div> 
<?php
                    // Attempt select query execution
                    $sql = "SELECT * from product WHERE sellerID='".$sellerID."';";
                    if($result = mysqli_query($conn, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<div class= "table-responsive-sm">';
                            echo '<div class= "table table-bordered">';
                            echo '<table border="1" id= "table_id" class="table table-striped table-bordered" >';
                                echo "<thead>";
                                    echo "<tr>";
                                          echo "<th>No</th>";
                                          echo "<th>Image</th>";
                                        echo "<th>Product(s)</th>";
                                        echo "<th>Description</th>";
                                        echo "<th style='text-align: center'>Action(s)</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                $sn=1;
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $sn . "</td>";
                                        echo "<td><img src=images/". $row['image']." alt='' width='50px' height='50px'></td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['description'] . "</td>";
                                        $sn++;
                                        echo "<td style='text-align: center'>";
                                            echo '<a href="../seller/editProduct.php?productID='. $row['productID'] .'" class="mr-3" title="Update" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
                                            echo '<a href="../seller/deleteProduct.php?productID='. $row['productID'] .'" title="Delete" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
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
</div>
    
     <script type="text/javascript" src="./assets/js/ajaxWork.js"></script>
    <script type="text/javascript" src="./assets/js/script.js"></script> 
    <!--<script src="https://code.jquery.com/jquery-3.1.1.min.js" ></script>-->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script> 
    

</body>
</html>