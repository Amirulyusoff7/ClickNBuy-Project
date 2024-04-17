<?php 
include('../connect.php');

    

?>
  <link rel="stylesheet" href="./assets/css/header.css"> 
 <!-- nav -->
 <nav  class="navbar navbar-expand-lg navbar-light px-5" style="background-color: #798bf1;  ">
    
    <a class="navbar-brand ml-5" href="./adminindex.php">
        <img src="./assets/img/logo1.png" width="80" height="80" alt="logo">
        <button type="button" class= "btnbck"; onclick="history.back();" style="float: right; margin-top: 20px; margin-right: 20px;">Back</button>
    </a>
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0"></ul>
    

    <div>
          <form action="logoutadm.php" method="post">
          <input type="submit" class="btn btn-danger" value="Logout">
          </form>
    </div>
    <!-- <div class="user-cart">  
        <?php           
        if(isset($_SESSION['adminID'])){
          ?>
          <a href="" style="text-decoration:none;">
            <i class="fa fa-user mr-5" style="font-size:30px; color:#fff;" aria-hidden="true"></i>
         </a>
          <?php
        } else {
            ?>
            <a href="" style="text-decoration:none;">
                    <i class="fa fa-sign-in mr-5" style="font-size:30px; color:#fff;" aria-hidden="true"></i>
            </a>

            <?php
        } ?>
    </div>   -->
</nav>

   
