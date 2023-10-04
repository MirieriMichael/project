<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="displays.css">
    <title>BenMic</title>
</head>

<body>
    <div id="head">
        <h1>Doctors Data:</h1>
    </div>

    <?php
    include("data.php");

    // Retrieve data from the database
    $query = "SELECT  SSN, firstName, lastName, userName, email, PhoneNo, password, gender FROM doctor";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr><th>SSN</th><th>firstName</th><th>lastName</th><th>userName</th><th>Email</th><th>Phone Number</th><th>Password</th><th>gender</th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            $SSN = $row['SSN'];
            $firstName = $row['firstName'];
            $lastName = $row['lastName'];
            $userName = $row['userName'];
            $email = $row['email'];
            $phoneNo = $row['PhoneNo'];
            $password = $row['password'];
            $gender = $row['gender'];


            echo "<tr>";
            echo "<td>$SSN</td>";
            echo "<td>$firstName</td>";
            echo "<td>$lastName</td>";
            echo "<td>$userName</td>";
            echo "<td>$email</td>";
            echo "<td>$phoneNo</td>";
            echo "<td>$password</td>";
            echo "<td>$gender</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No records found.";
    }

    mysqli_close($conn);
    ?>
</body>

</html>