<?php

session_start();
include('../config/db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "courier_management";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function executeQuery($conn, $sql) {
    $result = $conn->query($sql);
    if (!$result) {
        die("Error executing query: " . $conn->error);
    }
    return $result->fetch_assoc();
}


$sql_total_orders = "SELECT COUNT(*) AS total FROM orders";
$sql_pending_orders = "SELECT COUNT(*) AS total FROM orders WHERE status = 'pending'";
$sql_completed_orders = "SELECT COUNT(*) AS total FROM orders WHERE status = 'completed'";

$totalOrders = executeQuery($conn, $sql_total_orders)['total'];
$pendingOrders = executeQuery($conn, $sql_pending_orders)['total'];
$completedOrders = executeQuery($conn, $sql_completed_orders)['total'];

$sql_total_shipments = "SELECT COUNT(*) AS total FROM shipments";
$sql_pending_shipments = "SELECT COUNT(*) AS total FROM shipments WHERE status = 'pending'";
$sql_completed_shipments = "SELECT COUNT(*) AS total FROM shipments WHERE status = 'completed'";
$sql_total_couriers = "SELECT COUNT(*) AS total FROM couriers";

$totalShipments = executeQuery($conn, $sql_total_shipments)['total'];
$pendingShipments = executeQuery($conn, $sql_pending_shipments)['total'];
$completedShipments = executeQuery($conn, $sql_completed_shipments)['total'];
$totalCouriers = executeQuery($conn, $sql_total_couriers)['total'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Courier Management</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f4f4f9;
        }
        .container {
            width: 80%;
            margin: 20px auto;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
        }
        .dashboard {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            width: 22%;
            margin-bottom: 20px;
        }
        .card h3 {
            font-size: 18px;
            color: #333;
            margin-bottom: 10px;
        }
        .card p {
            font-size: 24px;
            font-weight: bold;
            color: #4CAF50;
        }
        .navbar {
            background-color: #333;
            overflow: hidden;
            margin-bottom: 20px; 
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
    </style>
</head>
<body>

    <div class="navbar">
        <a href="dashboard.php">Dashboard</a>
        <a href="view_users.php">User List</a>
    </div>

    <div class="container">
        <header>
            <h1>Courier Management Dashboard</h1>
        </header>
        
        <div class="dashboard">
        
            <div class="card">
                <h3>Total Orders</h3>
                <p><?php echo $totalOrders; ?></p>
            </div>
            <div class="card">
                <h3>Pending Orders</h3>
                <p><?php echo $pendingOrders; ?></p>
            </div>
            <div class="card">
                <h3>Completed Orders</h3>
                <p><?php echo $completedOrders; ?></p>
            </div>
            
            <div class="card">
                <h3>Total Shipments</h3>
                <p><?php echo $totalShipments; ?></p>
            </div>
            <div class="card">
                <h3>Pending Shipments</h3>
                <p><?php echo $pendingShipments; ?></p>
            </div>
            <div class="card">
                <h3>Completed Shipments</h3>
                <p><?php echo $completedShipments; ?></p>
            </div>
           
            <div class="card">
                <h3>Total Couriers</h3>
                <p><?php echo $totalCouriers; ?></p>
            </div>
        </div>
    </div>
</body>
</html>
