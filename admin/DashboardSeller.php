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
            include "./bar/adminHeader.php";
            include "./bar/sidebarSeller.php";
            include_once "./config/config.php";
        ?>

    <div id="main-content" class="container allContent-section py-4">
        <div class="row">
            <div class="col-sm-3">
                <div class="card">
                    <i class="fa fa-users  mb-2" style="font-size: 70px;"></i>
                    <h4 style="color:white;">Total Admin</h4>
                    <h5 style="color:white; text-align: center;" >
                    <?php

                        $sql="SELECT * FROM admin;";
                        //$result=$conn-> query($sql);
                        $result = mysqli_query($conn, $sql);
                        $count=0;
                        if (mysqli_num_rows($result) > 0){
                            while ($row = mysqli_fetch_array($result)) {
                    
                                $count=$count+1;
                            }
                        }
                        echo $count;
                    ?>
                    <hr></hr>
                        <button class="vAdmin">View Admin</button>
                
                
                </h5>
                </div>
            </div>
            <div class="col-sm-3">
            <div class="card">
                    <i class="fa fa-th mb-2" style="font-size: 70px;"></i>
                    <h4 style="color:white;">Total Customers</h4>
                    <h5 style="color:white; text-align: center;">
                    <?php
                       
                       $sql="SELECT * from customer";
                       $result = mysqli_query($conn, $sql);
                       $count=0;
                       if (mysqli_num_rows($result) > 0){
                           while ($row = mysqli_fetch_array($result)) {
                   
                               $count=$count+1;
                           }
                       }
                       echo $count;
                   ?>
                    <hr></hr>
                    <button class="vCust">View Customer</button>
                   </h5>
                </div>
            </div>
            <div class="col-sm-3">
            <div class="card">
                    <i class="fa fa-th mb-2" style="font-size: 70px;"></i>
                    <h4 style="color:white;">Total Seller</h4>
                    <h5 style="color:white; text-align: center;">
                    <?php
                       
                       $sql="SELECT * from seller";
                       $result = mysqli_query($conn, $sql);
                       $count=0;
                       if (mysqli_num_rows($result) > 0){
                           while ($row = mysqli_fetch_array($result)) {
                   
                               $count=$count+1;
                           }
                       }
                       echo $count;
                   ?>
                    <hr></hr>
                    <button class="vSeller">View Seller</button>
                   </h5>
                </div>
            </div>
        </div>
        
    </div>


    <!-- JS Code -->
    <script>
    document.querySelector('.vAdmin').addEventListener('click', function() {
    window.location.href = './adminUser.php';
    });

    document.querySelector('.vCust').addEventListener('click', function() {
    window.location.href = './custUser.php';
    });

    document.querySelector('.vSeller').addEventListener('click', function() {
    window.location.href = './sellerUser.php';
    });
    </script>
      
       
    <script type="text/javascript" src="./assets/js/ajaxWork.js"></script>    
    <script type="text/javascript" src="./assets/js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
        <?php
            include "./bar/adminfooter.php";
        ?>
 
</html>