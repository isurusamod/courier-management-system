<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);


if (file_exists('config/db.php')) {
    include('config/db.php'); 
} else {
    die("Database configuration file not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courier Management System</title>
    <link rel="stylesheet" href="assets/css/style.css"> 
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-image: url('assets/img/img1.jpg'); 
            background-size: cover; 
            background-position: center;
            background-repeat: no-repeat; 
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #333;
            overflow: hidden;
            display: flex; 
            align-items: center; 
        }

        .navbar a {
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        .user-info {
            color: white;
            margin-left: auto;
            padding-right: 20px; 
            font-size: 16px; 
        }

        .container {
            padding: 30px;
            max-width: 400px;
            margin: 40px auto;
            background-color: #fff;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            border-radius: 50px;
        }
       
        h1 {
            text-align: center;
            color: #333;
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        form {
            margin-top: 30px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
        }

        input {
            width: 90%;
            padding: 10px;
            margin-bottom: 15px;
            border: 2px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            transition: border-color 0.3s;
        }

        input:focus {
            border-color: #4CAF50;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 1.2em;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        .footer {
            text-align: center;
            padding: 15px;
            background-color: #333;
            color: white;
            position: relative;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>
<div class="navbar">
    <a href="index.php">Home</a>
    <a href="pages/track.php">Track Parcel</a>
    <a href="pages/login.php">Login</a>
    <a href="pages/add_order.php">Add order</a>
    
    <?php if (isset($_SESSION['role']) && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'employee')): ?>
        <a href="pages/add_order.php">Place Order</a>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="pages/logout.php">Logout</a>
        <div class="user-info">
            Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!
        </div>
    <?php endif; ?>
</div>

<div class="container">
    <h1>Welcome to the Courier Management System</h1>

    <form action="pages/track.php" method="GET">
        <input type="text" name="tracking_number" placeholder="Enter Tracking Number" required>
        <button type="submit">Track</button>
    </form>
</div>

<div class="footer">
    <p>2024 Courier Management System</p>
    <p>Isuru Samod</p>
</div>

</body>
</html>
