<?php
require_once "data.php"; // Include the database connection file

// Add Doctor
if (isset($_POST['add'])) {
    // Retrieve the form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $userName = $_POST['userName'];
    $email = $_POST['email'];
    $PhoneNo = $_POST['PhoneNo'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];

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
    if (empty($PhoneNo) || !is_numeric($PhoneNo)) {
        $errors[] = "Phone number is required and should be numeric.";
    }

    // If there are no validation errors, proceed with inserting the doctor into the database
    if (empty($errors)) {
        // Prepare and execute the SQL statement to insert the doctor into the 'doctors' table
        $sql = "INSERT INTO doctor (firstName, lastName, userName, email, PhoneNo, password, gender)
                VALUES ('$firstName', '$lastName', '$userName', '$email', '$PhoneNo', '$password', '$gender')";

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
    <link rel="stylesheet" type="text/css" href="creates.css">
    <title>BenMic</title>
</head>

<body>
    <h1>DOCTOR</h1>

    <div class="container">
        <div class="form-section">
            <h2>Create Account:</h2>
            <form action="" method="POST">
                <label for="firstName">First Name:</label><br>
                <input type="text" name="firstName" id="firstName" required><br>
                <label for="lastName">Last Name:</label><br>
                <input type="text" name="lastName" id="lastName" required><br>
                <label for="userName">UserName</label><br>
                <input type="text" name="userName" id="userName" required><br>
                <label for="email">Email:</label><br>
                <input type="email" name="email" id="email" required><br>
                <label for="PhoneNo">Phone Number:</label><br>
                <input type="number" name="PhoneNo" id="PhoneNo" required><br>
                <label for="password">Password:</label><br>
                <input type="password" name="password" id="password" required><br>
                <div class="radio">
                    <label for="gender">Gender</label>
                    <label for="gender-male">Male</label>
                    <input type="radio" id="gender-male" name="gender" value="male" required>

                    <label for="gender-female">Female</label>
                    <input type="radio" id="gender-female" name="gender" value="female">

                </div>
                <br>
                <input type="submit" name="add" value="CREATE">
            </form>
        </div>
    </div>
</body>

</html>