<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/conn.php';
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
//function transferFunds($source_user_id, $source_account_id, $destination_user_id, $destination_account_id, $amount, $account_type) {
//    global $conn;

    // Check the balance of the source account
 //   $sourceBalanceResult = mysqli_query($conn, "SELECT balance FROM $account_type WHERE user_id = '$source_user_id' AND account_id = '$source_account_id'");
 //   $sourceBalanceRow = mysqli_fetch_assoc($sourceBalanceResult);

 //   if (!$sourceBalanceRow || $sourceBalanceRow['balance'] <= 0 || $sourceBalanceRow['balance'] < $amount) {
        // Insufficient funds or invalid source account
 //       echo '<div class="message error">Invalid account(s) or insufficient funds</div>';
 //       return;
 //   }

    // Deduct funds from the source account
 //   $queryDeduct = "UPDATE $account_type SET balance = balance - $amount WHERE user_id = '$source_user_id' AND account_id = '$source_account_id'";
 //   mysqli_query($conn, $queryDeduct);

    // Add funds to the destination account
 //   $queryAdd = "UPDATE $account_type SET balance = balance + $amount WHERE user_id = '$destination_user_id' AND account_id = '$destination_account_id'";
 //   mysqli_query($conn, $queryAdd);

    // Output success message
 //   echo '<div class="message success">Funds transfer successful</div>';
//}
// Function to insert a transaction record

