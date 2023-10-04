<!DOCTYPE html>
<html>

<head>
  <title>Patient Page</title>
  <link rel="stylesheet" href="patient.css">
</head>

<body>
  <section id="admin-section">
    <h2 class="welcome-text">WELCOME </h2>
    <?php
    // Start the session to access session data
    session_start();

    // Check if the user is logged in and the pharmacist's full name is stored in the session
    if (isset($_SESSION['userName'])) {
      $userName = $_SESSION['userName'];
      echo "<h1 style='color: #0085FF; font-size: 48px;'> $userName</h1>";
    } else {
      //if not they are directed to:
      header('Location: login.php');
      exit();
    }
    ?>
    <h1>WHICH USER WOULD YOU LIKE TO VIEW</h1>


    <a href="http://localhost/hosi/displayPatient.php" class="welcome-button">PATIENT</a>
    <a href="http://localhost/hosi/displayDoctor.php" class="welcome-button">DOCTOR</a>
    <a href="http://localhost/hosi/displayPharmacy.php" class="welcome-button">PHARMACY</a>

  </section>


</body>

</html>