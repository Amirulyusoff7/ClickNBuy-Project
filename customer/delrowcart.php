<?php

include ('../connect.php');   
session_start();
        $id=$_GET['id'];
        $query = "DELETE FROM cart WHERE cartID = '$id'";
      
        $data = mysqli_query($conn,$query);
        if ($data)
        {
            echo '<script>alert("Product has been Removed...!")</script>';
           
            header('Refresh:0;url=../customer/tocart.php');
        }
        else
        {
            echo "Deleting Failed";
        }
               
        

?>