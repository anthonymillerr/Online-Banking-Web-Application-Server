<?php
$localhost = 'localhost';
$username = 'root';
$password  = '';
$database_name  = 'bankregistration';

$conn = mysqli_connect($localhost, $username, $password, $database_name);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle deposit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deposit'])) {
    $account_id = $_POST['account_id'];
    $account_type = $_POST['account_type'];
    $amount = $_POST['amount'];

    // Check if the account exists in either checking or savings
    $checkingResult = mysqli_query($conn, "SELECT * FROM checking_accounts WHERE account_id = '$account_id'");
    $savingsResult = mysqli_query($conn, "SELECT * FROM savings_accounts WHERE account_id = '$account_id'");
    
    $checkingRow = mysqli_fetch_assoc($checkingResult);
    $savingsRow = mysqli_fetch_assoc($savingsResult);

    if ($checkingRow || $savingsRow) {
        // Check if two images (jpg) are submitted
        if (isset($_FILES['image1']['name']) && isset($_FILES['image2']['name'])) {
            $image1 = $_FILES['image1']['name'];
            $image2 = $_FILES['image2']['name'];

            $image1FileType = pathinfo($image1, PATHINFO_EXTENSION);
            $image2FileType = pathinfo($image2, PATHINFO_EXTENSION);

            if ($image1FileType == 'jpeg' && $image2FileType == 'jpeg') {
                // Process deposit
                echo '';
            } else {
                echo '';
            }
        } else {
            echo '';
        }
    } else {
        echo '';
    }
}

// Function to deposit funds
function deposit($account_id, $amount, $account_type) {
    global $conn;
    
    
    // Update the balance based on the account type
    $table = ($account_type == 'checking') ? 'checking_accounts' : 'savings_accounts';
    $query = "UPDATE $table SET balance = balance + $amount WHERE account_id = '$account_id'";
    
    mysqli_query($conn, $query);
}
// Function to insert a transaction record
function insertTransaction($user_id, $transaction_id, $transaction_type, $amount, $status, $details, $accountType, $account_number) {
    global $conn;

    // Store image data in the database (you may need to adjust the column types and sizes)
    $image1Data = file_get_contents($_FILES['image1']['tmp_name']);
    $image2Data = file_get_contents($_FILES['image2']['tmp_name']);

    // Escape the binary data to prevent SQL injection
    $escapedImage1 = mysqli_real_escape_string($conn, $image1Data);
    $escapedImage2 = mysqli_real_escape_string($conn, $image2Data);

    // Insert transaction with image data
    $sql = "INSERT INTO transactions (user_id, transaction_id, transaction_type, amount, status, details, account_type, account_number) VALUES ('$user_id', '$transaction_id', '$transaction_type', '$amount', '$status', '$details', '$accountType', '$account_number')";
    $result = mysqli_query($conn, $sql);

    return $result;
}

?>

<!-- Rest of your HTML code remains the same -->


<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOIR - Check Deposit </title>
    <link rel="stylesheet" type="text/css" href="../css/deposit.css">
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
        <h2>Deposit Funds</h2>
    <form action="../webPage/deposit.php" method="post" enctype="multipart/form-data">
        <label for="account_id">Account ID:</label>
        <input type="text" name="account_id" required placeholder="Account ID" pattern="[0-9]{1,12}" title="Enter Valid Account ID">

        <label for="amount">Amount In $:</label>
        <input type="text" name="amount" required placeholder="Amount" pattern="[0-9]+(\.[0-9]{1,2})?" title="Enter Valid Amount">

        <label for="account_type">Account Type:</label>
        <select name="account_type" required>
            <option value="checking">Checking</option>
            <option value="savings">Savings</option>
        </select>
        <br>
        <br>

        <label for="image1">Front Of Check:</label>
        <input type="file" name="image1" accept="image/jpeg" required>

        <label for="image2">Back Of Check:</label>
        <input type="file" name="image2" accept="image/jpeg" required>

        <button type="submit" name="deposit">Deposit</button>
    </form>


    <?php
    // Display success or error message
    if (isset($_POST['deposit'])) {
        $checkingResult = mysqli_query($conn, "SELECT * FROM checking_accounts WHERE account_id = '$account_id'");
        $savingsResult = mysqli_query($conn, "SELECT * FROM savings_accounts WHERE account_id = '$account_id'");
        
        $checkingRow = mysqli_fetch_assoc($checkingResult);
        $savingsRow = mysqli_fetch_assoc($savingsResult);
    
        if ($checkingRow || $savingsRow) {
            // Check if two images (jpg) are submitted
            if (isset($_FILES['image1']['name']) && isset($_FILES['image2']['name'])) {
                $image1 = $_FILES['image1']['name'];
                $image2 = $_FILES['image2']['name'];
    
                $image1FileType = pathinfo($image1, PATHINFO_EXTENSION);
                $image2FileType = pathinfo($image2, PATHINFO_EXTENSION);
    
                if ($image1FileType == 'jpeg' && $image2FileType == 'jpeg') {
                    
                    $user_id = ($account_type == 'checking') ? $checkingRow['user_id'] : $savingsRow['user_id'];

                    $transaction_type = 'Deposit';
                    $status = 'Pending'; // Change to 'Pending'
                    $account_number = filter_input(INPUT_POST, 'account_id');

                    // Get the amount from the form
                    $amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);

                    // Check if the amount is 0 or negative
                    if ($amount <= 0) {
                        echo '<div class="message error">Invalid Deposit Amount</div>';
                        exit();
                    } else {
                        // Generate a unique transaction_id
                        $transaction_id = rand(10000000, 999999999);
                        $details = "Check Deposit For $$amount";
                        // Call the insertTransaction function with 'Pending' status
                        insertTransaction($user_id, $transaction_id, $transaction_type, $amount, $status, $details, $account_type, $account_number);
                        echo '<div class="message success">Deposit Is Now Pending Approval.</div>';
                    }
                } else {
                    echo '<div class="message error">Please upload valid JPG images.</div>';
                }
            } else {
                echo '<div class="message error">Please upload both front and back images of the check.</div>';
            }
        } else {
            echo '<div class="message error">Account not found</div>';
        }
    }
?>
    </div>
    </div>
</section>
<script src="../js/home.js"></script>
<footer>
&copy; 2023 NOIR CAPITAL BANK. All rights reserved.
</footer>
</body>
</html>