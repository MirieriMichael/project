<?php
require_once "data.php"; // Include the database connection file

// Add Doctor
if (isset($_POST['add'])) {
    // Retrieve the form data
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];


    // Perform validation on the data
    $errors = array();

    // Validate first name and last name (not empty and alphanumeric)
    if (empty($name) || empty($quantity)) {
        $errors[] = "name and quantity are required.";
    } elseif (!ctype_alnum($name) || !ctype_alnum($quantity)) {
        $errors[] = "name and quantity should be alphanumeric.";
    }

    // Validate$price (not empty and a valid$price format)
    if (empty($price)) {
        $errors[] = "price is required and should be numeric.";
    }



    // If there are no validation errors, proceed with inserting the doctor into the database
    if (empty($errors)) {
        // Prepare and execute the SQL statement to insert the doctor into the 'doctors' table
        $sql = "INSERT INTO drugs (name, quantity, price)
                VALUES ('$name', '$quantity', '$price')";

        if ($conn->query($sql) === TRUE) {
            echo "";
        } else {
            echo "Error adding doctor: " . $conn->error;
        }
    } else {
        // Display validation errors
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="main.css">
    <title>BenMic</title>
</head>

<body>
    <h1>ADD</h1>

    <div class="appoint-Bbox">
        <div class="appoint-Sbox">
            <div class="add-img">

            </div>
        </div>
        <div class="appoint-Sbox">
            <div class="book-box">
            <h2>ADD DRUGS:</h2>
            <form action="" method="POST">
                <label for="name">Name:</label><br>
                <input type="text" name="name" id="name" required><br>
                <label for="quantity">DOSAGE:</label><br>
                <input type="text" name="quantity" id="quantity" required><br>
                <label for="price">Price</label><br>
                <input type="text" name="price" id="price" required><br>

                <br>
                <input type="submit" name="add" value="ADD">
            </form>
        </div>
    </div>
</body>

</html>