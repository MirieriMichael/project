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



function getPatientPrescriptions($patientName)
{
    $conn = connectToDatabase();
    $stmt = $conn->prepare("SELECT * FROM prescription WHERE patientName = ?");

    if (!$stmt) {
        die('Error during preparation: ' . $conn->error);
    }

    $stmt->bind_param("s", $patientName);

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

function dispenseDrugs($patientName, $drugName, $drugDosage)
{
    $conn = connectToDatabase();

    $stmt = $conn->prepare("INSERT INTO drug (Name, RegistrationCode, Price, Stock, PatientName, DrugDosage) VALUES (?, DEFAULT, 5000, 300, ?, ?)");

    if (!$stmt) {
        die('Error during preparation: ' . $conn->error);
    }

    $stmt->bind_param("ssd", $drugName, $patientName, $drugDosage);

    if ($stmt->execute() === false) {
        die('Error during execution: ' . $stmt->error);
    }

    $stmt->close();
    $conn->close();
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


    <h3>Search for a Patient</h3>
    <form action="" method="POST">
        <label for="searchPatient">Search Patient:</label>
        <input type="text" id="searchPatient" name="searchPatient" required>
        <button type="submit">Search</button>
    </form>


    <h3>Prescriptions for Searched Patient</h3>
    <table border="1">
        <?php
        $dispenseSuccessMessage = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['searchPatient'])) {
                $searchPatient = $_POST['searchPatient'];

                if (isset($_POST['delete'])) {

                    $searchPatient = '';
                } elseif (isset($_POST['dispense'])) {

                    $drugName = isset($_POST['drugName']) ? $_POST['drugName'] : null;
                    $drugDosage = isset($_POST['drugDosage']) ? $_POST['drugDosage'] : null;

                    if ($drugName && $drugDosage) {

                        dispenseDrugs($searchPatient, $drugName, $drugDosage);

                        $dispenseSuccessMessage = "Drugs dispensed to $searchPatient: $drugName (Dosage: $drugDosage)";
                    }
                }

                $patientPrescriptions = getPatientPrescriptions($searchPatient);
                if (count($patientPrescriptions) > 0) {
                    echo "<tr>
                        <th>Patient Name</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Frequency</th>
                        <th>Drug Dosage</th>
                    </tr>";

                    foreach ($patientPrescriptions as $prescription) {
                        echo "<tr>";
                        echo "<td>" . $prescription['patientName'] . "</td>";
                        echo "<td>" . (isset($prescription['Name']) ? $prescription['Name'] : '') . "</td>";
                        echo "<td>" . $prescription['price'] . "</td>";
                        echo "<td>" . $prescription['stock'] . "</td>";
                        echo "<td>" . $prescription['frequency'] . "</td>";
                        echo "<td>" . (isset($prescription['DrugDosage']) ? $prescription['DrugDosage'] : '') . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No prescriptions found for $searchPatient.</td></tr>";
                }
            }
        }
        ?>
    </table>


    <form action="" method="POST">
        <input type="hidden" id="searchPatient" name="searchPatient" value="<?= $searchPatient ?>">
        <label for="drugName">Drug Name:</label>
        <input type="text" id="drugName" name="drugName"><br>
        <label for="drugDosage">Drug Dosage:</label>
        <input type="text" id="drugDosage" name="drugDosage"><br>
        <button type="submit" name="delete">Delete</button><br>
        <br>
        <button type="submit" name="dispense">Dispense</button><br>
    </form>


    <?php echo $dispenseSuccessMessage; ?>







</body>

</html>