function insertTransaction($user_id, $transaction_id, $transaction_type, $amount, $status, $details,$account_type1,$account_number1, $account_type2, $account_number2) {
    global $conn;

    $sql = "INSERT INTO transactions (user_id, transaction_id, transaction_type, amount, status, details, account_type, account_number, account_type2, account_number2) VALUES ('$user_id', '$transaction_id', '$transaction_type', '$amount', '$status', '$details', '$account_type1', '$account_number1', '$account_type2', '$account_number2')";
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
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400&display=swap" rel="stylesheet">
    <style>

.container {
  max-width: 750px;
  max-height: 750px;
  margin: 50px auto;
  background-color: #808080;
  padding: 10px;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  color: white;
  text-align: center;
  text-transform: uppercase;
}

h2 {
  color: white;
}

label {
  display: block;
  margin-top: 10px;
  color: white;
}

input {
  width: 100%;
  padding: 10px;
  margin: 5px 0 20px;
  box-sizing: border-box;
  border: 1px solid #ccc;
  border-radius: 4px;
}

button {
  justify-content: center;
  min-width:200px;
  color: white;
  transition: all .55s ease;
  text-transform: uppercase;
  border:1px white;
  background-color: #555;
  color: #fff;
  padding: 0.5em;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background: #3cb043;
  border: 1px solid white;
  transform: translateY(-2px);
}

.message {
  padding: 10px;
  text-transform:uppercase;
}

.success {
  background-color: #4caf50;
  color: #fff;
}

.error {
  background-color: #f44336;
  color: #fff;
}
*{
padding:0;
margin: 0;
box-sizing:border-box;
font-family: 'Poppins', sans-serif;
list-style:none;
text-decoration: none;
}
header{
position:fixed;
right: 0;
top: 0;
z-index:1000;
width :100%;
display: flex;
align-items: center;
justify-content: space-between;
padding: 33px 9%;
background: #808080;
}

.logo{
font-size: 30px;
font-weight: 700;
color: white; 
}
.navlist{
display:flex;
}
.navlist a{
color: white;
margin-left: 60px;
font-size:15px;
font-weight: 600;
border-bottom: 2px solid transparent;
transition: all .55s ease;
}
.navlist a:hover{
border-bottom: 2px solid white;
}
#menu.icon{
color:white;
font-size: 30px;
z-index: 10001;
cursor: pointer;
display:none;
}
.bank{
height: 100%;
width: 100%;
min-height:100vh;
background: linear-gradient(245.59deg, #555 0%, #333 28.53%, #222 75.52%);
position:relative;
display:grid;
grid-template-columns: repeat(1,1fr);
align-items:center;
gap: 2rem;
}
section{
padding: 0 19%;

}
.bank-text h5{
font-size: 14px;
font-weight: 400;
color:white;
margin-bottom: 10px;
margin-top: 80px;
}
.bank-text h1{
font-size: 70px;
line-height:1;
color:white;
margin: 0 0 45px;
margin-top: 100px;
}
.bank-text h4{
font-size: 35px;
font-weight: 600;
color: white;
margin-bottom: 10px;
}
.bank-text p{
color: white;
font-size:15px;
line-height: 1.9;
margin-bottom: 40px;
}
.bank-img img{
margin-top: 50px;
width: 600px;
height: auto;
}
.bank-login form{
margin-top: 5px;
width: 600px;
height: auto;
}
.bank-text a{
display: incline-block;
color: white;
background: #333;
border: 1px solid transparent;
padding: 12px 30px;
line-height: 1.4;
font-size: 14px;
font-weight: 500;
border-radius: 30px;
text-transform:uppercase;
transition: all .55s ease;
}
.bank-text a:hover{
background: transparent;
border: 1px solid white;
transform: translateX(8px);
}
.bank-text a.ctaa{
background: transparent;
border: 1 px solid white;
margin-left: 20px; 
}
.bank-text a.ctaa i{
vertical-align: middle;
margin-right: 5px;
}
.icons i{
display: block;
margin: 26px 0;
font-size: 24px;
color: white;
transition: all .50s ease;
}
.icons i:hover{
color: #555;
transform: translateY(-5px);
}
.scroll-down{
position: absolute;
bottom: 6%;
right: 9%;
}
.scroll-down i{
display: block;
padding: 12px;
font-size: 25px;
color: white;
background: #555;
border-radius: 30px;
transition: all .50s ease
}
.scroll-down i:hover{
transform: translate(-5px);
}
.bank-login{
text-align: center;
}
.bank-login form {
display: flex;
max-width: 100px;
margin-top: -35px;
color: white;
border-radius: 8px;
justify-content: center;
} 
.bank-login form label {
margin-bottom: 0.5em;
}

.bank-login form input {
padding: 0.5em;
margin-bottom: 1em;
border: 1px solid #ccc;
border-radius: 4px;
}

.bank-login form button {
background-color: #555;
color: #fff;
padding: 0.5em;
border: none;
border-radius: 4px;
cursor: pointer;
margin-top: 20px;
margin-bottom:-40px;
transition: all .55s ease;
margin-left: 10px;
}

.bank-login form button:hover {
background: #990f02;
border: 1px solid white;
transform: translateY(-2px);
}
@media(max-width: 1535px){
header{
padding: 15px 3%;
transition: .2s;
}
.icons{
padding: 0 3%;
transition: .2s;
}
.scroll-down{
right: 3%;
transition: .2s;
}
}
@media (max-width: 1460px){
section{
padding: 0 12%;
transition: .2s;
}
}
@media (max-width: 1340px){
.bank-img img{
width:100%;
height: auto;
}
.bank-login form{
width:100%;
height: auto;
}
.bank-text h1{
font-size: 75px;
margin: 0 0 30px;
}
.bank-text h5{
margin-bottom: 25px;
}
}
@media(max-width:1195px){
section{
padding: 0 3%;
transition: .2s;
}
.bank-text{
padding-top: 0px;
}
.bank-img{
text-align: center;
}
.bank-img img{
width: 560px;
height: auto;
}
.bank-login{
text-align: center;
}
.bank-login form{
width: 560px;
height: auto;
}
.bank{
height: 100%;
gap: 1rem;
grid-template-columns: 1fr;
}
.bank-text-dashboard{
margin-left: -45px;
margin-top: -90px;
}
.icons{
display: none;
}
.scroll-down{
display: none;
}
}
@media (max-width:990px){
#menu-icon{
display: block;
}
.navlist{
position: absolute;
top: 100%;
right: -100%;
width: 200px;
height: 30vh;
background: #707070;
display: flex;
align-items:center;
flex-direction: column;
padding: 30px 20px;
border-top-left-radius: 10px;
border-bottom-left-radius: 10px;
transition: all .55s ease;
}
.navlist a{
display: block;
margin: 7px 0;
margin-left: 0;
margin-top: -5px;
}
.navlist.open{
right:0;
}

}
@media (max-width:680px){
.bank-img img{
margin-top: 5px;
width: 100%;
height: auto;
}
.bank-login form{
margin-top: 5px;
width: 100%;
height: auto;
}

}
.bank-account {
color: white;
background-color: #808080;
padding: 20px;
border-radius: 8px;
box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
margin-bottom: 20px;
max-width: 600px;
}
.bank-account h4, .bank-account p {
margin-bottom: 0px;
margin-top: -10px;
}

