<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <style>
            #menu {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #333;
            color: #fff;
            padding: 20px;
            }

            #menu a {
            color: #fff;
            text-decoration: none;
            margin-right: 10px;
            }

            div.container {
            margin-top: 60px; /* Make room for the floating menu */
            }
        </style>
        <script>
            // When the user scrolls the page, execute myFunction
            window.onscroll = function() {myFunction()};

            // Get the menu
            var menu = document.getElementById("menu");

            // Get the offset position of the menu
            var sticky = menu.offsetTop;

            // Add the sticky class to the menu when you reach its scroll position. Remove "sticky" when you leave the scroll position
            function myFunction() {
                if (window.pageYOffset > sticky) {
                    menu.classList.add("sticky");
                } else {
                    menu.classList.remove("sticky");
                }
            }
            //This will create a menu that stays at the top of the page as the user scrolls. You can customize the look and behavior of the menu by modifying the HTML, CSS, and JavaScript.
        </script>
    </head>
    <body>
        <div id="menu">
            <a href="addCourier.php">Add Courier</a>
            <a href="viewCourier.php">View Courier(s)</a>
            <a href="manageOrder.php">My Orders</a>
            <a href="myProduct.php">My Products</a>
            <a href="addProduct.php">Add New Product</a>
            <!-- <a href="try.php">Try</a> -->
            
        </div>
    </body>
</html>
