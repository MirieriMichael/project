<?php
require_once "data.php"; // Include the database connection file

// Add admit
if (isset($_POST['add'])) {
    // Retrieve the form data
    $patientName = $_POST['patientName'];
    $doctorName = $_POST['doctorName'];
    $wardRoom = $_POST['wardRoom'];
    $bedNo = $_POST['bedNo'];


    // Perform validation on the data
    $errors = array();

    // Validate first name and last name (not empty and alphanumeric)
    if (empty($patientName) || empty($doctorName)) {
        $errors[] = "First name and last name are required.";
    } elseif (!ctype_alnum($patientName) || !ctype_alnum($doctorName)) {
        $errors[] = "First name and last name should be alphanumeric.";
    }



    // Validate phone number (not empty and numeric)
    if (empty($bedNo) || !is_numeric($bedNo)) {
        $errors[] = "bed number is required and should be numeric.";
    }

    // If there are no validation errors, proceed with inserting the admit into the database
    if (empty($errors)) {
        // Prepare and execute the SQL statement to insert the admit into the 'admits' table
        $sql = "INSERT INTO admit (patientName, doctorName, wardRoom, bedNo)
                VALUES ('$patientName', '$doctorName', '$wardRoom', '$bedNo')";

        if ($conn->query($sql) === TRUE) {
            echo "";
        } else {
            echo "Error adding admit: " . $conn->error;
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
    <link rel="stylesheet" href="main.css">
    <title>BenMic</title>
</head>

<body>
    <h1>admit</h1>
    <div class="appoint-Bbox">
        <div class="appoint-Sbox">
            <div class="admit-img">

            </div>
        </div>
        <div class="appoint-Sbox">
            <div class="book-box">
                <h2>ADMIT PATIENT:</h2>
                <form action="" method="POST">
                    <label for="patientName">Patient Name:</label><br>
                    <input type="text" name="patientName" id="patientName" required><br>
                    <label for="doctorName">Doctor Name:</label><br>
                    <input type="text" name="doctorName" id="doctorName" required><br>
                    <label for="wardRoom">ward Room</label><br>
                    <input type="text" name="wardRoom" id="wardRoom" required><br>
                    <label for="bedNo">Bed Number:</label><br>
                    <input type="number" name="bedNo" id="bedNo" required><br>
                    <br>
                    <input type="submit" name="add" value="ADMIT">
                </form>
            </div>
        </div>
</body>

</html>