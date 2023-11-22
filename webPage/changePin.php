<?php
// Include your database connection file
include('../processingPages/conn.php');

// Start or resume a session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: ../webPage/atm.php");
    exit();
}

// Get the user's ID from the session
$user_id = $_SESSION['user_id'];

// Retrieve user data for security check
$query_user_data = "SELECT password1, securityquestion, securityresponse FROM bank_users WHERE user_id = $user_id";
$result_user_data = mysqli_query($conn, $query_user_data);
$user_data = mysqli_fetch_assoc($result_user_data);

// Process the change PIN form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $securityresponse = $_POST['securityresponse'];
    $old_pin = $_POST['Pin'];
    $new_pin = $_POST['new_pin'];
    $confirm_new_pin = $_POST['confirm_new_pin'];

    // Validate password and security response
    if ($password === $user_data['password1'] && $securityresponse === $user_data['securityresponse']) {
        // Validate old PIN
        if ($old_pin === $user_data['Pin']) {
            // Validate new PIN and confirmation
            if ($new_pin === $confirm_new_pin) {
                // Update the user's PIN
                $update_pin_query = "UPDATE bank_users SET Pin = '$new_pin' WHERE user_id = $user_id";
                mysqli_query($conn, $update_pin_query);
                // Redirect to a success page or the same page with a success message
                header("Location: ../webPage/changePin.php?success=1");
                exit();
            } else {
                $error_message = "New PIN and confirmation do not match. Please try again.";
            }
        } else {
            $error_message = "Invalid old PIN. Please try again.";
        }
    } else {
        $error_message = "Invalid password or security response. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change PIN</title>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400&display=swap" rel="stylesheet">

    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
            list-style: none;
            text-decoration: none;
        }

        body {
            height: 100vh;
            width: 100%;
            text-align: center;
            padding: 20px;
            border-radius: 5px;
            background: linear-gradient(245.59deg, #555 0%, #333 28.53%, #222 75.52%);
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .bank2 {
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        h1 {
            color: white;
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            color: green;
            text-align: center;
        }

        form {
            color: white;
            display: flex;
            flex-direction: column;
            max-width: 100%;
            padding: 20px;
            background-color: #808080;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 2em;
        }

        label {
            margin-bottom: 0.5em;
        }

        select,
        input {
            padding: 0.5em;
            margin-bottom: 1em;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            border: 1px solid #555;
            background-color: #555;
            color: #fff;
            padding: 10px 20px;
            border: 1px;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 16px;
            margin-bottom: 5px;
            transition: 0.5s;
            margin-left: 15px;
            border: 1px solid white;
        }

        button:hover {
            background-color: transparent;
        }

        .error {
            color: red;
            margin-top: 10px;
        }
        #submit:hover {
             background-color: #46a349;
        }
    </style>
</head>
<body>

    <h1>Change PIN</h1>

    <!-- Display error message if there is an error -->
    <?php if (isset($error_message)): ?>
        <p class="error"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <!-- Display success message if redirected with success parameter -->
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <p style="color: green;">PIN changed successfully!</p>
    <?php endif; ?>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="password">Enter Account Password:</label>
        <input type="password" name="password" id="password" required placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Enter Valid Password">
        
        <label for="securityquestion">Verification Question:</label>
        <h4 style="color: #00FF00;"><?php echo $user_data['securityquestion']; ?></h4><br>
        
        <label for="securityresponse">Verification Response:</label>
        <input type="password" name="securityresponse" id="securityresponse" required placeholder="Security Response" pattern="[A-Za-z0-9\s]{1,0}">


        <label for="old_pin">Enter Old PIN:</label>
        <input type="password" name="old_pin" id="old_pin" required placeholder="Old Pin" pattern="\d{6}" title="PIN must be exactly 6 Digits">


        <label for="new_pin">Enter New PIN:</label>
        <input type="password" name="new_pin" id="new_pin" required placeholder="New Pin" pattern="\d{6}" title="PIN must be exactly 6 Digits">

        <label for="confirm_new_pin">Confirm New PIN:</label>
        <input type="password" name="confirm_new_pin" id="confirm_new_pin" required placeholder="Confirm New Pin" pattern="\d{6}" title="PIN must be exactly 6 Digits">

        <button type="submit" id="submit">CHANGE PIN</button>
    </form>
    <button onclick="returnToDashboard()">RETURN TO DASHBOARD</button>

    <script>
        function returnToDashboard() {
            // Close the current popup window
            window.close();
        }
    </script>
</body>
</html>