.bank-text-dashboard a{
color: white;
background: #808080;
border: 1px solid transparent;
padding: 12px 30px;
line-height: 1.4;
font-size: 14px;
font-weight: 500;
border-radius: 30px;
text-transform:uppercase;
transition: all .25s ease;
margin-left: 180px;
max-width: 300px;
text-align:center;
justify-content: center;
}
.bank-text-dashboard a:hover{
background: transparent;
border: 1px solid white;
transform: translateX(8px);
}
footer {
background-color: #808080;
color: #fff;
padding: 1em;
text-align: center;
bottom: 0;
width: 100%;
}
table {
border-collapse: collapse;
width: 100%;
color: white;
}

th, td {
border: 1px solid #ddd;
padding: 10px;
color: white;
background-color: #808080;
max-height: 20px;
text-align: center;
justify-content: center;
}
h2 {
color: white;
} 
form{
margin-top:20px;
color: white;
text-align:center;
font-size: 13px;
}


.bank-text-dashboard{
margin-top: 280px;
}
.bank-text-dashboard form button:hover{
background: #3cb043;
border: 1px solid white;
transform: translateY(-2px);
}

    @media screen and (max-width: 1300px) {
      .bank-login {
        margin-top: -60px; 
      }
    }
    @media screen and (max-width: 1100px) {
      .bank-login {
        margin-top: -60px; 
      }
    }
    @media screen and (max-width: 990px) {
        .navlist {
        height: 180px;
      }
    }
    @media screen and (max-width: 750px) {
      .bank-login {
        margin-top: -60px;
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
  <div class="bank-text">
    <div class="container">
    <h2>Transfer Funds</h2>
    <form action="transfer.php" method="post">
        <label for="source_user_id">Source User ID:</label>
        <input type="text" name="source_user_id" required placeholder="Source User ID" pattern="\d{12}" title="Source User ID Is 12 Digits">

        <label for="source_account_id">Source Account ID:</label>
        <input type="text" name="source_account_id" required placeholder="Source Account Number" pattern="[0-9]{1,12}" title="Enter Valid Account ID">

        <label for="account_type1">Account 1 Type:</label>
        <select name="account_type1" required>
            <option value="checking_accounts">Checking</option>
            <option value="savings_accounts">Savings</option>
        </select>

        <label for="destination_user_id">Destination User ID:</label>
        <input type="text" name="destination_user_id" required placeholder="Destination User ID" pattern="\d{12}" title=" Destination User ID Is 12 Digits">

        <label for="destination_account_id">Destination Account ID:</label>
        <input type="text" name="destination_account_id" required placeholder="Destination Account Number" pattern="[0-9]{1,12}" title="Enter Valid Account ID">

        <label for="account_type2">Account 2 Type:</label>
        <select name="account_type2" required>
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
   if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['transfer']) && ($_POST['source_user_id'] == $user_id)) {
    $source_user_id = isset($_POST['source_user_id']) ? $_POST['source_user_id'] : '';
    $source_account_id = isset($_POST['source_account_id']) ? $_POST['source_account_id'] : '';
    $destination_user_id = isset($_POST['destination_user_id']) ? $_POST['destination_user_id'] : '';
    $destination_account_id = isset($_POST['destination_account_id']) ? $_POST['destination_account_id'] : '';
    $amount = isset($_POST['amount']) ? $_POST['amount'] : '';
    $account_type1 = isset($_POST['account_type1']) ? $_POST['account_type1'] : ''; 
    $account_type2 = isset($_POST['account_type2']) ? $_POST['account_type2'] : ''; 

    // Check if the source and destination accounts exist
    $sourceAccountResult = mysqli_query($conn, "SELECT * FROM $account_type1 WHERE user_id = '$source_user_id' AND account_id = '$source_account_id'");
    $destinationAccountResult = mysqli_query($conn, "SELECT * FROM $account_type2 WHERE user_id = '$destination_user_id' AND account_id = '$destination_account_id'");

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
      //transferFunds($source_user_id, $source_account_id, $destination_user_id, $destination_account_id, $amount, $account_type);
      // Log the deposit transaction
      $transaction_type = 'Transfer';
      $status = 'Pending';
      // Generate a unique transaction_id
      $transaction_id = rand(10000000, 999999999);
      $details = "Transfer: FROM User ID: $source_user_id and Account ID: $source_account_id TO User ID: $destination_user_id and Account ID: $destination_account_id";
      insertTransaction($user_id, $transaction_id, $transaction_type, $amount, $status, $details, $account_type1, $source_account_id,$account_type2, $destination_account_id);
      echo '<div class="message success">Transfer Is Now Pending Approval.</div>';
  } 
}else if(isset($_POST['transfer']) && ($_POST['source_user_id'] != $user_id)){
  echo '<div class="message error">Transfer Error(Make Source ID IS from logged in user)</div>';
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
