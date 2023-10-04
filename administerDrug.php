<?php

function connectToDatabase()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "drugdispenser";

    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['searchPatient'])) {
        $searchPatient = $_POST['searchPatient'];

        $conn = connectToDatabase();


        $stmt = $conn->prepare("SELECT * FROM patient WHERE userName = ?");

        if (!$stmt) {
            die('Error during preparation: ' . $conn->error);
        }

        $stmt->bind_param("s", $searchPatient);

        if ($stmt->execute() === false) {
            die('Error during execution: ' . $stmt->error);
        }

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                echo "First Name: " . $row['firstName'] . "<br>";
                echo "Last Name: " . $row['lastName'] . "<br>";
                echo "user Name: " . $row['userName'] . "<br>";
                echo "Email: " . $row['email'] . "<br>";
                echo "Phone Number: " . $row['PhoneNo'] . "<br>";
                echo "Insurance Details: " . $row['insuranceDetails'] . "<br>";
                echo "Insurance Coverage: " . $row['insuranceCover'] . "<br>";
                echo "<hr>";
            }
        } else {

            echo "Patient not found.";
        }

        $stmt->close();
        $conn->close();
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['administerDrug']) && isset($_POST['patientName']) && isset($_POST['Name']) && isset($_POST['DrugDosage']) && isset($_POST['frequency'])) {
        $patientName = $_POST['patientName'];
        $drugName = $_POST['Name'];
        $drugDosage = $_POST['DrugDosage'];
        $frequency = $_POST['frequency'];

        $conn = connectToDatabase();

        $stmt = $conn->prepare("INSERT INTO drug (Name, RegistrationCode, Price, Stock, PatientName, Frequency, DrugDosage) VALUES (?, DEFAULT, 5000, 300, ?, ?, ?)");

        if (!$stmt) {
            die('Error during preparation: ' . $conn->error);
        }

        $stmt->bind_param("ssds", $drugName, $patientName, $frequency, $drugDosage);

        if ($stmt->execute() === false) {
            die('Error during execution: ' . $stmt->error);
        } else {
            echo "Drug administered successfully.";


            $prescriptionPrice = 5000;
            $prescriptionStock = 300;

            $prescriptionStmt = $conn->prepare("INSERT INTO prescription (Name, patientName, price, stock, frequency, DrugDosage) VALUES (?, ?, ?, ?, ?, ?)");

            if (!$prescriptionStmt) {
                die('Error during preparation: ' . $conn->error);
            }

            $prescriptionStmt->bind_param("ssddds", $drugName, $patientName, $prescriptionPrice, $prescriptionStock, $frequency, $drugDosage);

            if ($prescriptionStmt->execute() === false) {
                die('Error during execution: ' . $prescriptionStmt->error);
            }

            $prescriptionStmt->close();
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="administer.css">
    <title>Doctor Interface</title>
</head>

<body>


    <h2>Doctor's Search</h2>
    <form action="" method="POST">
        <label for="searchPatient">Search Patient:</label>
        <input type="text" id="searchPatient" name="searchPatient" required>
        <button type="submit">Search</button>
    </form>


    <h2>Administer Drugs</h2>
    <form action="" method="POST">
        <label for="patientName">Patient Name:</label>
        <input type="text" id="patientName" name="patientName" required><br>

        <label for="Name">Drug Name:</label>
        <input type="text" id="Name" name="Name" required><br>

        <label for="DrugDosage">Drug Dosage:</label>
        <input type="text" id="DrugDosage" name="DrugDosage" required><br>

        <label for="frequency">Frequency:</label>
        <input type="text" id="frequency" name="frequency" required><br>

        <button type="submit" name="administerDrug">Administer</button>
    </form>
</body>

</html>