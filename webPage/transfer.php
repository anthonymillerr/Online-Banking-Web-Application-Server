<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/processingPages/conn.php';
$user_id = $_SESSION['user_id'];

$localhost = 'localhost';
$username = 'root';
$password  = '';
$database_name  = 'bankregistration';

$conn = mysqli_connect($localhost, $username, $password, $database_name);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to transfer funds
function transferFunds($source_user_id, $source_account_id, $destination_user_id, $destination_account_id, $amount, $account_type) {
    global $conn;

    // Check the balance of the source account
    $sourceBalanceResult = mysqli_query($conn, "SELECT balance FROM $account_type WHERE user_id = '$source_user_id' AND account_id = '$source_account_id'");
    $sourceBalanceRow = mysqli_fetch_assoc($sourceBalanceResult);

    if (!$sourceBalanceRow || $sourceBalanceRow['balance'] <= 0 || $sourceBalanceRow['balance'] < $amount) {
        // Insufficient funds or invalid source account
        echo '<div class="message error">Invalid account(s) or insufficient funds</div>';
        return;
    }

    // Deduct funds from the source account
    $queryDeduct = "UPDATE $account_type SET balance = balance - $amount WHERE user_id = '$source_user_id' AND account_id = '$source_account_id'";
    mysqli_query($conn, $queryDeduct);

    // Add funds to the destination account
    $queryAdd = "UPDATE $account_type SET balance = balance + $amount WHERE user_id = '$destination_user_id' AND account_id = '$destination_account_id'";
    mysqli_query($conn, $queryAdd);

    // Output success message
    echo '<div class="message success">Funds transfer successful</div>';
}
// Function to insert a transaction record

function insertTransaction($user_id, $transaction_id, $transaction_type, $amount, $status, $details) {
    global $conn;

    $sql = "INSERT INTO transactions (user_id, transaction_id, transaction_type, amount, status, details) VALUES ('$user_id', '$transaction_id', '$transaction_type', '$amount', '$status', '$details')";
    $result = mysqli_query($conn, $sql);

    return $result;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOIR - Transfer Funds</title>
    <link rel="stylesheet" type="text/css" href="../css/transfer.css">
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
  <div class="bank-text">
    <div class="container">
    <h2>Transfer Funds</h2>
    <form action="transfer.php" method="post">
        <label for="source_user_id">Source User ID:</label>
        <input type="text" name="source_user_id" required placeholder="Source User ID" pattern="\d{12}" title="Source User ID Is 12 Digits">

        <label for="source_account_id">Source Account ID:</label>
        <input type="text" name="source_account_id" required placeholder="Source Account ID" pattern="[0-9]{1,12}" title="Enter Valid Account ID">

        <label for="destination_user_id">Destination User ID:</label>
        <input type="text" name="destination_user_id" required placeholder="Destination User ID" pattern="\d{12}" title=" Destination User ID Is 12 Digits">

        <label for="destination_account_id">Destination Account ID:</label>
        <input type="text" name="destination_account_id" required placeholder="Destination Account ID" pattern="[0-9]{1,12}" title="Enter Valid Account ID">

        <label for="account_type">Account Type:</label>
        <select name="account_type" required>
            <option value="checking_accounts">Checking</option>
            <option value="savings_accounts">Savings</option>
        </select>
        <br>
        <br>

        <label for="amount">Amount In $:</label>
        <input type="text" name="amount" required placeholder="Amount" pattern="[0-9]+(\.[0-9]{1,2})?" title="Enter Valid Amount">

        <button type="submit" name="transfer">Transfer Funds</button>
    </form>
    <br>
   <?php 
   if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['transfer'])) {
    $source_user_id = isset($_POST['source_user_id']) ? $_POST['source_user_id'] : '';
    $source_account_id = isset($_POST['source_account_id']) ? $_POST['source_account_id'] : '';
    $destination_user_id = isset($_POST['destination_user_id']) ? $_POST['destination_user_id'] : '';
    $destination_account_id = isset($_POST['destination_account_id']) ? $_POST['destination_account_id'] : '';
    $amount = isset($_POST['amount']) ? $_POST['amount'] : '';
    $account_type = isset($_POST['account_type']) ? $_POST['account_type'] : ''; 

    // Check if the source and destination accounts exist
    $sourceAccountResult = mysqli_query($conn, "SELECT * FROM $account_type WHERE user_id = '$source_user_id' AND account_id = '$source_account_id'");
    $destinationAccountResult = mysqli_query($conn, "SELECT * FROM $account_type WHERE user_id = '$destination_user_id' AND account_id = '$destination_account_id'");

    if (!$sourceAccountResult) {
        die("Error in source account query: " . mysqli_error($conn));
    }

    if (!$destinationAccountResult) {
        die("Error in destination account query: " . mysqli_error($conn));
    }

    $sourceAccountRow = mysqli_fetch_assoc($sourceAccountResult);
    $destinationAccountRow = mysqli_fetch_assoc($destinationAccountResult); 

  if ($sourceAccountRow && $destinationAccountRow) {
      // Process fund transfer
      transferFunds($source_user_id, $source_account_id, $destination_user_id, $destination_account_id, $amount, $account_type);
      // Log the deposit transaction
      $transaction_type = 'Transfer';
      $status = 'Completed';
      // Generate a unique transaction_id
      $transaction_id = rand(10000000, 999999999);
      $details = "Transfer: FROM User ID: $source_user_id and Account ID: $source_account_id TO User ID: $destination_user_id and Account ID: $destination_account_id";
      insertTransaction($user_id, $transaction_id, $transaction_type, $amount, $status, $details);
  } 
}
  ?>
    </div>
  </div>
</section>
<script src="home.js"></script>
<footer>
&copy; 2023 NOIR CAPITAL BANK. All rights reserved.
</footer>
</body>
</html>
