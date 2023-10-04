<?php
require_once "data.php"; // Include the database connection file

// Add feedback
if (isset($_POST['add'])) {
    // Retrieve the form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $phoneNo = $_POST['phoneNo'];
    $email = $_POST['email'];
    $additional = $_POST['additional'];

    // Perform validation on the data
    $errors = array();

    // Validate first name and last name (not empty and alphanumeric)
    if (empty($firstName) || empty($lastName)) {
        $errors[] = "First name and last name are required.";
    } elseif (!ctype_alnum($firstName) || !ctype_alnum($lastName)) {
        $errors[] = "First name and last name should be alphanumeric.";
    }

    // Validate email (not empty and a valid email format)
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Validate phone number (not empty and numeric)
    if (empty($phoneNo) || !is_numeric($phoneNo)) {
        $errors[] = "Phone number is required and should be numeric.";
    }

    // If there are no validation errors, proceed with inserting the feedback into the database
    if (empty($errors)) {
        // Prepare and execute the SQL statement to insert the feedback into the 'feedbacks' table
        $sql = "INSERT INTO feedback (firstName, lastName, phoneNo, email, additional)
                VALUES ('$firstName', '$lastName', '$phoneNo', '$email', '$additional')";

        if ($conn->query($sql) === TRUE) {
            echo "";
        } else {
            echo "Error adding feedback: " . $conn->error;
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
    <h1>feedback</h1>

    <div class="appoint-Bbox">
        <div class="appoint-Sbox">
            <div class="feedback-img">

            </div>
        </div>
        <div class="appoint-Sbox">
            <div class="book-box">
                <h2>SEND FEEDBACK:</h2>
                <form action="" method="POST">
                    <label for="firstName">First Name:</label><br>
                    <input type="text" name="firstName" id="firstName" required><br>
                    <label for="lastName">Last Name:</label><br>
                    <input type="text" name="lastName" id="lastName" required><br>
                    <label for="phoneNo">phoneNo</label><br>
                    <input type="number" name="phoneNo" id="phoneNo" required><br>
                    <label for="email">Email:</label><br>
                    <input type="email" name="email" id="email" required><br>
                    <label for="additional">additional:</label><br>
                    <input type="text" name="additional" id="additional" required><br>

                    <br>
                    <input type="submit" name="add" value="feedback">
                </form>
            </div>
        </div>
</body>

</html>