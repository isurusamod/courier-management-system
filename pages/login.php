<?php
session_start();
include('../config/db.php'); 

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

   
    $sql = "SELECT * FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        
        if (password_verify($password, $row['password'])) {
           
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['user_name'] = isset($row['name']) ? $row['name'] : 'Guest';

           
            if ($row['role'] === 'admin') {
                
                header('Location: ../admin/dashboard.php'); 
            } else {
                
                header('Location: ../pages/add_order.php'); 
            }
            exit; 
        } else {
            $error_message = "Incorrect password!";
        }
    } else {
        $error_message = "No user found with that email!";
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-image: url('../assets/img/img2.jpg'); 
            background-size: 1000px 600px;
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

        .container {
            max-width: 400px;
            margin: 10px auto; 
            background-color: #fff;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            border-radius: 50px; 
            padding: 30px; 
        }

        h2 {
            font-size: 35px;
            text-align: center;
            color: #333;
            margin-bottom: 20px; 
        }

        input {
            width: 90%;
            padding: 8px; 
            margin-bottom: 15px; 
            border: 2px solid #ccc;
            border-radius: 50px; 
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
            cursor: pointer;
            font-size: 16px; 
        }

        button:hover {
            background-color: #45a049; 
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
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

        p {
            text-align: center; 
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="../index.php">Home</a>
    <a href="track.php">Track Parcel</a>
    
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="logout.php">Logout</a>
        <div class="user-info">
            Welcome, <?php echo $_SESSION['user_name']; ?>!
        </div>
    <?php endif; ?>
</div>

<div class="container">
    <h2>Login</h2>
    <form action="login.php" method="POST">
        <input type="email" name="email" placeholder="Enter Email" required>
        <input type="password" name="password" placeholder="Enter Password" required>
        <button type="submit" name="login">Login</button>
    </form>

    <?php if ($error_message) echo "<p class='error'>$error_message</p>"; ?>
    
    <p>If you don't have an account, <a href="register.php">Register here</a>.</p>
</div>

<div class="footer">
    <p>2024 Courier Management System</p>
    <p>Isuru Samod</p>
</div>

</body>
</html>
