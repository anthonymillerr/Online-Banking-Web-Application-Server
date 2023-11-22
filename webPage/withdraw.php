<?php
// Include your database connection file
include('../processingPages/conn.php');

// Start or resume a session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: ../webPage/atm.php");
    exit();
}

// Get the user's ID from the session
$user_id = $_SESSION['user_id'];

// Retrieve the user's checking accounts and savings accounts
$query_checking = "SELECT * FROM checking_accounts WHERE user_id = $user_id";
$result_checking = mysqli_query($conn, $query_checking);
$checking_accounts = mysqli_fetch_all($result_checking, MYSQLI_ASSOC);

$query_savings = "SELECT * FROM savings_accounts WHERE user_id = $user_id";
$result_savings = mysqli_query($conn, $query_savings);
$savings_accounts = mysqli_fetch_all($result_savings, MYSQLI_ASSOC);

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
    <title>Transfer to Debit Card</title>
    <link rel="stylesheet" type="text/css" href="../css/withdraw.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400&display=swap" rel="stylesheet">

</head>
<body>

    <h1>Transfer to Debit Card</h1>

    <!-- Display success message if redirected with success parameter -->
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $account_type = $_POST['account_type'];
    $amount = $_POST['amount'];

    // Add your validation for the amount and other necessary checks

    // Check if the amount is 0 or negative
    if ($amount <= 0) {
        echo '<div class="message error" style="color: white;">Invalid Withdraw Amount</div>';
        echo '<br>';
        echo '<button onclick="history.back()">Return To Withdraw</button>';
        exit();
    }

    // Check if the account balance is sufficient
    $check_balance_query = "SELECT balance FROM $account_type WHERE user_id = $user_id";
    $result_balance = mysqli_query($conn, $check_balance_query);
    $account_balance = mysqli_fetch_assoc($result_balance)['balance'];

    if ($account_balance < $amount) {
        echo '<div class="message error" style="color: white;">Insufficient Balance</div>';
        echo '<br>';
        echo '<button onclick="history.back()">Return To Withdraw</button>';
        exit();
    }

    // Perform the transfer
    $update_account_query = "UPDATE $account_type SET balance = balance - $amount WHERE user_id = $user_id";
    mysqli_query($conn, $update_account_query);

    // Log the deposit transaction
    $transaction_type = 'Withdraw';
    $status = 'Completed';
    // Get the amount from the form
    $amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);

    // Generate a unique transaction_id
    $transaction_id = rand(100000000, 999999999);
    $details = "Withdraw For $$amount";
    insertTransaction($user_id, $transaction_id, $transaction_type, $amount, $status, $details);

    // Update debitcard_balance in bank_users table
    $update_debitcard_query = "UPDATE bank_users SET debitcard_balance = debitcard_balance + $amount WHERE user_id = $user_id";
    mysqli_query($conn, $update_debitcard_query);

    // Redirect to a success page or the same page with a success message
    header("Location: ../webPage/withdraw.php?success=1");
    exit();
}
?>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="account_type">Select Account:</label>
        <select name="account_type" id="account_type" required>
            <optgroup label="Checking Accounts">
                <?php foreach ($checking_accounts as $checking_account): ?>
                    <option value="checking_accounts"><?php echo $checking_account['account_id'] . ' - $' . $checking_account['balance']; ?></option>
                <?php endforeach; ?>
            </optgroup>
            <optgroup label="Savings Accounts">
                <?php foreach ($savings_accounts as $savings_account): ?>
                    <option value="savings_accounts"><?php echo $savings_account['account_id'] . ' - $' . $savings_account['balance']; ?></option>
                <?php endforeach; ?>
            </optgroup>
        </select>

        <br>

        <label for="amount">Enter Amount:</label>
        <input type="text" name="amount" id="amount" required placeholder="Amount" pattern="[0-9]+(\.[0-9]{1,2})?" title="Enter Valid Amount">

        <br>

        <button type="submit" id="submit">TRANSFER TO DEBIT CARD</button>
    </form>
    <button onclick="returnToDashboard()">RETURN TO ATM DASHBOARD</button>

<script>
    function returnToDashboard() {
        // Close the current popup window
        window.close();
    }
</script>
</body>
</html>
