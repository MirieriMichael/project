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


function getAllPrescriptions()
{
    $conn = connectToDatabase();

    $stmt = $conn->prepare("SELECT * FROM prescription");

    if (!$stmt) {
        die('Error during preparation: ' . $conn->error);
    }

    if ($stmt->execute() === false) {
        die('Error during execution: ' . $stmt->error);
    }

    $result = $stmt->get_result();
    $prescriptions = [];
    while ($row = $result->fetch_assoc()) {
        $prescriptions[] = $row;
    }

    $stmt->close();
    $conn->close();
    return $prescriptions;
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="view.css">
    <title>Pharmacist Interface</title>
</head>
<body>
   

    <h3>All Prescriptions</h3>
    <table border="1">
        <?php
        $allPrescriptions = getAllPrescriptions();
        if (count($allPrescriptions) > 0) {
            echo "<tr>
                    <th>Patient Name</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Frequency</th>
                    <th>Drug Dosage</th>
                </tr>";

            foreach ($allPrescriptions as $prescription) {
                echo "<tr>";
                echo "<td>" . $prescription['patientName'] . "</td>";
                echo "<td>" . $prescription['Name'] . "</td>";
                echo "<td>" . $prescription['price'] . "</td>";
                echo "<td>" . $prescription['stock'] . "</td>";
                echo "<td>" . $prescription['frequency'] . "</td>";
                echo "<td>" . $prescription['DrugDosage'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No prescriptions found.</td></tr>";
        }
        ?>
    </table>


</body>
</html>
