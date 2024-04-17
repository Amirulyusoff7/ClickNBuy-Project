<?php include("dbConnection.php"); 
// /include("header.php");
session_start();
$qry = "SELECT * FROM `seller` WHERE username='" . $_SESSION['username'] . "'";
$result = mysqli_query($conn,$qry);
$rows=mysqli_fetch_array($result);
$sellerID = $rows['sellerID'];


     
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if($conn->connect_error) {
        die ("Connection failed: " . $conn->connect_error);
    }

    
    $prodID = $_POST["hiddenProdID"];
    $deleteQuery = "DELETE FROM product WHERE productID='".$prodID."';";
    $result = mysqli_query($conn, $deleteQuery);

    if($result){
        echo '<script type="text/javascript">alert("Product deleted successfully !");window.location.href = "myProduct.php";</script>';
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($result);
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<meta charset="utf-8">
    <head>
        <title>ClickNBuy Seller Centre</title>

        <script type="text/javascript">
        window.onload = function() {
            var result = confirm('Changes cannot be undo. All data about this product will be deleted. Are you sure you want to delete this product?');
                if(result == true){
                    document.getElementById("productForm").submit();
                } else {
                    fetch("../seller/deleteProduct.php")
                    .then(response => {
                        if (response.ok) {
                            window.location.href = "../seller/myProduct.php"
                        }
                    })
                    .catch(error => console.log(error));
                }
            }
        </script>
        
        <script src="multiselect-dropdown.js"></script>
        <link rel="stylesheet" href="style.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <!-- JS & CSS library of MultiSelect plugin -->
        <script src="multiselect/jquery.multiselect.js"></script>
        <link rel="stylesheet" href="multiselect/jquery.multiselect.css">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

        <style>
            #tooltip {
                display: none;
                position: absolute;
                background-color: #DBF3FA ;
                padding: 13px;
                font-size: 12px;
            }
        </style>
    </head>
    <body>
        
    <?php 
        $productID = $_GET['productID'];
        // echo "ProductID ".$productID;
        $sql3="SELECT * FROM productoption, product 
        WHERE productoption.productID = product.productID AND
        productoption.productID = '".$productID."'";
        $allProdResults = mysqli_query($conn, $sql3);
        $allProdRows = mysqli_fetch_array($allProdResults);
        
    ?>
        
        <div class="container">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="productForm">
            <p id="demo">Edit Product</p>
            <img src="images/<?= $allProdRows['image']; ?>" alt="Product Image" width="400px" height="400px">
            
            Update new product image
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box">
            <input type="hidden" name="old_image" value="<?= $allProdRows['image']; ?>">

            <input type = "hidden" name="hiddenProdID" value="<?php echo $allProdRows['productID']?>">

            <div class="basic-information">
                
                    Product Name
                    <input type="text" name="productName" value ="<?php echo $allProdRows['name']; ?>" placeholder="Enter name of the product">
                

                <div class="row">
                Category
                    
                    
                    <?php
                    $sql2 = "SELECT * FROM prod_category, category WHERE 
                    prod_category.categoryID = category.categoryID AND
                    productID ='".$productID."';";
                    if($categoryProd = mysqli_query($conn, $sql2)){
                        if(mysqli_num_rows($categoryProd) > 0){
                            while($row = mysqli_fetch_array($categoryProd)) 
                            {
                                // Category name
                                echo $row['name']."<br>";
                            }
                            mysqli_free_result($categoryProd);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                    ?>
                   
                   Edit Category
            
                    <select name="field1[]" multiple multiselect-max-items="3">
                    <?php
                        $sql = "SELECT * FROM `category`";
                        $all_categories = mysqli_query($conn,$sql);
                        while($category = mysqli_fetch_array($all_categories, MYSQLI_ASSOC)):;
                    ?>
                        <option value ="<?php echo $category["categoryID"];?>">
                        <?php echo $category["name"];?>
                        </option>
                    <?php endwhile; ?>
                    </select></td>
              
                </div>

               
                    Description
                    <div id="tooltip"></div>
                    <td><textarea name="description" rows ="8" cols="50" required
                    onmouseover="showTooltip('Help buyers to decide if the product meets their needs by creating an informative description with: <br> - Product specification <br> - Uses and benefits <br> - Warranties/expiry date and etc.')"
                    onmouseout="hideTooltip()" > <?php echo $allProdRows['description']; ?></textarea>
                    <input type="hidden" id="tbenableVariation1" name="tbenableVariation1" value=false>
                    <input type="hidden" id="tbenableVariation2" name="tbenableVariation2" value=false>
              
           
           

            <?php
            $oneCol=false;
            $twoCol=false;
            $loop=0;
            $sql="SELECT * FROM productoption, product 
            WHERE productoption.productID = product.productID AND
            productoption.productID = '".$productID."'";
                    if($allProdResults = mysqli_query($conn, $sql)){
                        if(mysqli_num_rows($allProdResults) > 0){
                            $loop = mysqli_num_rows($allProdResults);
                            $headerCount = 0;
                            while($row = mysqli_fetch_array($allProdResults)) 
                            {
                                if($row['variationName1']!= NULL || $row['variationName1']!= ""){
                                    $oneCol = true;
                                    echo"<input type='hidden' id='oneCol' name='oneCol' value=".$oneCol.">";
                                    echo"<input type='hidden' id='twoCol' name='twoCol' value=".$twoCol.">";
                                    if($row['variationName2']!= NULL || $row['variationName2']!= ""){
                                        $twoCol = true;
                                        echo"<input type='hidden' id='twoCol' name='twoCol' value=".$twoCol.">";
                                    }

                                } else { 
                                    ?>
                                    Price (RM) <input type="text" placeholder="Enter Price" id="price" name="price" value ='<?php echo $row['unitPrice'] ?>' required>
                                    Stock <input type="text" placeholder="Enter Amount" id="stock" name="stock" value ='<?php echo $row['stockQuantity'] ?>' required>
                                    <?php 
                                }
                            }
                            mysqli_free_result($allProdResults);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }

                    if($oneCol){
                        if($twoCol){
                            echo "<table id='variationTable' border='1'>";
                            
                            echo "<th>".$allProdRows['variationName1']."</th>";
                            echo "<th>".$allProdRows['variationName2']."</th>";
                            echo"<input type='hidden' id='vName1' name='vName1' value=".$allProdRows['variationName1'].">";
                            echo"<input type='hidden' id='vName2' name='vName2' value=".$allProdRows['variationName2'].">";
                            echo "<th>Price (RM)</th>";
                            echo "<th>Stock Quantity</th>";
                        } else {
                            echo "<table id='variationTable' border='1'>";
                            echo "<th>".$allProdRows['variationName1']."</th>";
                            echo"<input type='hidden' id='vName1' name='vName1' value=".$allProdRows['variationName1'].">";
                            echo "<th>Price (RM)</th>";
                            echo "<th>Stock Quantity</th>";
                        }
                    }

                    if($allProdResults = mysqli_query($conn, $sql)){
                        if(mysqli_num_rows($allProdResults) > 0){
                            $loop = mysqli_num_rows($allProdResults);
                            while($row = mysqli_fetch_array($allProdResults)) 
                            {
                                if($oneCol){
                                    if($twoCol){
                                        echo "<tr>";
                                        echo "<td>".$row['variation1']."</td>";
                                        echo "<td>".$row['variation2']."</td>";
                                        echo "<td><input type='text' placeholder='Enter price' name='priceOption[]' value=".$row['unitPrice']." required></td>";
                                        echo "<td><input type='text' placeholder='Enter amount' name ='stockOption[]' value=".$row['stockQuantity']." required></td>";
                                        echo"<input type='hidden' id='prodOptID' name='prodOptID[]' value=".$row['productOptionID'].">";
                                        echo "</tr>";
                                    } else {
                                        echo "<tr>";
                                        echo "<td>".$row['variation1']."</td>";
                                        echo "<td><input type='text' placeholder='Enter price' name='priceOption[]' value=".$row['unitPrice']." required></td>";
                                        echo "<td><input type='text' placeholder='Enter amount' name ='stockOption[]' value=".$row['stockQuantity']." required></td>";
                                        echo"<input type='hidden' id='prodOptID' name='prodOptID[]' value=".$row['productOptionID'].">";
                                        echo "</tr>";
                                    }
                                }
                            }
                            echo "</table>";
                            mysqli_free_result($allProdResults);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }

    
                
            ?>
            <!-- <input type="submit" name="submit" value="Update Product" onclick="return confirm('Are you sure you want to update this product?');"> -->
            </form>
        </div>
        
      

        <script>
            $(document).ready(function() {       
                $('#current_select').multiselect({		
                    nonSelectedText: 'Select Current'				
                });
            });

            $(function(){
                $('#current_select').multiselect({ 
                    buttonText: function(options, select) {
                        var labels = [];
                        console.log(options);
                        options.each(function() {
                            labels.push($(this).val());
                        });

                        $("#current_select_values").val(labels.join(',') + '');
                            return labels.join(', ') + '';
                    }
                
                });
            });
        </script>
    </body>
</html>