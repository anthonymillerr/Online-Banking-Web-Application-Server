<?php
$userVerified = false;
$enteredCode = false;

session_start();
include_once $_SERVER['DOCUMENT_ROOT']. '/conn.php';
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
  // Redirect to the login page if not logged in
  header("Location: login.php");
  exit();
}

if (isset($_POST["verificationCode"])) {
    if ($_POST["verificationCode"]) {
        $code = $_POST["verificationCode"];
        $enteredCode = true;
        // create connection
        $conn = mysqli_connect("localhost", "root", "", "bankregistration");
        // check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $username = $_SESSION['username'];
        $sql = "SELECT email FROM bank_users WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        if ($row = mysqli_fetch_assoc($result)) {
            $userEmail = $row["email"];
        } else {
            echo "0 results";
        }
        
        $userEmail = $row["email"];
        $sql = "SELECT * FROM verify WHERE email = '$userEmail'";
        $results = mysqli_query($conn, $sql);

        if ($results) {
            $row = mysqli_fetch_assoc($results);
            if ($row["code"] === $code) {
                $userVerified = true;
                $emailToDelete = $row["email"];

                $sql = "DELETE FROM verify WHERE email = '$emailToDelete'";
                $deleteResults = mysqli_query($conn, $sql);

                if ($deleteResults) {
                    echo "User data deleted successfully.";
                } else {
                    echo "Error deleting user data: " . mysqli_error($conn);
                }
            }
        }
        mysqli_close($conn); // close connection
    }
}
?>

<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>NOIR - Verification</title>

    <link rel="stylesheet" type="text/css" href="home.css" />

    <link
      rel="stylesheet"
      href="https://unpkg.com/boxicons@latest/css/boxicons.min.css"
    />

    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css"
      rel="stylesheet"
    />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400&display=swap"
      rel="stylesheet"
    />
  </head>

  <body>
    <header>
      <a href="homepage.html" class="logo">Verification Page</a>

      <ul class="navlist">
        <li><a href="homepage.html">Home</a></li>
        <li><a href="login.php">Sign In</a></li>
        <li><a href="contact1.php">Contact</a></li>
        <li><a href="about.html">About</a></li>
        <li><a href="atm.html">ATM</a></li>
      </ul>
      <div class="bx bx-menu" id="menu-icon"></div>
    </header>

    <section class="bank">
      <div class="bank-text">
        <div class="bank-img">
          <img src="home.png" style="width: fit-content; margin-left: -150px" />
        </div>
      </div>

      <div class="bank-login">
        <form action="/verify.php" method="post">
          <label for="verificationCode">Enter Verification Code: </label>
          <input 
          type="text" id="verificationCode" 
          name="verificationCode" 
          required 
          placeholder="5 Digit Code"
          pattern="\d{5}"
          title="PIN must be exactly 5 Digits"
          />
          <?php
          if ($userVerified) {
              header("Location: dashboard.php");
              exit();
          } else if($enteredCode){
            $enteredCode = false;
            echo '<script type="text/javascript">window.onload = function () { alert("Incorrect Code!"); } </script>';
          }
          ?>
          <button type="submit">Confirm</button>
          <button onclick="openContactWindow()">
            Having Issues? Contact Us.
          </button>
        </form>
      </div>
    </section>
    
    <div class="icons"></div>

    <script>
      function openContactWindow() {
        window.location.href = "contact1.php";
      }
    </script>

    <script src="https://unpkg.com/scrollreveal"></script>

    <script src="home.js"></script>
    <footer>&copy; 2023 NOIR CAPITAL BANK. All rights reserved.</footer>
  </body>
</html>
