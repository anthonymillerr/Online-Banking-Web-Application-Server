<!DOCTYPE html>
<html>
<head>
<?php
include 'conn.php';
require 'mail.php';

$logged_in = false;
$userExist = false;
if (isset($_POST["username"]) && isset($_POST["password"])) {
    if ($_POST["username"] && $_POST["password"]) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        // create connection
        $conn = mysqli_connect("localhost", "root", "", "bankregistration");
        // check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        // select users password from their username
        $sql = "SELECT * FROM bank_users WHERE username = '$username'";
        $results = mysqli_query($conn, $sql);

        if ($results) {
            $userExist = true;
            $row = mysqli_fetch_assoc($results);
            if ($row["password1"] === $password) {
                $logged_in = true;
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['totalamount'] = $row['totalamount'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['phonenumber'] = $row['phonenumber'];
                $_SESSION['debitcard'] = $row['debitcard'];
                $_SESSION['password1'] = $row['password1'];
                $_SESSION['Pin'] = $row['Pin'];
                
                //prepare everything so that we can submit it to the database
                $vars['code'] =  rand(10000,99999);
                $vars['expires'] = (time() + (60 * 10));
                $vars['email'] = $_SESSION['email'];

                $sql = "INSERT INTO verify (code, expires, email) VALUES ('" . $vars['code'] . "', '" . $vars['expires'] . "', '" . $_SESSION['email'] . "')";
                $results = mysqli_query($conn, $sql);

                $message = "<p style='font-size: 20px;'><strong>Your code is:</strong> <span style='font-weight: bold; font-size: 40px; background-color: #D0D0D0;'>" . $vars['code'] . "</span></p>";
                $subject = "Email verification";
                $recipient = $vars['email'];
                
                // send the mail to the user requesting to sign in

                send_mail($recipient, $subject, $message);

                
            }
        }
        mysqli_close($conn); // close connection
    }
}

?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NOIR - Login</title>

    <link rel="stylesheet" type="text/css" href="login.css">

    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400&display=swap" rel="stylesheet">
    <style>


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
            <li><a href="homepage.html">Home</a></li>
            <li><a href="atm.php">ATM</a></li>
            <li><a href="contact1.php">Contact</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="loginAdmin.php">Staff Login</a></li>
        </ul>
        <div class="bx bx-menu" id="menu-icon"></div>
    </header>

    <section class="bank">
        <div class="bank-text">
            <h5>Sign On To Manage Your Accounts</h5>
            <h4>How Can We Assist You?</h4>
            <h1>Keep Track Of All Your Financials, Smarter.</h1>
            <p>Open A Checkings Or Savings Account Today!</p>
        </div>
        <div class="bank-login">
            <form action="login.php" method="post" style= "margin-top: 50px">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required placeholder="Enter Username" pattern="[a-zA-Z0-9_]{8,20}" title="Enter Valid Username">

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required placeholder="Enter Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Enter Valid Password">

                <button type="submit" style="margin-left: 10px; ">Log In</button>
                <?php

                if ($logged_in) {
                    header("Location: verify.php");
                    exit();
                } else if ($userExist) {
                    echo '<script type="text/javascript">window.onload = function () { alert("Username and/or Password Is Incorrect!"); } </script>';
                }
                ?>
                <button onclick="openPopOutWindow()" style="margin-left: 10px;">No Account? Sign Up Now</button>
            </form>
        </div>
    </section>
    <div class="icons">
    </div>

    <script>
        function openPopOutWindow() {
            var url = 'bankregistration.html'; // Replace with the actual URL
            var width = 550;
            var height = 550;
            var left = (screen.width - width) / 2;
            var top = (screen.height - height) / 2 + -60;

            // Open a new pop-out window
            window.open(url, 'PopOutWindow', 'width=' + width + ',height=' + height + ',left=' + left + ',top=' + top);
        }
    </script>


    <script src="https://unpkg.com/scrollreveal"></script>

    <script src="home.js"></script>
    <footer>
        &copy; 2023 NOIR CAPITAL BANK. All rights reserved.
    </footer>
</body>

</html>