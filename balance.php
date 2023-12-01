<?php
// Include your database connection file
include('conn.php');

// Start or resume a session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['debitcard'])) {
    // Redirect to login page if not logged in
    header("Location: atm.php");
    exit();
}

// Get the user's ID from the session
$user_id = $_SESSION['user_id'];

// Retrieve the user's debit card balance
$query_balance = "SELECT debitcard_balance FROM bank_users WHERE user_id = $user_id";
$result_balance = mysqli_query($conn, $query_balance);
$debitcard_balance = mysqli_fetch_assoc($result_balance)['debitcard_balance'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debit Card Balance</title>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400&display=swap" rel="stylesheet">
    <!-- Add your CSS styling here -->
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
            color: white;
            text-align: center;
        }

        form {
            color: white;
            display: flex;
            flex-direction: column;
            width: 100%;
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
            margin-left: 10px;
            border: 1px solid white;
        }

        button:hover {
            background-color: transparent;
        }

        @media (max-width: 680px) {
            form {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <h1>Debit Card Balance</h1>
    <form>
    <p>Your Current Debit Card Balance Is: $<?php echo number_format($debitcard_balance, 2); ?></p>
    </form>
    <button onclick="returnToDashboard()">RETURN TO ATM DASHBOARD</button>
    <script>
        function returnToDashboard() {
            // Close the current popup window
            window.close();
        }
    </script>
</body>
</html>
