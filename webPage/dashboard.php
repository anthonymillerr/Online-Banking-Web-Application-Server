<!DOCTYPE html>
<html>
<head>
<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT']. '/processingPages/conn.php';
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
  // Redirect to the login page if not logged in
  header("Location: ../webPage/login.php");
  exit();
}
// Retrieve the user's first name from the database
$username = $_SESSION['username'];
$sql = "SELECT firstName FROM bank_users WHERE username = '$username'";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($row = mysqli_fetch_assoc($result)) {
    $firstName = $row['firstName'];
} else {
    // Handle the case where the user's data is not found
    $firstName = "User";
}
?>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>NOIR - Dashboard</title>
  <link rel="stylesheet" type="text/css" href="../css/dashboard.css">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400&display=swap" rel="stylesheet">
</head>

<body>
  <header>
    <a href "#" class="logo">NOIR CAPITAL BANK</a>

    <ul class="navlist">
      <li><a href="../webPage/dashboard.php">Dashboard</a></li>
      <li><a href="../webPage/atm.php">ATM</a></li>
      <li><a href="../webPage/contact1.php">Contact</a></li>
      <li><a href="../webPage/about.html">About</a></li>
      <li><a href="../processingPages/logout.php">Logout</a></li>
    </ul>
    <div class="bx bx-menu" id="menu-icon"></div>
  </header>

  <section class="bank">
        <div class="bank-text" style = "margin-top: 50px;">
          <h4>Welcome <?php echo $firstName; ?>! Let's Manage Your Finances, Together.</h4>
          <p>Accounts Overview</p>
      
          <div class="bank-account">
          <?php
        $username = $_SESSION['username'];
        $sql = "SELECT firstName, user_id FROM bank_users WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);

        if ($row = mysqli_fetch_assoc($result)) {
            $firstName = $row['firstName'];
            echo "<h4>{$firstName}'s NOIR ACCOUNT</h4>";
            echo "USER ID: " . $row["user_id"];
        } else {
            echo "0 results";
    }
    ?>
          </div>

          <div class="container">
                <div class="left_side">
                    <h4>PERSONAL INFO</h4>
                    <?php
                    $username = $_SESSION['username'];
                    $sql = "SELECT email, phonenumber, address FROM bank_users WHERE username = '$username'";
                    $result = mysqli_query($conn, $sql);
                    if ($row = mysqli_fetch_assoc($result)) {
                    echo "<h4>Email:</h4> " . $row["email"] . "<br><h4>Phone Number:</h4> " . $row["phonenumber"] . "<br><h4>Address:</h4>" . $row["address"];
                    } else {
                    echo "0 results";
                    }?>
                </div>
            
                <div class="right_side">
                    <h4>CARD INFO</h4>
                    <?php
                    $username = $_SESSION['username'];
                    $sql = "SELECT debitcard, Pin FROM bank_users WHERE username = '$username'";
                    $result = mysqli_query($conn, $sql);
                    if ($row = mysqli_fetch_assoc($result)) {
                    echo "<h4>Debit Card #:</h4> " . $row["debitcard"] . "<br><br><h4>PIN:</h4> " . $row["Pin"];
                    } else {
                    echo "0 results";
                    }
                    ?>
                </div>
          </div>
      </div>

        <div class="bank-text-dashboard">
          <br>
          <br>
          <br>
          <br>
          <a href="../webPage/accounts.php"> Manage Accounts </a>
          <br>
          <br>
          <a href="../webPage/deposit.php"> Electronic Check Deposit</a>
          <br>
          <br>
          <a href="../webPage/transfer.php"> Fund Transfers </a>
          <br>
          <br>
          <a href="../webPage/transactions.php"> See Transactions </a>
        </div>

  </section>

  <div class="icons">

  </div>
  <script src="https://unpkg.com/scrollreveal"></script>

  <script src="../js/home.js"></script>
  <footer>
    &copy; 2023 NOIR CAPITAL BANK. All rights reserved.
  </footer>
</body>

</html>