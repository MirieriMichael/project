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


function getDispensedDrugsHistory()
{
    $conn = connectToDatabase();

    $stmt = $conn->prepare("SELECT * FROM drug WHERE patientName IS NOT NULL");

    if (!$stmt) {
        die('Error during preparation: ' . $conn->error);
    }

    if ($stmt->execute() === false) {
        die('Error during execution: ' . $stmt->error);
    }

    $result = $stmt->get_result();
    $dispensedDrugsHistory = [];
    while ($row = $result->fetch_assoc()) {
        $dispensedDrugsHistory[] = $row;
    }

    $stmt->close();
    $conn->close();
    return $dispensedDrugsHistory;
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
   
    <h3>History of Dispensed Drugs</h3>
    <table border="1">
        <?php
        $dispensedDrugsHistory = getDispensedDrugsHistory();
        if (count($dispensedDrugsHistory) > 0) {
            echo "<tr>
                    <th>Patient Name</th>
                    <th>Drug Name</th>
                    <th>Drug Dosage</th>
                </tr>";

            foreach ($dispensedDrugsHistory as $dispensedDrug) {
                echo "<tr>";
                echo "<td>" . $dispensedDrug['PatientName'] . "</td>";
                echo "<td>" . $dispensedDrug['Name'] . "</td>";
                echo "<td>" . $dispensedDrug['DrugDosage'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No drugs have been dispensed yet.</td></tr>";
        }
        ?>
    </table>
</body>
</html>
