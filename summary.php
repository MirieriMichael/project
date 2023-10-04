<?php
require_once "data.php"; // Include the database connection file

// Add summary
if (isset($_POST['add'])) {
    // Retrieve the form data
    $patientName = $_POST['patientName'];
    $patientAge = $_POST['patientAge'];
    $patientWeight = $_POST['patientWeight'];
    $patientSymptoms = $_POST['patientSymptoms'];
    $prescribedMedicine = $_POST['prescribedMedicine'];
    $prescribedPrescription = $_POST['prescribedPrescription'];

    // Perform validation on the data
    $errors = array();

    // Validate first name and last name (not empty and alphanumeric)
    if (empty($patientName) || empty($patientAge)) {
        $errors[] = "First name and last name are required.";
    } elseif (!ctype_alnum($patientName) || !ctype_alnum($patientAge)) {
        $errors[] = "First name and last name should be alphanumeric.";
    }


  

    // If there are no validation errors, proceed with inserting the summary into the database
    if (empty($errors)) {
        // Prepare and execute the SQL statement to insert the summary into the 'summarys' table
        $sql = "INSERT INTO summary (patientName, patientAge, patientWeight, patientSymptoms, prescribedMedicine, prescribedPrescription)
                VALUES ('$patientName', '$patientAge', '$patientWeight', '$patientSymptoms', '$prescribedMedicine', '$prescribedPrescription')";

        if ($conn->query($sql) === TRUE) {
            echo "";
        } else {
            echo "Error adding summary: " . $conn->error;
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
    <h1>PATIENT SUMMARY</h1>

    <div class="appoint-Bbox">
        <div class="appoint-Sbox">
            <div class="summary-img">

            </div>
        </div>
        <div class="appoint-Sbox">
            <div class="book-box">
            <h2>Patient Information</h2>
            <form action="" method="POST">
                <label for="patientName">First Name:</label><br>
                <input type="text" name="patientName" id="patientName" required><br>
                <label for="patientAge">Patient Age:</label><br>
                <input type="number" name="patientAge" id="patientAge" required><br>
                <label for="patientWeight">patientWeight</label><br>
                <input type="text" name="patientWeight" id="patientWeight" required><br>
                <label for="patientSymptoms">Patient Symptoms:</label><br>
                <input type="text" name="patientSymptoms" id="patientSymptoms" required><br>
                <label for="prescribedMedicine">prescribed Medicine:</label><br>
                <input type="text" name="prescribedMedicine" id="prescribedMedicine" required><br>
                <label for="prescribedPrescription">prescribed Prescription:</label><br>
                <input type="text" name="prescribedPrescription" id="prescribedPrescription" required><br>


                <br>
                <input type="submit" name="add" value="CREATE">
            </form>
        </div>
    </div>
</body>

</html>