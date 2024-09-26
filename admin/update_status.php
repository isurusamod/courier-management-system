<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('../config/db.php');


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    if (isset($_POST['order_id']) && isset($_POST['status'])) {
        $order_id = $_POST['order_id'];
        $status = $_POST['status'];

       
        $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $order_id);

       
        if ($stmt->execute()) {
            
            $_SESSION['success_message'] = "Order status updated successfully.";
        } else {
           
            $_SESSION['error_message'] = "Error updating order status: " . $stmt->error;
        }

      
        $stmt->close();
    } else {
      
        $_SESSION['error_message'] = "Invalid input.";
    }
}


$conn->close();


header('Location: view_orders.php');
exit;
