<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('../config/db.php');


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$sql = "SELECT id, sender_name, sender_contact, recipient_name, recipient_contact, destination, order_date, status, total_amount, tracking_number FROM orders";
$result = $conn->query($sql);


if ($result === FALSE) {
    die("Error retrieving orders: " . $conn->error);
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px 15px;
            text-align: left;
        }
        th {
            background-color: #4CAF50; 
            color: white; 
        }
        tr:nth-child(even) {
            background-color: #f9f9f9; 
        }
        tr:hover {
            background-color: #f1f1f1; 
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
        .navbar a.active {
            background-color: #4CAF50; 
            color: white;
        }
        select {
            padding: 6px;
            margin: 5px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        button {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #45a049; 
        }
        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }
            thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
            tr {
                margin-bottom: 15px;
            }
            td {
                text-align: right;
                padding-left: 50%;
                position: relative;
            }
            td::before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                width: calc(50% - 20px);
                padding-right: 10px;
                text-align: left;
                font-weight: bold;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="dashboard.php">Dashboard</a>
         
    </div>
    
    <h1>Order List</h1>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Sender Name</th>
                <th>Sender Contact</th>
                <th>Recipient Name</th>
                <th>Recipient Contact</th>
                <th>Destination</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Total Amount</th>
                <th>Tracking Number</th> 
                <th>Update Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td data-label="Order ID"><?php echo htmlspecialchars($row['id']); ?></td>
                        <td data-label="Sender Name"><?php echo htmlspecialchars($row['sender_name']); ?></td>
                        <td data-label="Sender Contact"><?php echo htmlspecialchars($row['sender_contact']); ?></td>
                        <td data-label="Recipient Name"><?php echo htmlspecialchars($row['recipient_name']); ?></td>
                        <td data-label="Recipient Contact"><?php echo htmlspecialchars($row['recipient_contact']); ?></td>
                        <td data-label="Destination"><?php echo htmlspecialchars($row['destination']); ?></td>
                        <td data-label="Order Date"><?php echo htmlspecialchars($row['order_date']); ?></td>
                        <td data-label="Status"><?php echo htmlspecialchars($row['status']); ?></td>
                        <td data-label="Total Amount"><?php echo htmlspecialchars($row['total_amount']); ?></td>
                        <td data-label="Tracking Number"><?php echo htmlspecialchars($row['tracking_number']); ?></td> <!-- New data field for Tracking Number -->
                        <td data-label="Update Status">
                            <form action="update_status.php" method="POST">
                                <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                                <select name="status">
                                    <option value="pending" <?php if($row['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                                    <option value="packing" <?php if($row['status'] == 'packing') echo 'selected'; ?>>Packing</option>
                                    <option value="delayed" <?php if($row['status'] == 'delayed') echo 'selected'; ?>>Delayed</option>
                                    <option value="sent" <?php if($row['status'] == 'sent') echo 'selected'; ?>>Sent</option>
                                    <option value="completed" <?php if($row['status'] == 'completed') echo 'selected'; ?>>Completed</option>
                                </select>
                                <button type="submit">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="11">No orders found.</td> 
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
