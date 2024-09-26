<?php
session_start();
include('../config/db.php');

$name = $email = $password = '';
$error_message = '';
$success_message = '';
$form_to_show = 'login'; 


if (isset($_GET['action']) && $_GET['action'] === 'register') {
    $form_to_show = 'register';
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

   
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $error_message = "Email is already registered!";
    } else {
       
        $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['user_id'] = $conn->insert_id; 
            $_SESSION['user_name'] = $name; 
            $success_message = "Registration successful! You can now <a href='login.php'>login</a>.";
            $form_to_show = 'login'; 
        } else {
            $error_message = "Error: " . $conn->error;
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['user_name'] = $row['name']; 
            header('Location: add_order.php'); 
            exit;
        }
        
        } else {
            $error_message = "Incorrect password!";
        }
    } else {
        $error_message = "No user found with that email!";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register / Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
       
        body {
            font-family: Arial, sans-serif;
            background-color: #e9ecef;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 10px auto;
            background-color: #fff;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 30px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
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

        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }

        .success {
            color: green;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <?php if ($form_to_show === 'register'): ?>
        <h2>Register Here</h2>
        <form action="register_login.php?action=register" method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Enter Email" required>
            <input type="password" name="password" placeholder="Enter Password" required>
            <button type="submit" name="register">Register</button>
        </form>
        <p>Already have an account? <a href="?action=login">Login here</a></p>
    <?php else: ?>
        <h2>Login Here</h2>
        <form action="register_login.php?action=login" method="POST">
            <input type="email" name="email" placeholder="Enter Email" required>
            <input type="password" name="password" placeholder="Enter Password" required>
            <button type="submit" name="login">Login</button>
        </form>
        <p>Don't have an account? <a href="?action=register">Register here</a></p>
    <?php endif; ?>
    
    <?php if (!empty($error_message)) echo "<p class='error'>$error_message</p>"; ?>
    <?php if (!empty($success_message)) echo "<p class='success'>$success_message</p>"; ?>
</div>

</body>
</html>
