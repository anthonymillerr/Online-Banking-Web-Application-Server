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
$transaction_id = rand(10000000, 999999999);
// Function to insert a new transaction
function insertTransaction($user_id, $transaction_id, $transaction_type, $amount, $status) {
    global $conn;

    $sql = "INSERT INTO transactions (user_id, transaction_id, transaction_type, amount, status) VALUES ('$user_id', '$transaction_id', '$transaction_type', '$amount', '$status')";
    $result = mysqli_query($conn, $sql);

    return $result;
}

// Function to retrieve transactions for a specific user
function getTransactions($user_id) {
    global $conn;

    $sql = "SELECT * FROM transactions WHERE user_id = '$user_id' ORDER BY transaction_date DESC";
    $result = mysqli_query($conn, $sql);

    return $result;
}
?>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>NOIR - Transaction History</title>

  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  

  <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400&display=swap" rel="stylesheet">

  <style> 
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
}
.bank-text h4{
    font-size: 18px;
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
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    width: 600px;
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
    border-collapse: collapse;
    width: 100%;
    color: white;
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: center;
    color: white;
    background-color: #808080;
}
h2 {
    color: white;
    text-align: center;
}  

.atm-screen {
    background-color: #6e6e6e;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    margin: auto;
    text-align: center;
    font-size: 18px;
    color: #fff;
  }
  
  .input-field {
    margin-bottom: 15px;
  }
  
  input {
    padding: 8px;
    width: 100%;
    box-sizing: border-box;
    margin-top: 5px;
  }
  
  button {
    background-color: #46a349;
    color: #fff;
    padding: 10px 20px;
    border: 1px;
    border-radius: 5px;
    cursor: pointer;
    margin-right: 16px;
    margin-bottom: 5px;
    transition: 0.5s;
  }
  
  button:hover {
    background-color: #3b8a3e;
  }

  .atm h2 {
    padding-top: 50px;
    font-size: 25px;
    text-align: center;
    padding-bottom: 10px;
    columns: #fff;
  }

  #back, #cancel {
    margin: auto;
    display:block;
  }

  #back, #cancel, #but {
    border: 1px solid #808080;
    background-color: #808080;
    transition: 0.5s;  
    margin-bottom: 16px;
}

  #back:hover, #cancel:hover, #but:hover{
    background-color: transparent;
    border: 1px solid white;
  }

  body .bank2 {
    padding: 0;
    height: 100vh;
    background: linear-gradient(245.59deg, #555 0%, #333 28.53%, #222 75.52%);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }

  .buttons-container {
    display: none;
  }

  .buttons-container h2 {
    margin-bottom: 10px;
  }

  .row {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
  }

  .atm h3 {
    padding-top: 10px;
    font-size: 20px;
    text-align: center;
    padding-bottom: 10px;
    color: #fff;
  }

  .card-box {
    height: 300px;
    width: 500px;
    cursor: pointer;
    perspective: 1000px;
  }

  .card-inner {
    height: 100%;
    width: 100%;
    position: relative;
    transition: 1s;
    transform-style: preserve-3d;
  }
  
  .card-front, .card-back {
    width: 100%;
    height: 100%;
    background-image: linear-gradient(45deg, #00c71bb6, #2c6fffde);
    position: absolute;
    top: 0;
    left: 0;
    padding: 20px 30px;
    border-radius: 15px;
    overflow: hidden;
    z-index: 1;
    backface-visibility: hidden;
  }

  .cardrow{
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .map {
    width: 100%;
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0.3;
    z-index: -1;
  }

  .number {
    font-size: 34px;
    margin-top: 60px;
    color: white;
  }

  .owner {
    font-size: 20px;
    margin-top: 40px;
    color: white;
  }

  .expire {
    color: white;
  }

  .blackbar {
    background: black;
    margin-left: -30px;
    margin-right: -30px;
    height: 60px;
    margin-top: 10px;
  }

  .cvv {
    margin-top: 20px;
  }

  .cvv div {
    flex: 1;
  }

  .cvv img{
    padding-left: 20px;
     width: 100%;
     display: block;
     line-height: 0;
  }

  .cvv p {
    background: white;
    color: black;
    font-size: 22px;
    padding: 8px 20px 8px 10px;
    margin-right: 25px;
  }

  .cardtext {
    margin-top: 30px;
    font-size: 14px;
    color: white;
    padding: 0px 20px;
  }

  .visa {
    margin-top: -10px;
    margin-right: 25px;
  }

  .card-back {
    transform: rotateY(180deg);
  }

  .card-box:hover .card-inner {
    transform: rotateY(-180deg);
  }

  .row #but {
    width: 150px; 
    margin: 0 5px; 
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
          <h1>Transaction History</h1>
          <h2>Previous Transactions</h2>
          
          <?php
          $user_id = $_SESSION['user_id'];

          // Display transactions
          $transactions = getTransactions($user_id);

          if (mysqli_num_rows($transactions) > 0) {
              echo '<table>';
              echo '<tr><th>Transaction ID</th><th>Type</th><th>Amount</th><th>Status</th><th>Date</th><th>Details</th></tr>';

              while ($row = mysqli_fetch_assoc($transactions)) {
                  echo '<tr>';
                  echo '<td>' . $row['transaction_id'] . '</td>';
                  echo '<td>' . $row['transaction_type'] . '</td>';
                  echo '<td>' . $row['amount'] . '</td>';
                  echo '<td>' . $row['status'] . '</td>';
                  echo '<td>' . $row['transaction_date'] . '</td>';
                  echo '<td>' . $row['details'] . '</td>';
                  echo '</tr>';
              }

              echo '</table>';
          } else {
              echo '<p>No Transactions Yet!</p>';
          }
          ?>
        
        </div>

  </section>

  <div class="icons">

  </div>

  <script src="home.js"></script>
  <footer>
    &copy; 2023 NOIR CAPITAL BANK. All rights reserved.
  </footer>
</body>

</html>
