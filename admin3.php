<!-- Admin Page 3 that shows Savings-->
<!-- Admin Page  that shows all current users of the bank-->
<?php
require_once('conn.php');
$query = "select * from savings_accounts";
$result = mysqli_query($conn, $query);
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
    <style>
    @media screen and (max-width: 1170px) {
        .bank-text{
          margin-top: 80px;
        }
        .container {
        margin-bottom: 60px;
        margin-top: -120px;
      }
    }
  @media screen and (max-width: 990px) {
        .bank-text{
          margin-top: 80px;
        }
        .container {
        margin-bottom: 60px;
        margin-top: -120px;
      }
    }
    @media screen and (max-width: 990px) {
        .navlist {
        height: 130px;
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
    <section class="bank" >
        <div class="bank-text" style="margin-top: 100px;">
            <h4>Admin Page</h4>
            <p>User Savings</p>
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

        <div class="bank-text" style="max-width: 450px;">
      <div class="container" style="max-width: 375px; ">
        <div class="row mt-5" style="max-width: 400px;">
          <div class="col" style="max-width: 7;">
            <div class="card-mt-5" style="max-width: 400px;">
              <div class="card-header" style="max-width: 700px;">
                                <h2 class="display">Savings Accounts</h2>
                            </div>
                            <div class="card-body">
                            <table class="table table-bordered text-center" style="font-size: 12px;">
                                    <tr>
                                        <td>Account ID</td>
                                        <td>User ID</td>
                                        <td>Balance</td>
                                    </tr>
                                    <tr>
                                        <?php
                                        while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                            <td class="customrows"><?php echo $row['account_id'] ?></td>
                                            <td class="customrows"><?php echo $row['user_id'] ?></td>
                                            <td class="customrows"><?php echo $row['balance'] ?></td>
                                    </tr>
                                <?php
                                        }
                                ?>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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