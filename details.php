<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="drugdash.css">
    <title>Drug Details</title>
</head>
<body>
    <h1>Drug Details</h1>

    <!-- Navigation Menu -->
    <ul class="menu">
        <li><a href="drugdash.php">Home</a></li>
        <li><a href="drugs.php">Add Drug</a></li>
    </ul>

    <!-- Display Drug Details -->
    <?php
    require_once "data.php"; // Include the database connection file

    // Retrieve drug details from the database based on the name in the URL parameter
    if (isset($_GET['name'])) {
        $name = htmlspecialchars($_GET['name']);
        $sql = "SELECT * FROM drugs WHERE name = '$name'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<h2>{$row['name']}</h2>";
            echo "<p>Quantity: {$row['quantity']}</p>";
            echo "<p>Price: {$row['price']}</p>";
            echo "<p>Category: {$row['category']}</p>";
            echo "<img src='images/".$row['images']."'>";
        } else {
            echo "Drug not found.";
        }
    } else {
        echo "Invalid request.";
    }
    ?>
</body>
</html>