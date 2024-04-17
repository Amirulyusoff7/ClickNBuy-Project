
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
  <head>
    
  <ul>
  
        <li><a> CLICKNBUY</a></li>
        <li><form action="search.php" method="GET">
		    <input type="text" name="query" />
		    <input type="submit" value="Search" />
	      </form>
        </li>
        <li class = "rightactive">
            <a href="#"><?php echo $username;?>▾</a>
            <ul class="dropdown">
                <li><a href="../seller/sellerregister.php">Register seller</a></li>
              <li><a href="custedit.php?i=<?php echo $rows['customerID'];?>">Profile</a>
                <li><a href="logoutcust.php">Logout</a></li>
                <li><a href="address.php">Address</a></li>
            </ul>
        </li>
        <li class="rightactive"><a href="tocart.php"><i class="fas fa-shopping-cart"></i> <span id="cart-item" class="badge badge-danger"></span></a>
        </li>
        
    </ul>
  
</head>

<body>
  

  <!-- Displaying Products Start -->
  <div class="container">
    <div id="message"></div>
    <div class="row mt-2 pb-3">
      <?php
  			include('../connect.php'); 
  			$stmt = $conn->prepare('SELECT * FROM product');
  			$stmt->execute();
  			$result = $stmt->get_result();
  			while ($row = $result->fetch_assoc()):
  		?>
      <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
        <div class="card-deck">
          <div class="card p-2 border-secondary mb-2">
            <img src="<?= $row['image'] ?>" class="card-img-top" height="250">
            <div class="card-body p-1">
              <h4 class="card-title text-center text-info"><?= $row['name'] ?></h4>
              <!-- <h5 class="card-text text-center text-danger"><?= number_format($row['price'],2) ?></h5> -->

            </div>
            <div class="card-footer p-1">
              <form action="" class="form-submit">
                <div class="row p-2">
                 
                </div>
                <input type="hidden" class="pid" value="<?= $row['productID'] ?>">
                <input type="hidden" class="pname" value="<?= $row['name'] ?>">
                <!-- <input type="hidden" class="pprice" value="<?= $row['price'] ?>"> -->
                <input type="hidden" class="pimage" value="<?= $row['image'] ?>">
               
                <p class="card-text">
                <a href="single_product.php?productid=<?php echo $row['productID']?>" name ="select" class="btn btn-primary btn-sm">View</a>
                </p>
                <!-- <button class="btn btn-info btn-block addItemBtn"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Add to
                  cart</button> -->
              </form>
            </div>
          </div>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
  </div>
  <!-- Displaying Products End -->

</body>

</html>



