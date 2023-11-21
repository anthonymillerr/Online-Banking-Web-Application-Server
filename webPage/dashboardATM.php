
<!DOCTYPE html>
<html>
<head>
<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT']. '/conn.php';
// Check if the user is logged in
if (!isset($_SESSION['debitcard'])) {
  // Redirect to the login page if not logged in
  header("Location: atm.php");
  exit();
}
?>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>NOIR - ATM</title>

  <link rel="stylesheet" type="text/css" href="atm.css">

  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  

  <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400&display=swap" rel="stylesheet">

</head>

<body>
  <header>
    <a href="homepage.html" class="logo">NOIR CAPITAL BANK</a>

    <ul class="navlist">
      <li><a href="homepage.html">Home</a></li>
      <li><a href="login.php">Sign In</a></li>
      <li><a href="contact1.php">Contact</a></li>
      <li><a href="about.html">About</a></li>
    </ul>
    <div class="bx bx-menu" id="menu-icon"></div>
  </header>


  <section class="bank2">
    <div class="atm">
      <h2>Virtual ATM</h2>

    <div class="card-box" id="cardBox">
      <div class="card-inner">
        <div class="card-front">
          <img src="map.png" class="map">
          <div class="cardrow" style = "margin-left:350px">
            <img src="visa.png" width="80px">
          </div>
          <div class="cardrow" style = "margin-top: 65px">
            <img src="chip.png" width="60px">
          </div>
          <div class="cardrow number" style = "margin-top: 10px">
            <?php
            // Display the last 4 digits of the 'debitcard' number
            $lastFourDigits = substr($_SESSION['debitcard'], -4);
            ?>
            <p>****</p>
            <p>****</p>
            <p>****</p>
            <p><?php echo $lastFourDigits; ?></p>
          </div>
          <div class="cardrow owner">
          <?php
            $cardOwnerFirst = $_SESSION['firstName'];
            $cardOwnerLast = $_SESSION['lastName'];
          ?>
            <p><?php echo $cardOwnerFirst," ",$cardOwnerLast; ?></p>
            <p>VALID UNTIL</p>
          </div>
          <div class="cardrow expire">
          <?php
            // Display the last 4 digits of the 'debitcard' number
            $cardExpire = $_SESSION['debitcard_expire'];
          ?>
            <p> </p>
            <p><?php echo $cardExpire; ?></p>
          </div>
        </div>

        <div class="card-back">
          <img src="map.png" class="map">
          <div class="blackbar">
            <br><br><br>
            <div class="cardrow cvv">
            <?php
            // Display the last 4 digits of the 'debitcard' number
            $cardCVV = $_SESSION['debitcard_cvv'];
          ?>
              <div>
                <img src="pattern.png">
              </div>
              <p><?php echo $cardCVV; ?></p>
            </div>
            <div class="cardrow cardtext">
              <p>Empowering Your Financial Noir: Noir Capital Bank - 
                Your Gateway to Secure Transactions.</p>
            </div>
            <div class="cardrow">
              <p></p>
              <img class="visa" src="visa.png" width="80px">
            </div>
          </div>
        </div>
      </div>
    </div>


      <h3 id="greetingMessage"></h3>
      <div class="row">
      <button id="withdrawBtn" >WITHDRAW</button>
      <script>
    document.addEventListener("DOMContentLoaded", function () {
      // Add event listener for the Withdraw button
      document.getElementById("withdrawBtn").addEventListener("click", function () {
      var url = 'withdraw.php';
      var width = 550;
      var height = 550;
      var left = (screen.width - width) / 2;
      var top = (screen.height - height) / 2 + -60;

      window.open(url, "Withdrawal Window", 'width=' + width + ',height=' + height + ',left=' + left + ',top=' + top);
});
    });
  </script>
      <button id="balanceInquiryBtn">BAL INQUIRY</button>
      <script>
    document.addEventListener("DOMContentLoaded", function () {
      // Add event listener for the Withdraw button
      document.getElementById("balanceInquiryBtn").addEventListener("click", function () {
      var url = 'balance.php';
      var width = 550;
      var height = 550;
      var left = (screen.width - width) / 2;
      var top = (screen.height - height) / 2 + -60;

      window.open(url, "Balance Window", 'width=' + width + ',height=' + height + ',left=' + left + ',top=' + top);
});
    });
  </script>
      <button id="changePinBtn">CHANGE PIN</button>
      <script>
    document.addEventListener("DOMContentLoaded", function () {
      // Add event listener for the Withdraw button
      document.getElementById("changePinBtn").addEventListener("click", function () {
      var url = 'changePin.php';
      var width = 550;
      var height = 1000;
      var left = (screen.width - width) / 2;
      var top = (screen.height - height) / 2 + -60;

      window.open(url, "Balance Window", 'width=' + width + ',height=' + height + ',left=' + left + ',top=' + top);
});
    });
  </script>
      </div>
      <div class="row">
      <button id="cancelBtn">CANCEL TRANSACTION</button>
      </div>
      <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Add event listener for the Cancel Transaction button
            document.getElementById("cancelBtn").addEventListener("click", function () {
                // Redirect to the logoutATM.php page
                window.location.href = 'logoutATM.php';
            });
        });
    </script>
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
