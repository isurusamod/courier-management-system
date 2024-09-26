<?php
session_start();

$_SESSION = [];
session_destroy();
header("Refresh: 3; url=login.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .message {
            text-align: center;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="message">
    <h1>Logged Out Successfully</h1>
    <p>You have been logged out. You will be redirected to the login page shortly.</p>
    <p>If you are not redirected, <a href="login.php">click here</a>.</p>
</div>

</body>
</html>
