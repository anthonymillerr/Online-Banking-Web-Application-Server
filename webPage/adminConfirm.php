<?php
include('conn.php');

// Fetch pending transactions
$query = "SELECT * FROM transactions WHERE status = 'Pending'";
$result = mysqli_query($conn, $query);

// Display a table with transaction details and approval/denial options
// Add buttons or links for approval and denial
?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>NOIR - Admin Panel</title>

  <link rel="stylesheet" type="text/css" href="adminConfirm.css">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">


  <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/bootstrap.min.css">

</head>

<body class="bg-dark">
  <header>
    <a href "#" class="logo">NOIR CAPITAL BANK</a>

    <ul class="navlist">
      <li><a href="contact1.php">Contact</a></li>
      <li><a href="about.html">About</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
    <div class="bx bx-menu" id="menu-icon"></div>
  </header>
  <section class="bank">
     <div class="bank-text" style="margin-left: -140px">
      <h4>Admin Page</h4>
      <p>Pending Transactions</p>
      <form style="margin-left: 0px; color:gray; margin-top: 50px;">
        <label for="account_number">Admin Pages</label>
        <!--<input type="text" id="accountnumber" name="accountnumber" style="background-color: lightgray;">-->
        <br>
        <br>
        <button type="button" onclick="openAllUsers()" style="width: 200px;">All Users Details</button>
        <br>
        <br>
        <button type="button" onclick="openAllSavings()" style="width: 200px;"> User Details(Savings)</button>
        <br>
        <br>
        <button type="button" onclick="openAllCheckings()" style="width: 200px;">User Details(Checking)</button>
        <br>
        <br>
        <button type="button" onclick="openUserReports()" style="width: 200px;">User Reports</button>
        <br>
        <br>
        <button type="button" onclick="openPending()" style="width: 200px;">Pending Transactions</button>
      </form>
    </div>

    <div class="bank-text">
      <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>User ID</th>
                    <th>Account Number</th>
                    <th>Transaction Type</th>
                    <th>Account Type</th>
                    <th>Amount</th>
                    <th>Details</th>
                    <th>Status</th>
                    <th>Action</th>
                    <th>Image (FRONT)</th>
                    <th>Image (BACK)</th>
                </tr>
            </thead>
            <tbody>
            <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<td>' . $row['transaction_id'] . '</td>';
                            echo '<td>' . $row['user_id'] . '</td>';
                            echo '<td>'. $row['account_number'] . '</td>';
                            echo '<td>' . $row['transaction_type'] . '</td>';
                            echo '<td>' . $row['account_type'] . '</td>';
                            echo '<td>' . $row['amount'] . '</td>';
                            echo '<td>' . $row['details'] . '</td>';
                            echo '<td>' . $row['status'] . '</td>';
                            echo '<td>';
                            echo '<form method="post" action="">';
                            echo '<input type="hidden" name="transaction_id" value="' . $row['transaction_id'] . '">';
                            echo '<td><img src="data:image/jpeg;base64,' . base64_encode($row['image1']) . '" alt="Image 1"></td>';
                            echo '<td><img src="data:image/jpeg;base64,' . base64_encode($row['image2']) . '" alt="Image 2"></td>';
                            echo '<button type="submit" name="approve" class="approval-button">Approve</button>';
                            echo '<br><br>';
                            echo '<button type="submit" name="deny" class="deny-button">Deny</button>';
                            echo '</form>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
            </tbody>
        </table>
    </div>
      
  </section>

  <?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['approve']) || isset($_POST['deny']))) {
  $transaction_id = $_POST['transaction_id'];
  
  $transaction_query = "SELECT * FROM transactions WHERE transaction_id = '$transaction_id'";
  $transaction_result = mysqli_query($conn, $transaction_query);

  if (!$transaction_result) {
      die('Error fetching transaction details: ' . mysqli_error($conn));
  }

  $row = mysqli_fetch_assoc($transaction_result);
  $account_number = $row['account_number'];
//see what the admin chose
  if (isset($_POST['approve'])) {
      if ($row['account_type'] == 'checking') {
          $accountTable = 'checking_accounts';
      } else {
          $accountTable = 'savings_accounts';
      }

      // get balance from the row with the specific id
      $balance_query = "SELECT balance FROM $accountTable WHERE account_id = '$account_number'";
      $balance_result = mysqli_query($conn, $balance_query);

      if (!$balance_result) {
          die('Error fetching balance: ' . mysqli_error($conn));
      }

      $balance_row = mysqli_fetch_assoc($balance_result);
      $currentBalance = $balance_row['balance'];

      $amount = $row['amount'] + $currentBalance;

      $updateQuery = "UPDATE $accountTable SET balance = $amount WHERE account_id = '$account_number'";
      mysqli_query($conn, $updateQuery);

      $time = 1;
      mysqli_query($conn, "UPDATE transactions SET status = 'Approved' WHERE transaction_id = '$transaction_id'");
  } elseif (isset($_POST['deny'])) {
      // Update the transaction status to 'Denied' in the database
      mysqli_query($conn, "UPDATE transactions SET status = 'Denied' WHERE transaction_id = '$transaction_id'");
  }
  //added this becasuse for some reason it was requiring 2 button presses to get rid of the approval and it would update the db twice(this stopped it from resubmitting)
  header('Location: adminConfirm.php');
  exit();
}

?>

  <div class="icons">

  </div>

  <script>
    function openAllUsers() {
      window.location.href = "admin.php";
    }

    function openUserReports() {
      window.location.href = "admin2.php";
    }

    function openAllSavings() {
      window.location.href = "admin3.php";
    }

    function openAllCheckings() {
      window.location.href = "admin4.php";
    }
     function openPending() {
      window.location.href = "adminConfirm.php";
    }
  </script>
  <script src="home.js"></script>
  <footer>
    &copy; 2023 NOIR CAPITAL BANK. All rights reserved.
  </footer>
</body>
</html>
