<?php
include('conn.php');
$query = "SELECT * FROM transactions WHERE status = 'Pending' AND transaction_type = 'Transfer'";
$result = mysqli_query($conn, $query);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['approve']) || isset($_POST['deny']))) {
    $transaction_id = $_POST['transaction_id'];

    $transaction_query = "SELECT * FROM transactions WHERE transaction_id = ?";
    $stmt = mysqli_prepare($conn, $transaction_query);
    mysqli_stmt_bind_param($stmt, 'i', $transaction_id);
    mysqli_stmt_execute($stmt);
    $transaction_result = mysqli_stmt_get_result($stmt);

    if (!$transaction_result) {
        die('Error fetching transaction details: ' . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($transaction_result);
    $account1type = $row['account_type'];
    $account1num = $row['account_number'];
    $account2type = $row['account_type2'];
    $account2num = $row['account_number2'];
    $transferAmount = $row['amount'];

    if (isset($_POST['approve'])) {
        mysqli_query($conn, "UPDATE transactions SET status = 'Approved' WHERE transaction_id = '$transaction_id'");

        // subtract from first account(the one that is transferring)
        $balance_query = "SELECT balance FROM $account1type WHERE account_id = ?";
        $stmt = mysqli_prepare($conn, $balance_query);
        mysqli_stmt_bind_param($stmt, 'i', $account1num);
        mysqli_stmt_execute($stmt);
        $balance_result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);

        if (!$balance_result) {
            die('Error fetching balance: ' . mysqli_error($conn));
        }

        $balance_row = mysqli_fetch_assoc($balance_result);
        $currentBalance = $balance_row['balance'];
        $amount = $currentBalance - $transferAmount;

        $updateQuery = "UPDATE $account1type SET balance = ? WHERE account_id = ?";
        $stmt = mysqli_prepare($conn, $updateQuery);
        mysqli_stmt_bind_param($stmt, 'ii', $amount, $account1num);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // add the amount transfered to the second account
        $balance_query = "SELECT balance FROM $account2type WHERE account_id = ?";
        $stmt = mysqli_prepare($conn, $balance_query);
        mysqli_stmt_bind_param($stmt, 'i', $account2num);
        mysqli_stmt_execute($stmt);
        $balance_result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);

        if (!$balance_result) {
            die('Error fetching balance: ' . mysqli_error($conn));
        }

        $balance_row = mysqli_fetch_assoc($balance_result);
        $currentBalance = $balance_row['balance'];
        $amount = $currentBalance + $transferAmount;

        $updateQuery = "UPDATE $account2type SET balance = ? WHERE account_id = ?";
        $stmt = mysqli_prepare($conn, $updateQuery);
        mysqli_stmt_bind_param($stmt, 'ii', $amount, $account2num);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } elseif (isset($_POST['deny'])) {
        mysqli_query($conn, "UPDATE transactions SET status = 'Denied' WHERE transaction_id = '$transaction_id'");
    }

    //the approve is bugging and needs the approve button to get clicked twice. THis exits after the first click making it so we don't resubmit
    header('Location: adminConfirmTransfer.php');
    exit();
}
?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>NOIR - Admin Panel</title>
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">


  <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/bootstrap.min.css">
<style>
  * {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
  list-style: none;
  text-decoration: none;
}

header {
  position: fixed;
  right: 0;
  top: 0;
  z-index: 1000;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 33px 9%;
  background: #808080;
}

.logo {
  font-size: 30px;
  font-weight: 700;
  color: white;
}

.navlist {
  display: flex;
}

.navlist a {
  color: white;
  margin-left: 60px;
  font-size: 15px;
  font-weight: 600;
  border-bottom: 2px solid transparent;
  transition: all .55s ease;
}

.navlist a:hover {
  border-bottom: 2px solid white;
}

.card-body {
  max-height: 430px; 
  overflow: auto;
}
.card-body::-webkit-scrollbar {
  width: 10px; 
}

.card-body::-webkit-scrollbar-thumb {
  background-color: #afacac; 
  border-radius: 8px; 
}

.card-body::-webkit-scrollbar-track {
  background-color: #808080; 
}

.card-body::-webkit-scrollbar-corner {
  background-color: #808080; 
}

