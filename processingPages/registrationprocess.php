<html>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NOIR - Register</title>
    <link rel="stylesheet" type="text/css" href="../css/registration.css">

    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400&display=swap" rel="stylesheet">
    
</html>
<style>
    body {
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: #808080;
    }

    #message-container {
        color: white;
        height: 80%;
        width: 70%;
        max-height: 1000px;
        max-width: 500px;
        background-color: #595f57;
        text-align: center;
        padding: 20px;
        border-radius: 5px;
        background: linear-gradient(245.59deg, #555 0%, #333 28.53%, #222 75.52%);
    }
    #message-container a{
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
    margin-left: 30px;
    max-width: 300px;
    text-align:center;
    justify-content: center;
    }
    #message-container a:hover{
    background: transparent;
    border: 1px solid white;
    transform: translateY(3px);
}

    @media (max-width: 600px) {
        #container {
            width: 90%;
        }
    }
    a{
        color:white;
    }

</style>
<?php
if (isset($_POST["email"]) && isset($_POST["firstName"]) && isset($_POST["lastName"]) && isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["password2"]) && isset($_POST["phone"]) && isset($_POST["address"]) && isset($_POST["zipcode"]) && isset($_POST["state"]) && isset($_POST["securityquestion"]) && isset($_POST["securityresponse"]) && isset($_POST["Pin"])) {

    if ($_POST["email"] && $_POST["firstName"] && $_POST["lastName"] && $_POST["username"] && $_POST["password"] && $_POST["password2"] && $_POST["securityquestion"] && $_POST["securityresponse"] && $_POST["Pin"]) {
        $email = $_POST["email"];
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $password2 = $_POST["password2"];
        $phone = $_POST["phone"];
        $address = $_POST["address"];
        $zipcode = $_POST["zipcode"];
        $state = $_POST["state"];
        $securityquestion = $_POST["securityquestion"];
        $securityresponse = $_POST["securityresponse"];
        $Pin = $_POST["Pin"];
        // create connection
        $conn = mysqli_connect("localhost", "root", "", "bankregistration");

        // check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $user_id = rand(100000000000, 999999999999);
        $debitcard = rand(1000000000000000, 9999999999999999);

        $debitcard_expire = rand(1, 12) . '/' . date('y', strtotime('+4 years'));
        $debitcard_cvv = str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);

        // Set default values for debitcard_expire and debitcard_cvv
        $debitcard_expire_default = '00/00';
        $debitcard_cvv_default = '000';

        // register user
        $sql = "INSERT INTO bank_users(`email`, `firstName`, `lastName`, `username`, `password1`, `password2`, `phonenumber`, `address`, `zipcode`, `state`, `securityquestion`, `securityresponse`, `user_id`, `debitcard`, `Pin`, `debitcard_expire`, `debitcard_cvv`) VALUES ('$email', '$firstName', '$lastName', '$username','$password','$password2','$phone','$address','$zipcode','$state','$securityquestion','$securityresponse',$user_id,$debitcard,$Pin, '$debitcard_expire', '$debitcard_cvv')";

        $results = mysqli_query($conn, $sql);

        echo '<div id="message-container">';
        if ($results) {
            echo "<br>";
            echo "<h4>Your Account Has Been Successfully Created!<br><br></h4>";
            echo "You Are Ready To Begin Your Financial Journey!<br><br><br>";
            echo "<button onclick=\"closePopupAndRedirect()\">Return to Homepage</button>";
            echo "<script>function closePopupAndRedirect() { window.opener.location.reload(); window.close(); }</script>";
        } else {
            // Check if it's a duplicate entry error
            if (mysqli_errno($conn) == 1062) {
                // Get the error message
                $errorMessage = mysqli_error($conn);
        
                // Check if the error message contains the field names
                if (strpos($errorMessage, 'email') !== false) {
                    echo "<br><br><br><br><br><br>User With This Email Already Exists!";
                } elseif (strpos($errorMessage, 'username') !== false) {
                    echo "<br><br><br><br><br><br>User With This Username Already Exists!";
                } elseif (strpos($errorMessage, 'phonenumber') !== false) {
                    echo "<br><br><br><br><br><br>User With This Phone Number Already Exists!";
                } else {
                    // If it's neither email nor username, provide a general message
                    echo "Duplicate entry error: " . $errorMessage;
                }
                echo '<br><br>';
                echo '<button onclick="history.back()">Go Back to Registration</button>';
            } else {
                // Other error
                echo "Error: " . mysqli_error($conn);
            }
        }

        mysqli_close($conn); // close connection

    } else {
        echo "Fill in Required Information";
    }
}
?>