<?php
include('../config/db.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Parcel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-image: url('../assets/img/img1.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #333;
            overflow: hidden;
            padding: 10px 0;
            display: flex;
            align-items: center;
        }

        .navbar a {
            color: white;
            text-align: left;
            padding: 14px 20px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        .user-info {
            color: white;
            padding-right: 20px;
            font-size: 16px;
            margin-left: auto;
            display: flex;
            align-items: center;
        }

        .user-info::before {
            content: '• ';
            font-size: 20px;
            padding-right: 5px;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            padding: 30px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .error, .success {
            text-align: center;
            margin-top: 10px;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }

        .footer {
            text-align: center;
            padding: 10px;
            background-color: #333;
            color: white;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="../index.php">Home</a>
    <a href="track.php">Track Parcel</a>
    
    <?php if (isset($_SESSION['role']) && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'employee')): ?>
        <a href="add_order.php">Add Order</a>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="logout.php">Logout</a>
        <div class="user-info">
            Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!
        </div>
    <?php else: ?>
        <a href="login.php">Login</a>
    <?php endif; ?>
</div>

<div class="container">
    <h2>Track Your Parcel</h2>

    <form action="track.php" method="GET">
        <input type="text" name="tracking_number" placeholder="Enter Tracking Number" required>
        <button type="submit">Track</button>
    </form>

    <?php
    if (isset($_GET['tracking_number'])) {
        $tracking_number = $_GET['tracking_number'];

        
        if (empty($tracking_number)) {
            echo "<div class='error'>Please enter a tracking number.</div>";
        } else {
          
            $sql = "SELECT * FROM orders WHERE tracking_number = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $tracking_number);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<div class='success'><h2>Tracking Details for " . htmlspecialchars($row['tracking_number']) . "</h2>";
                echo "<p>Status: " . htmlspecialchars($row['status']) . "</p>";
                echo "<p>Destination: " . htmlspecialchars($row['destination']) . "</p></div>";
            } else {
                echo "<div class='error'>Order not found! Please check the tracking number and try again.</div>";
            }
        }
    }
    ?>
</div>

<div class="footer">
    <p>2024 Courier Management System</p>
    <p>Isuru Samod</p>
</div>

</body>
</html>
