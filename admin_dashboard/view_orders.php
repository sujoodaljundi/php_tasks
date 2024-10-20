<?php
include 'functions.php';
$orders = getOrdersWithDetails();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Orders</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Order List</h2>
    <a href="create_order.php">Add New Order</a>
    <table border="1">
        <tr>
            <th>Order ID</th>
            <th>User Name</th>
            <th>Item Description</th>
            <th>Actions</th>
        </tr>
        <?php while($order = $orders->fetch_assoc()): ?>
        <tr>
            <td><?php echo $order['order_id']; ?></td>
            <td><?php echo $order['user_name']; ?></td>
            <td><?php echo $order['item_description']; ?></td>
            <td>
                <a href="delete_order.php?id=<?php echo $order['order_id']; ?>" onclick="return confirm('Are you sure you want to delete this order?');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