th {
  position: sticky;
  top: 0;
  background-color: #302f2f;
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
  grid-template-columns: repeat(2,1fr);
  align-items:center;
  gap: 2rem;
}
section{
  padding: 0 19%;
  
}
.bank-text h5{
  font-size: 14px;
  font-weight: 400;
  color:rgb(222, 12, 12);
  margin-bottom: 10px;
  margin-top: 80px;
}
.bank-text h1{
  font-size: 70px;
  line-height:1;
  color:rgb(247, 12, 12);
  margin: 0 0 45px;
}
.bank-text h4{
  font-size: 18px;
  font-weight: 600;
  color: rgb(134, 133, 133);
  margin-top: -90px;
}
.bank-text p{
  color: rgb(123, 122, 122);
  font-size:15px;
  line-height: 1.9;
  margin-top: 0%;
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

.bank-login form {
  display: flex;
  flex-direction: column;
  max-width: 600px;
  margin-top: -10px;
  color: white;
  background-color: #808080;
  padding: 3em;
  border-radius: 8px;
  margin-bottom: 2em;
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
  background-color: #4caf50;
  color: #fff;
  padding: 0.5em;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  margin-bottom: 1.0em;
}

.bank-login form button:hover {
  background-color: #45a049;
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
      padding-top: 115px;
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
.container
{
  padding: 25px;
  border-radius: 20px;
  margin-bottom: -20px;
  position:relative;
  display: grid;
  grid-template-columns: 1fr 1fr;
}
.container .left_side
{
  position:relative;
  padding: 10px;
  color: white;
  background-color: #808080;
  width: 275px;
  height: 150px;
  border-radius: 8px;
  margin-left: -20px;
}
.container .right_side
{
  position:relative;
  padding: 10px;
  color: white;
  background-color: #808080;
  width: 300px;
  height: 150px;
  border-radius: 8px;
  margin-left: 25px;
}
.bank-text-dashboard a{
  display: block;
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
  width: 100%;
  border-collapse:separate;
  border:solid rgb(83, 81, 81) 4px;
  border-radius:6px;
}

button {
  background: #434444;
  width: 100px;
  border: none;
  outline: none;
  color: #fff;
  height: 35px;
  border-radius: 30px;
  margin-top: 0px;
  box-shadow: 0px 5px 15px 0px rgba(88, 88, 88, 0.3);
  transition: 0.5s;  
}
button:hover{
  background-color: transparent;
  border: 1px solid white;
}

form input {
  padding: 0.5em;
  margin-bottom: 1em;
  border: 1px solid #ccc;
  border-radius: 4px;
}

th, td {
  border: 1px solid #1c1b1b;
  padding: 10px;
  text-align: left;
color: white;
background-color: #302f2f;

}

.customrows{
  border: 2px solid #545252;
  padding: 15px;
  text-align: left;
color: white;
background-color: #5a5959;
}
h2 {
  color: white;
}  
.bank-text-dashboard{
  margin-top: 0px;
}
.bank-text-dashboard form {
  display: flex;
  flex-direction: column;
  margin-top: -10px;
  color: white;
  position: relative;
  text-align: center;
  
}
.bank-text-dashboard form button {
  display: block;
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
  margin-left: 120px;
  max-width: 300px;
  text-align:center;
  justify-content: center;
  margin-bottom: 30px;
}
.bank-text-dashboard form input {
  padding: 0.5em;
  margin-bottom: 1em;
  border: 1px solid #ccc;
  border-radius: 4px;
  max-width: 300px;
  margin-left:120px;
}
.approval-button {
  background: #434444;
  width: 100px;
  border: none;
  outline: none;
  color: #fff;
  height: 35px;
  border-radius: 30px;
  margin-top: 0px;
  box-shadow: 0px 5px 15px 0px rgba(88, 88, 88, 0.3);
  transition: 0.5s;  
}

.approval-button:hover {
  border: 1px solid white;
  background-color: green;
}
.deny-button {
  background: #434444;
  width: 100px;
  border: none;
  outline: none;
  color: #fff;
  height: 35px;
  border-radius: 30px;
  margin-top: 0px;
  box-shadow: 0px 5px 15px 0px rgba(88, 88, 88, 0.3);
  transition: 0.5s;  
}

.deny-button:hover {
  border: 1px solid white;
  background-color: red;
}
  body {
      min-width: 800px; 
    }
  @media screen and (max-width: 800px) {
      body {
        overflow-x: auto; 
      }
      .container{
        margin-bottom: 60px;
        margin-top: -70px;
        max-width: 860px;
      }
    }
</style>
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
     <div class="bank-text" style="margin-top: 100px;">
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
        <button type="button" onclick="openPending()" style="width: 200px;">Pending Deposits</button>
        <br>
        <br>
        <button type="button" onclick="openPendingTransfers()" style="width: 200px;">Pending Transfers</button>
      </form>
    </div>

    <div class="bank-text">
      <div class="container">
        <table  class="table table-bordered text-center" style="font-size: 10px;">
            <thead>
                <tr>
                    <th>Transaction Type</th>
                    <th>Transaction ID</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Details</th>
                    <th>Account 1</th>
                    <th>Account 1</th>
                    <th>Account 2</th>
                    <th>Account 2</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                         
                            echo '<tr>';
                            echo '<td>' . $row['transaction_type'] . '</td>';
                            echo '<td>' . $row['transaction_id'] . '</td>';
                            echo '<td>' . $row['amount'] . '</td>';
                            echo '<td>' . $row['status'] . '</td>';
                            echo '<td>' . $row['details'] . '</td>';
                            echo '<td>' . $row['account_type'] . '</td>';
                            echo '<td>' . $row['account_number'] . '</td>';
                            echo '<td>' . $row['account_type2'] . '</td>';
                            echo '<td>' . $row['account_number2'] . '</td>';
                            echo '<td>';
                            echo '<form method="post" action="">';
                            echo '<input type="hidden" name="transaction_id" value="' . $row['transaction_id'] . '">';
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

    function openPendingTransfers() {
      window.location.href = "adminConfirmTransfer.php";
    }
  </script>
  <script src="home.js"></script>
  <footer>
    &copy; 2023 NOIR CAPITAL BANK. All rights reserved.
  </footer>
</body>
</html>