<!DOCTYPE html>
<html>
<head>
  <title>Patient Page</title>
  <link rel="stylesheet" href="patient.css">
</head>
<body>
  <section id="doctor-section">
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
    <p class="welcome-speech">Experience the transformative power of our exceptional hospital, where compassion, healing, and progress converge.</p>
   
    
    <a href="http://localhost/hosi/summary.php" class="welcome-button">PATIENT-SUMMARY</a>
    <a href="http://localhost/hosi/admit.php" class="welcome-button">ADMIT PATIENT</a>
    <a href="http://localhost/hosi/adddrugs.php" class="welcome-button">ADD / EDIT DRUGS</a>
    <a href="http://localhost/hosi/administerDrug.php" class="welcome-button"> ADMINISTER DRUGS</a>
    

  </section>
  
  
</body>
</html>