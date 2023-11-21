<?php
$submitted = false;
if (isset($_POST["username"]) && isset($_POST["phonenumber"]) && isset($_POST["email"]) && isset($_POST["usermessage"]) && isset($_POST["inquiry"])) {

    if ($_POST["username"] && $_POST["phonenumber"] && $_POST["email"] && $_POST["usermessage"] && $_POST["inquiry"]) {
        $name = $_POST["username"];
        $phonenumber = $_POST["phonenumber"];
        $email = $_POST["email"];
        $message = $_POST["usermessage"];
        $inquiry = $_POST["inquiry"];

        // create connection
        $conn = mysqli_connect("localhost", "root", "", "bankregistration");
        // check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // user contact
        $sql = "INSERT INTO contact_users(`name`, `phone`, `email`, `message`, `inquiry`) VALUES ('$name','$phonenumber','$email','$message','$inquiry')";

        $results = mysqli_query($conn, $sql);

        if ($results) {
            $submitted = true;
        } else {
            echo mysqli_error($conn);
        }

        mysqli_close($conn); // close connection
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Contact Us</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,400;1,200&display=swap" rel="stylesheet">
    <style>
    .container {
    margin: 50px auto;
    width: 80%;
    padding: 10px;
  }
  
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
  
  navlist a:hover {
    border-bottom: 2px solid white;
  }
  
  #menu.icon {
    color: white;
    font-size: 30px;
    z-index: 10001;
    cursor: pointer;
    display: none;
  }
  
  footer {
    background: #555;
    color: #fff;
    padding: 1em;
    text-align: center;
    bottom: 0;
    width: 100%;
  }
  
  body {
    background: #f2f2f2;
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
  
  }
  
  .contact-box {
    background: white;
    display: flex;
  }
  
  .contact-left {
    flex-basis: 60%;
    padding: 40px 60px;
  }
  
  .contact-right {
    flex-basis: 40%;
    padding: 40px 40px;
    background: #555;
  }
  
  h1 {
    margin-bottom: 10px;
  }
  
  .container p {
    margin-bottom: 40px;
  }
  
  .input-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
  }
  
  .input-row .input-group {
    flex-basis: 45%;
  }
  
  input {
    width: 100%;
    border: none;
    border-bottom: 1px solid #ccc;
    outline: none;
    padding-bottom: 6px;
  }
  
  textarea {
    width: 100%;
    border: 1px solid #ccc;
    outline: none;
    padding: 10px;
    box-sizing: border-box;
  }
  
  label {
    margin-bottom: 6px;
    display: block;
    color: #333
  }
  
  button {
    background: #333;
    width: 100px;
    border: none;
    outline: none;
    color: #fff;
    height: 35px;
    border-radius: 30px;
    margin-top: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
  
  .contact-left h3 {
    color: #333;
    font-weight: 600;
    margin-bottom: 10px;
  }
  
  .contact-right h3 {
    font-weight: 600;
    margin-bottom: 10px;
  }

  .popup{
    width: 450px;
    background: #555;
    border-radius: 6px;
    position: absolute;
    top: 0%;
    left: 50%;
    transform: translate(-50%,-50%) scale(0.1);
    text-align: center;
    padding: 0 30px 30px;
    color: #fff;
    visibility: hidden;
    transition: transform 0.4s, top 0.4s;
    border: 6px solid transparent; 

     /* Create a linear gradient border */
    border-image: linear-gradient(245.59deg, #555 0%, #333 28.53%, #222 75.52%);
    border-image-slice: 1;
    border-image-width: 6px;
  }

  .popup img{
    width: 200px;
    margin-top: -50px;
    border-radius: 50%
    
  };

  .popup h2{
    font-size: 38px;
    font-weight: 500;
    margin: 30px 0 10px;
  }

  .open-popup{
    visibility: visible;
    top: 50%;
    transform: translate(-50%,-50%)scale(1);
  }
  </style>
</head>

<body>
    <header>
        <a href "#" class="logo">NOIR CAPITAL BANK</a>

        <ul class="navlist">
            <li><a href="homepage.html">Home</a></li>
            <li><a href="login.php">Sign In</a></li>
            <li><a href="atm.php">ATM</a></li>
            <li><a href="contact1.php">Contact</a></li>
            <li><a href="about.html">About</a></li>
        </ul>
        <div class="bx bx-menu" id="menu-icon"></div>
    </header>

    <br>
    <br>
    <br>


    <div class="container">
        <h1>Contact Us</h1>
        <p>Feel free to contact us through our email and/or number, and a message of your inquiry.</p>
        <!--<form  method="post"> 
      <br>
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" required>
      <br>
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>
       <br>
      <label for="message">Message:</label>
      <textarea id="message" name="message" required></textarea>

      <input type="submit" value="Submit">
  </div>
    -->

        <div class="contact-box">
            <div class="contact-left">
                <h3>Ask a Question!</h3>
                <form action="contact1.php" method="post">
                    <div class="input-row">
                        <div class="input-group">
                            <label>Name </label>
                            <input type="text" placeholder="Name" name="username" required>
                        </div>


                        <div class="input-group">
                            <label>Phone </label>
                            <input type="text" placeholder="415-0000-0000" name="phonenumber" required>
                        </div>
                    </div>


                    <div class="input-row">
                        <div class="input-group">
                            <label>Email </label>
                            <input type="email" placeholder="sjsu@sjsu.edu.com" name="email" required>
                        </div>

                        <div class="input-group">
                            <label>Message</label>
                            <input type="text" placeholder="Message" name="usermessage" required>
                        </div>
                    </div>

                    <label>Inquiry</label>
                    <textarea rows="6" placeholder="Input Message" required name="inquiry"> </textarea>

                    <button type="submit">Submit</button>

                    <?php
                    if ($submitted) {
                        echo '<script type="text/javascript">window.onload = function () { let popup = document.getElementById("popup");
                            popup.classList.add("open-popup"); }</script>';
                    }
                    ?>
                </form>


                <div class="popup" id="popup">
                    <img src="bluetick.png">
                    <h2>Thank You!</h2>
                    <p>Contact Information been submited</p>
                    <button onclick="closePopup()">okay</button>
                </div>
            </div>


            <div class="contact-right" style="color: white">
                <h3>Contact Information</h3>
                <table>
                    <tr>
                        <td>Email: </td>
                        <td>sjsu@sjsu.edu</td>

                    </tr>

                    <tr>
                        <td>Number: </td>

                        <td>415-0000-000</td>
                        <br>
                    </tr>

                    <tr>
                        <td>Address: </td>
                        <td>1 Washington Sq, San Jose, CA 95192</td>
                        <br>
                    </tr>

                </table>

            </div>


        </div>
        <script src="script.js"></script>
        <script>
            function closePopup() {
                let popup = document.getElementById("popup");
                popup.classList.remove("open-popup");
            }
        </script>
        <footer class="footer">
            &copy; 2023 NOIR CAPITAL BANK. All rights reserved.
        </footer>
</body>

</html>