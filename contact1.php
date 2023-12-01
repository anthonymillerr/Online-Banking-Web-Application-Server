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
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

  <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400&display=swap" rel="stylesheet">
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
    min-width: 780px;
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
    min-width: 400px;
  }
  
  h1 {
    margin-bottom: 10px;
  }
  
  .container p {
    margin-bottom: 40px;
  }
  
  .input-row {
    display: flex;
    
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
        height: 180px;
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
                <h3>Ask a Question!1</h3>
                <form action="contact1.php" method="post">
                    <div class="input-row">
                        <div class="input-group" style="min-width: 125px; ">
                            <label>Name </label>
                            <input type="text" placeholder="Name" name="username" required pattern="[A-Za-z0-9]{1,20}" title="First Name Should Only Include Letters/Numbers">
                        </div>


                        <div class="input-group" style="min-width: 125px; margin-left: 10px;">
                            <label>Phone </label>
                            <input type="text" placeholder="(XXX)-XXX-XXXX" name="phonenumber" required pattern="\(\d{3}\)-\d{3}-\d{4}" title="Enter A Valid Phone Number, e.g. (XXX)-XXX-XXXX">
                        </div>
                    </div>


                    <div class="input-row">
                        <div class="input-group" style="min-width: 125px;  ">
                            <label>Email </label>
                            <input type="email" placeholder="john.doe@sjsu.edu" name="email" required pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{7,50}" title="Enter A Valid Email">
                        </div>

                        <div class="input-group" style="min-width: 125px;   margin-left: 10px;">
                            <label>Subject</label>
                            <input type="text" placeholder="Subject" name="usermessage"">
                        </div>
                    </div>

                    <label>Inquiry</label>
                    <textarea rows="6" placeholder="Input Message" required name="inquiry" pattern="[A-Za-z0-9\s.!?]{1,0}" style="resize: none;"> </textarea>

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
                    <button onclick="closePopup()">Close</button>
                </div>
            </div>


            <div class="contact-right" style="color: white">
                <h3>Contact Information</h3>
                <table>
                    <tr>
                        <td>Email: </td>
                        <td>Noircapitalbank@gmail.com</td>
                    </tr>
                    <tr> <td> <br> </td></tr>
                    <tr>
                      
                        <td>Number: </td>

                        <td>(408) 924-3800</td>
                        <br>
                    </tr>
                    <tr> <td> <br> </td></tr>
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
        <script src="https://unpkg.com/scrollreveal"></script>
        <script src="home.js"></script>
        <footer class="footer">
            &copy; 2023 NOIR CAPITAL BANK. All rights reserved.
        </footer>
</body>

</html>