<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="adddrugs.css">
    <title>BENMIC drugName</title>
</head>

<body>


    <section id="form">


        <?php
        // Include the data.php file for the database connection
        require_once 'data.php';

        // Handle form submission to add a new drug
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['add'])) {
                $drugName = $_POST['drugName'];
                $dosage = $_POST['dosage'];

                // Prepare and execute the SQL statement to insert the drug data
                $stmt = $conn->prepare("INSERT INTO medicine (drugName, dosage) VALUES (?, ?)");
                $stmt->bind_param("ss", $drugName, $dosage);
                $stmt->execute();

                // Close the statement
                $stmt->close();

                echo "<p>Drug Added Successfully.</p>";
            } elseif (isset($_POST['edit'])) {
                // Retrieve the form data
                $drugName = $_POST['drugName'];
                $newdrugName = $_POST['new_drugName'];
                $newdosage = $_POST['new_dosage'];

                // Prepare and execute the SQL statement to update the drug details
                $stmt = $conn->prepare("UPDATE medicine SET drugName = ?, dosage = ? WHERE drugName = ?");
                $stmt->bind_param("sss", $newdrugName, $newdosage, $drugName);
                $stmt->execute();

                // Close the statement
                $stmt->close();

                echo "Drug updated successfully.";
            } elseif (isset($_POST['search'])) {
                $drugName = $_POST['drugName'];

                // Prepare the SQL statement to search for a drug by name
                $stmt = $conn->prepare("SELECT * FROM medicine WHERE drugName = ?");
                $stmt->bind_param('s', $drugName);
                $stmt->execute();

                $result = $stmt->get_result();
                $drug = $result->fetch_assoc();
            }
        }
        ?>

        <h3>Add Drugs</h3><br>
        <div class="patient-form">
            <form method="post">
                <label for="drugName">Drug </label><br>
                <input type="text" name="drugName" id="drugName" required><br>
                <label for="dosage">Dosage</label><br>
                <input type="text" name="dosage" id="dosage" placeholder="ksh.000" required><br>
                <button type="submit" name="add" class="normal">Submit</button><br>
                <button type="reset"  name="sub" class="normal">Reset</button><br>
            </form>
        </div>

        <h3>Edit Drugs</h3><br>
        <div class="patient-form">
            <form method="post">
                <label for="drugName">Drug </label><br>
                <input type="text" name="drugName" id="drugName" required><br>
                <label for="new_drugName">New Drug</label><br>
                <input type="text" name="new_drugName" id="new_drugName" required><br>
                <label for="new_dosage">New Drug dosage</label><br>
                <input type="text" name="new_dosage" id="new_dosage" placeholder="ksh.000" required><br>
                <button type="submit" name="edit" class="normal">Edit</button>
            </form>
        </div>
        <br>

        <h3>Search Drugs</h3><br>
        <div class="patient-form">
            <form method="post">
                <label for="drugName">Drug </label><br>
                <input type="text" name="drugName" id="drugName" required><br>
                <button type="submit" name="search" class="normal">Search</button><br>
            </form>
        </div>
            <?php
            // Display the drug details if the search form is submitted
            if (isset($drug)) {
                if ($drug) {
                    echo "<h4 style='color: black;'>Drug Details</h4>";
                    echo "Drug Name: " . $drug["drugName"] . "<br>";
                    echo "Dosage: " . $drug["dosage"] . "<br>";
                } else {
                    echo "<p>Drug not found in the database.</p>";
                }
            }
            ?>

    </section>
</body>

</html>