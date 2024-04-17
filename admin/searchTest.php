<!DOCTYPE html>
<html>
<head>
    <title>Search Page</title>
</head>
<body>
    <form method="get" action="searchTest.php">
        <label>Search: <input type="text" name="search"></label>
        <input type="submit" value="Submit">
    </form>
    <?php
        if(isset($_GET['search'])) {
            // Include config file
            include_once "./config/config.php";

            // Prepare the statement
            $stmt = mysqli_prepare($conn, "SELECT * FROM admin WHERE name LIKE ? OR icNo LIKE ? OR phoneNo LIKE ? OR email LIKE ?");

            // Bind the search term to the statement
            $search = "%".$_GET['search']."%";
            mysqli_stmt_bind_param($stmt, "ssss", $search, $search, $search, $search);

            // Execute the statement
            mysqli_stmt_execute($stmt);

            // Get the results
            $result = mysqli_stmt_get_result($stmt);

            // Start the table
            echo "<table>";
            echo "<tr><th>Name</th><th>IC Number</th><th>Phone Number</th><th>Email </th></tr>";

            // Loop through the results
            while ($row = mysqli_fetch_assoc($result)) {
                // Display the data in a row
                echo "<tr>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['icNo'] . "</td>";
                echo "<td>" . $row['phoneNo'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "</tr>";
            }

            // Close the table
            echo "</table>";

            // Close the statement
            mysqli_stmt_close($stmt);

            // Close the database connection
            mysqli_close($conn);
        }
    ?>
</body>
</html>