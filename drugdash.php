<?php
require_once "data.php"; // Include the file that defines $drugs
require_once "uploads.php"; // Include the file that defines $uploadDirectory

$pageTitle = "Drug Dashboard";
$section = "dashboard"; // You can set the section according to your site structure
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="main.css">
    <title><?php echo $pageTitle; ?></title>
</head>
<body>
    <h1><?php echo $pageTitle; ?></h1>

    <!-- Navigation Menu -->
    <ul class="menu">
        <li><a href="drugdash.php">Home</a></li>
        <li><a href="drugs.php">Add Drug</a></li>
    </ul>

    <?php
    // Check if $drugs is defined and not empty
    if (isset($drugs) && is_array($drugs) && !empty($drugs)) {
        // Retrieve and display drug categories
        $categories = array_unique(array_column($drugs, 'category'));
        foreach ($categories as $category) {
            echo "<h2>$category</h2>";
            
            // Display drugs of the current category
            echo "<div class='drug-section'>";
            foreach ($drugs as $id => $drug) {
                if ($drug['category'] == $category) {
                    echo "<div class='drug-item'>";
                    echo "<h3>{$drug['name']}</h3>";
                    // Use the specified image path
                    echo "<img src='{$drug['image_path']}' alt='{$drug['name']}'><br>";
                    echo "<a href='drugdetails.php?name={$drug['name']}' class='view-details-link'>View Details</a>";
                    echo "</div>";
                }
            }
            echo "</div>";
        }
    } else {
        echo "No drugs available.";
    }
    ?>


    <!-- Display the image using the specified path -->
    <img src="C:\xampp\htdocs\hosi\upload.php651b13a8d9f99_tablets.jpg" alt="Image Description" class="image">

    <!-- Footer -->
    <footer>
        <!-- Your footer content here -->
    </footer>
</body>
</html>
