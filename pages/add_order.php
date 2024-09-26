<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Put Order</title>
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
        }
        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        .container {
            padding: 30px;
            max-width: 900px;
            margin: 10px auto;
            border-radius: 50px;
            flex-grow: 1;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }
        form {
            margin-top: 50px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            max-width: 400px;
            margin: 0 auto;
        }
        input, select {
            width: 100%; 
            padding: 12px; 
            margin-bottom: 15px; 
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 12px; 
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        .error, .success {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
        .success {
            color: green;
        }
        .footer {
            text-align: center;
            padding: 10px;
            background-color: #333;
            color: white;
            width: 100%;
            position: relative;
            bottom: 0;
            margin-top: auto; 
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
        <div style="float: right; color: white; padding: 14px 20px;">
            <span>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</span>
        </div>
        <a href="logout.php">Logout</a>
    <?php endif; ?>
</div>

<div class="container">
    <h1>Fill the form to Deliver your Parcel.</h1>
    <?php
session_start();
include('../config/db.php');


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}


$sender_name = $recipient_name = $destination = $sender_contact = $recipient_contact = $parcel_amount = $parcel_weight_kg = $parcel_type = '';
$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['sender_name'], $_POST['sender_contact'], $_POST['recipient_name'], $_POST['recipient_contact'], $_POST['destination'], $_POST['parcel_amount'], $_POST['parcel_weight_kg'], $_POST['parcel_type'])) {
        $sender_name = $_POST['sender_name'];
        $sender_contact = $_POST['sender_contact'];
        $recipient_name = $_POST['recipient_name'];
        $recipient_contact = $_POST['recipient_contact'];
        $destination = $_POST['destination'];
        $parcel_amount = $_POST['parcel_amount']; 
        $parcel_weight_kg = $_POST['parcel_weight_kg']; 
        $parcel_type = $_POST['parcel_type']; 
        $tracking_number = uniqid(); 

        
        if(empty($sender_name) || empty($sender_contact) || empty($recipient_name) || empty($recipient_contact) || empty($destination) || empty($parcel_amount) || empty($parcel_weight_kg) || empty($parcel_type)) {
            $error_message = "Please fill in all fields.";
        } elseif (!preg_match("/^[0-9]{10}$/", $sender_contact) || !preg_match("/^[0-9]{10}$/", $recipient_contact)) {
            $error_message = "Contact numbers must be 10 digits.";
        } elseif (!is_numeric($parcel_amount) || !is_numeric($parcel_weight_kg)) {
            $error_message = "Amount and weight must be numeric values.";
        } else {
            
            $stmt = $conn->prepare("INSERT INTO orders (tracking_number, sender_name, sender_contact, recipient_name, recipient_contact, destination, parcel_amount, parcel_weight_kg, parcel_type, status, created_at, updated_at, order_date, total_amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW(), NOW(), NOW(), ?)");
            $stmt->bind_param("ssssssdssd", $tracking_number, $sender_name, $sender_contact, $recipient_name, $recipient_contact, $destination, $parcel_amount, $parcel_weight_kg, $parcel_type, $parcel_amount);

           
            if ($stmt->execute()) {
                $success_message = "Order added successfully! Tracking Number: $tracking_number";
                
                $sender_name = $recipient_name = $destination = $sender_contact = $recipient_contact = $parcel_amount = $parcel_weight_kg = $parcel_type = '';
            } else {
                $error_message = "Error: " . $stmt->error;
            }
            $stmt->close();
        }
    } else {
        $error_message = "Please fill in all fields.";
    }
}

$conn->close();
?>

    <form action="add_order.php" method="POST">
        <input type="text" name="sender_name" placeholder="Sender Name" value="<?php echo htmlspecialchars($sender_name); ?>" required>
        <input type="text" name="sender_contact" placeholder="Sender Contact Number" value="<?php echo htmlspecialchars($sender_contact); ?>" required>
        <input type="text" name="recipient_name" placeholder="Recipient Name" value="<?php echo htmlspecialchars($recipient_name); ?>" required>
        <input type="text" name="recipient_contact" placeholder="Recipient Contact Number" value="<?php echo htmlspecialchars($recipient_contact); ?>" required>
        <input type="text" name="destination" placeholder="Destination" value="<?php echo htmlspecialchars($destination); ?>" required>
        <input type="number" name="parcel_amount" placeholder="Parcel Amount" value="<?php echo htmlspecialchars($parcel_amount); ?>" required>
        <input type="number" step="0.01" name="parcel_weight_kg" placeholder="Parcel Weight (kg)" value="<?php echo htmlspecialchars($parcel_weight_kg); ?>" required>
        
        <select name="parcel_type" required>
            <option value="">Select Parcel Type</option>
            <option value="Document" <?php echo ($parcel_type == "Document") ? 'selected' : ''; ?>>Document</option>
            <option value="Package" <?php echo ($parcel_type == "Package") ? 'selected' : ''; ?>>Package</option>
            <option value="Fragile" <?php echo ($parcel_type == "Fragile") ? 'selected' : ''; ?>>Fragile</option>
            <option value="Other" <?php echo ($parcel_type == "Other") ? 'selected' : ''; ?>>Other</option>
        </select>
        
        <button type="submit">Submit Order</button>
    </form>

    <?php if (!empty($error_message)) echo "<p class='error'>$error_message</p>"; ?>
    <?php if (!empty($success_message)) echo "<p class='success'>$success_message</p>"; ?>
    
</div>

<div class="footer">
    <p>2024 Courier Management System</p>
    <p>Isuru Samod</p>
</div>

</body>
</html>
