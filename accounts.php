<!DOCTYPE html>
<html lang="en">
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
$localhost = 'localhost';
$username = 'root';
$password  = '';
$database_name  = 'bankregistration';

$conn = mysqli_connect($localhost, $username, $password, $database_name);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle account creation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['createChecking'])) {
        createCheckingAccount($_POST['user_id']);
    } elseif (isset($_POST['createSavings'])) {
        createSavingsAccount($_POST['user_id']);
    } elseif (isset($_POST['deleteChecking'])) {
        deleteChecking($_POST['account_id']);
    } elseif (isset($_POST['deleteSavings'])) {
      deleteSavings($_POST['account_id']);
  }
}

// Function to create a checking account
function createCheckingAccount($user_id) {
    global $conn;
    $query = "INSERT INTO checking_accounts (user_id) VALUES ('$user_id')";
    mysqli_query($conn, $query);
}

// Function to create a savings account
function createSavingsAccount($user_id) {
    global $conn;
    $query = "INSERT INTO savings_accounts (user_id) VALUES ('$user_id')";
    mysqli_query($conn, $query);
}

// Function to delete an account
function deleteChecking($account_id) {
  global $conn;
  $query = "SELECT balance FROM checking_accounts WHERE account_id = '$account_id'";
  $result = mysqli_query($conn, $query);

  if ($row = mysqli_fetch_assoc($result)) {
      $balance = $row['balance'];
      if ($balance > 0) {
        echo '<script type="text/javascript">window.onload = function () { alert("Cannot Delete An Account With A Remaining Balance!"); } </script>';
      } else {
          $deleteQuery = "DELETE FROM checking_accounts WHERE account_id = '$account_id'";
          echo '<script type="text/javascript">window.onload = function () { alert("Selected Checking Account Deleted Successfully"); } </script>';
          mysqli_query($conn, $deleteQuery);
      }
  }
}
// Function to delete a savings account
function deleteSavings($account_id) {
  global $conn;
  $query = "SELECT balance FROM savings_accounts WHERE account_id = '$account_id'";
  $result = mysqli_query($conn, $query);

  if ($row = mysqli_fetch_assoc($result)) {
      $balance = $row['balance'];
      if ($balance > 0) {
        echo '<script type="text/javascript">window.onload = function () { alert("Cannot Delete An Account With A Remaining Balance!"); } </script>';
      } else {
          $deleteQuery = "DELETE FROM savings_accounts WHERE account_id = '$account_id'";
          echo '<script type="text/javascript">window.onload = function () { alert("Selected Savings Account Deleted Successfully"); } </script>';
          mysqli_query($conn, $deleteQuery);
      }
  }
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOIR - Manage Accounts</title>

    <link rel="stylesheet" type="text/css" href="accounts.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400&display=swap" rel="stylesheet">
    <style>
@media screen and (max-width: 1330px) {
.bank-text-dashboard button[name='deleteChecking'] {
    justify-content:center; /* Adjust the margin-left as needed */
    align-items:center;
    margin-left: 2px;
  }
  .bank-text-dashboard button[name='deleteSavings'] {
    justify-content:center; /* Adjust the margin-left as needed */
    align-items:center;
    margin-left: 2px;
  }
.bank-text-dashboard {
  margin-top: 120px;
}
}
@media screen and (max-width: 1200px) {
  .bank-text-dashboard{
    margin-top: 120px;
}
.bank-text-dashboard button[name='deleteChecking'] {
    justify-content:center; /* Adjust the margin-left as needed */
    align-items:center;
    margin-left: 5px;
  }
  .bank-text-dashboard button[name='deleteSavings'] {
    justify-content:center; /* Adjust the margin-left as needed */
    align-items:center;
    margin-left: 5px;
  }
}
@media screen and (max-width: 1195px) {
  .bank-text-dashboard{
    margin-top: -170px;
}
.bank-text-dashboard button[name='deleteChecking'] {
    justify-content:center; /* Adjust the margin-left as needed */
    align-items:center;
    margin-left: 130px;
  }
  .bank-text-dashboard button[name='deleteSavings'] {
    justify-content:center; /* Adjust the margin-left as needed */
    align-items:center;
    margin-left: 130px;
  }
}
@media screen and (max-width: 1190px) {
  .bank-text-dashboard{
    margin-top: -170px;
}
.bank-text-dashboard button[name='deleteChecking'] {
    justify-content:center; /* Adjust the margin-left as needed */
    align-items:center;
    margin-left: 125px;
  }
  .bank-text-dashboard button[name='deleteSavings'] {
    justify-content:center; /* Adjust the margin-left as needed */
    align-items:center;
    margin-left: 125px;
  }
}
@media screen and (max-width: 1165px) {
  .bank-text-dashboard{
    margin-top: -170px;
}
.bank-text-dashboard button[name='deleteChecking'] {
    justify-content:center; /* Adjust the margin-left as needed */
    align-items:center;
    margin-left: 115px;
  }
  .bank-text-dashboard button[name='deleteSavings'] {
    justify-content:center; /* Adjust the margin-left as needed */
    align-items:center;
    margin-left: 115px;
  }
}
@media screen and (max-width: 1115px) {
  .bank-text-dashboard{
    margin-top: -170px;
}
.bank-text-dashboard button[name='deleteChecking'] {
    justify-content:center; /* Adjust the margin-left as needed */
    align-items:center;
    margin-left: 110px;
  }
  .bank-text-dashboard button[name='deleteSavings'] {
    justify-content:center; /* Adjust the margin-left as needed */
    align-items:center;
    margin-left: 110px;
  }
}
@media screen and (max-width: 1010px) {
  .bank-text-dashboard{
    margin-top: -170px;
}
.bank-text-dashboard button[name='deleteChecking'] {
    justify-content:center; /* Adjust the margin-left as needed */
    align-items:center;
    margin-left: 100px;
  }
  .bank-text-dashboard button[name='deleteSavings'] {
    justify-content:center; /* Adjust the margin-left as needed */
    align-items:center;
    margin-left: 100px;
  }
}

@media screen and (max-width: 990px) {
  .navlist{
    height: 170px;
  }
  .bank-text-dashboard{
    margin-top: -170px;
  }
  .bank-text-dashboard button[name='deleteChecking'] {
    margin-left: 85px;
  }
  .bank-text-dashboard button[name='deleteSavings'] {
    margin-left: 85px;
  }
}
@media screen and (max-width: 805px) {
.bank-text-dashboard button[name='deleteChecking'] {
    margin-left: 75px;
  }
  .bank-text-dashboard button[name='deleteSavings'] {
    margin-left: 75px;
  }
}
@media screen and (max-width: 750px) {
.bank-text-dashboard button[name='deleteChecking'] {
    margin-left: 65px;
  }
  .bank-text-dashboard button[name='deleteSavings'] {
    margin-left: 65px;
  }
}
@media screen and (max-width: 680px) {
  .bank-text-dashboard{
    margin-top: -120px;
  }
.bank-text-dashboard button[name='deleteChecking'] {
    margin-left: 90px;
    margin-bottom: 0px;
    margin-top: -5px;
  }
  .bank-text-dashboard button[name='deleteSavings'] {
    margin-left: 90px;
    margin-bottom: 0px;
    margin-top: -5px;
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
    <div class="bank-text">
    <h1>Account Management</h1>
    <div class="bank-login">
    <?php echo "<h2>$firstName's Existing Accounts</h2>";?>
              <table>
                  <thead>
                      <tr>
                          <th>Account Type</th>
                          <th>Account Number</th>
                          <th>User Number</th>
                          <th>Balance</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
            <?php
            $user_id = $_SESSION['user_id'];
            // Fetch and display checking accounts
            $result = mysqli_query($conn,"SELECT account_id, user_id, balance FROM checking_accounts WHERE user_id = '$user_id'");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>Checking</td>";
                echo "<td>{$row['account_id']}</td>";
                echo "<td>{$row['user_id']}</td>";
                echo "<td>{$row['balance']}</td>";
                echo "<td>
                  <form method='post' action='' class='bank-text-dashboard'>
                    <input type='hidden' name='account_id' value='{$row['account_id']}'>
                    <button type='submit' name='deleteChecking' class='bank-text-dashboard'>
                    <span>Delete</span>
                    </button>
                  </form>
                </td>";
                echo "</tr>";
            }

            // Fetch and display savings accounts
            $result = mysqli_query($conn, "SELECT account_id, user_id, balance FROM savings_accounts WHERE user_id = '$user_id'");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>Savings</td>";
                echo "<td>{$row['account_id']}</td>";
                echo "<td>{$row['user_id']}</td>";
                echo "<td>{$row['balance']}</td>";
                echo "<td>
                  <form method='post' action='' class='bank-text-dashboard'>
                    <input type='hidden' name='account_id' value='{$row['account_id']}'>
                    <button type='submit' name='deleteSavings' class='bank-text-dashboard'>
                    <span>Delete</span>
                    </button>
                  </form>
                </td>";
                echo "</tr>";
            }
            
            ?>
        </tbody>
              </table>
      </div>
      </div>
    <div class="bank-text-dashboard" style= "margin-top: 15px; margin-bottom: 15px;">
       <!-- Form for creating a checking account -->
    <form action="" method="post">
        <label for="user_id" style="font-size: 15px;">Confirm User ID:</label>
        <input type="text" name="user_id" required placeholder="User ID" pattern="\d{12}" title="User ID Is 12 Digits">
        <button type="submit" name="createChecking" style="width: 275px;">Create Checking Account</button>
    </form>
    
    <!-- Form for creating a savings account -->
    <form action="" method="post">
        <label for="user_id" style="font-size: 15px;">Confirm User ID:</label>
        <input type="text" name="user_id" required placeholder="User ID" pattern="\d{12}" title="User ID Is 12 Digits">
        <button type="submit" name="createSavings" style="width: 275px;">Create Savings Account</button>
    </form>
      </div>
  </section>

<script src="home.js"></script>
<footer>
&copy; 2023 NOIR CAPITAL BANK. All rights reserved.
</footer>
</body>

</html>
