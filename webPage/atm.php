<?php
include '../processingPages/conn.php';

$logged_in = false;
$userExist = false;

if (isset($_POST["debitcard"]) && isset($_POST["Pin"])) {
    if ($_POST["debitcard"] && $_POST["Pin"]) {
        $debitcard = $_POST["debitcard"];
        $Pin = $_POST["Pin"];

        $conn = mysqli_connect("localhost", "root", "", "bankregistration");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT * FROM bank_users WHERE debitcard = '$debitcard'";
        $results = mysqli_query($conn, $sql);

        if ($results) {
            $userExist = true;
            $row = mysqli_fetch_assoc($results);
            if ($row["Pin"] === $Pin) {
                $logged_in = true;
                session_start();
                $_SESSION['debitcard'] = $debitcard;
                $_SESSION['firstName'] = $row['firstName'];
                $_SESSION['lastName'] = $row['lastName'];
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['debitcard'] = $row['debitcard'];
                $_SESSION['debitcard_balance'] = $row['debitcard_balance'];
                $_SESSION['username']= $row['username']; 
                $_SESSION['debitcard_expire'] = $row['debitcard_expire'];
                $_SESSION['debitcard_cvv'] = $row['debitcard_cvv'];
            }
        }

        if ($logged_in) {
            echo '<script>';
            echo 'var redirectUrl = "../webPage/dashboardATM.php";';
            echo 'window.location.href = redirectUrl;';
            echo '</script>';
            exit();
            }
        } elseif ($userExist) {
            echo '<script type="text/javascript">window.onload = function () { alert("Card Number or PIN is incorrect!"); } </script>';
        }

        mysqli_close($conn);
    }
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>NOIR - ATM</title>

  <link rel="stylesheet" type="text/css" href="../css/atm.css">

  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

  <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400&display=swap" rel="stylesheet">

</head>

<body>
  <header>
    <a href="homepage.html" class="logo">NOIR CAPITAL BANK</a>

    <ul class="navlist">
      <li><a href="../webPage/homepage.html">Home</a></li>
      <li><a href="../webPage/login.php">Sign In</a></li>
      <li><a href="../webPage/contact1.php">Contact</a></li>
      <li><a href="../webPage/about.html">About</a></li>
      <li><a href="../webPage/atm.php">ATM</a></li>
    </ul>
    <div class="bx bx-menu" id="menu-icon"></div>
  </header>


  <section class="bank2">
    <div class="atm-screen" id="atmScreen">
            <form action="../webPage/atm.php" method="post">
            <h2>Virtual ATM</h2>
            <br>
            <div class="input-field">
                <label for="debitcard">Card Number:</label>
                <input type="text" id="debitcard" name="debitcard" required placeholder="Enter your card number">
            </div>
            <div class="input-field">
                <label for="Pin">PIN:</label>
                <input type="password" id="Pin" name="Pin" required placeholder="Enter your PIN">
            </div>
                <button type="submit" onclick="submit()">Submit</button>
        </div>
    <br>
    </div>
    </div>
  </section>

  <script src="https://unpkg.com/scrollreveal"></script>

  <script src="../js/home.js"></script>
  <footer>
    &copy; 2023 NOIR CAPITAL BANK. All rights reserved.
  </footer>
</body>

</html>
