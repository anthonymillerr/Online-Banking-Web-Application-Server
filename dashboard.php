<!DOCTYPE html>
<html>
<head>
<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT']. '/conn.php';
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
  // Redirect to the login page if not logged in
  header("Location: login.php");
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
  <link rel="stylesheet" type="text/css" href="dashboard.css">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400&display=swap" rel="stylesheet">
  <style>


@media screen and (max-width: 1300px) {
  .bank-text-dashboard {
    margin-bottom: 40px; 
  }
}
@media screen and (max-width: 1100px) {
  .bank-text-dashboard {
    margin-bottom: 40px; 
  }
}
@media screen and (max-width: 990px) {
    .navlist {
    height: 180px;
  }
}
@media screen and (max-width: 750px) {
  .bank-text-dashboard {
    margin-bottom: 40px; 
  }
  .navlist {
    height: 180px;
  }
}

</style>
</head>

<body>
  <header>
    <a href "#" class="logo">NOIR CAPITAL BANK</a>

    <ul class="navlist">
      <li><a href="dashboard.php">Dashboard</a></li>
      <li><a href="atm.php">ATM</a></li>
      <li><a href="contact1.php">Contact</a></li>
      <li><a href="about.html">About</a></li>
      <li><a href="logout.php">Logout</a></li>
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
          <a href="accounts.php"> Manage Accounts </a>
          <br>
          <br>
          <a href="deposit.php"> Electronic Check Deposit</a>
          <br>
          <br>
          <a href="transfer.php"> Fund Transfers </a>
          <br>
          <br>
          <a href="transactions.php"> See Transactions </a>
        </div>

  </section>

  <div class="icons">

  </div>
  <script src="https://unpkg.com/scrollreveal"></script>

  <script src="home.js"></script>
  <footer>
    &copy; 2023 NOIR CAPITAL BANK. All rights reserved.
  </footer>
</body>

</html>