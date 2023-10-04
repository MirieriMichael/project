<?php
require_once "data.php"; // Include the database connection file

// Function to redirect the user to another page
function redirect($page)
{
    header("Location: $page");
    exit();
}

// Start the session
session_start();

if (isset($_POST['submit'])) {
    // Retrieve the form data
    $userName = $_POST['userName'];
    $password = $_POST['password'];

    if (!$conn) {
        echo "Could not connect!";
    } else {
        // Prepare and execute the query for doctors
        $query = "SELECT * FROM doctor WHERE userName = ? AND password = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $userName, $password);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
            mysqli_close($conn);

            // Store the user's userName in a session variable
            $_SESSION['userName'] = $userName;

            redirect("http://localhost/hosi/doctorPage.php"); // Redirect to the desired page
        } else {
            // Check for patient
            $query = "SELECT * FROM patient WHERE userName = ? AND password = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ss", $userName, $password);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                mysqli_stmt_close($stmt);
                mysqli_close($conn);

                // Store the user's userName in a session variable
                $_SESSION['userName'] = $userName;

                redirect("http://localhost/hosi/patientPage.php"); // Redirect to the desired page
            } else {
                // Check for pharmacy
                $query = "SELECT * FROM pharmacy WHERE userName = ? AND password = ?";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "ss", $userName, $password);
                mysqli_stmt_execute($stmt);

                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_assoc($result);
                    mysqli_stmt_close($stmt);
                    mysqli_close($conn);

                    // Store the user's userName in a session variable
                    $_SESSION['userName'] = $userName;

                    redirect("http://localhost/hosi/pharmacyPage.php"); // Redirect to the desired page
                } else {
                    // Check for admins
                    $query = "SELECT * FROM admins WHERE userName = ? AND password = ?";
                    $stmt = mysqli_prepare($conn, $query);
                    mysqli_stmt_bind_param($stmt, "ss", $userName, $password);
                    mysqli_stmt_execute($stmt);

                    $result = mysqli_stmt_get_result($stmt);

                    if (mysqli_num_rows($result) == 1) {
                        $row = mysqli_fetch_assoc($result);
                        mysqli_stmt_close($stmt);
                        mysqli_close($conn);

                        // Store the user's userName in a session variable
                        $_SESSION['userName'] = $userName;

                        redirect("http://localhost/hosi/adminPage.php"); // Redirect to the desired page
                    } else {
                        echo "Invalid userName or password";
                    }

                    mysqli_stmt_close($stmt);
                }
            }
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
    <link rel="stylesheet" href="log.css">
    <title>BenMic</title>

</head>

<body>
    <h1 name="title">BenMic</h1>
    <div class="login-box">
        <form method="POST" action="">
            <div class="head">
                <h1>Login</h1>
            </div>
            <div class="user-box">
                <label for="userName">UserName:</label><br>
                <input type="userName" name="userName" required><br>
            </div>
            <div class="user-box">
                <label for="password">Password:</label><br>
                <input type="password" name="password"><br>
            </div>

            <input type="submit" name="submit" value="LogIn" class="log-in-btn">

        </form>
    </div>
</body>

</html>