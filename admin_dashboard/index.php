<?php
include 'db_connection.php';
include 'functions.php';

$orders = getOrdersWithDetails();
$users = getUsers();
$items = getItems();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Admin Dashboard</h1>

    <h2>Users</h2>
    <a href="add_user.php" class="add-button">+ Add New User</a>

    <table border="1">
        <tr>
            <th>User ID</th>
            <th>User Name</th>
            <th>User Mobile</th>
            <th>User Email</th>
            <th>User Address</th>
            <th>Actions</th>
        </tr>
        <?php while ($user = $users->fetch_assoc()): ?>
        <tr>
            <td><?php echo $user['user_id']; ?></td>
            <td><?php echo $user['user_name']; ?></td>
            <td><?php echo $user['user_mobile']; ?></td>
            <td><?php echo $user['user_email']; ?></td>
            <td><?php echo $user['user_address']; ?></td>
            <td>
            <a href="edit_user.php?id=<?php echo $user['user_id']; ?>">Edit</a> | 
            <a href="delete_user.php?id=<?php echo $user['user_id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
        </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <h2>Items</h2>
    <a href="add_item.php" class="add-button">+ Add New Item</a>
<table border="1">
    <tr>
        <th>Item ID</th>
        <th>Item Description</th>
        <th>Item Image</th> 
        <th>Item Total Number</th>
        <th>Actions</th> 
    </tr>
    <?php while ($item = $items->fetch_assoc()): ?>
    <tr>
        <td><?php echo $item['item_id']; ?></td>
        <td><?php echo $item['item_description']; ?></td>
        <td><img src="<?php echo $item['item_image']; ?>" alt="Item Image" width="50"></td> <!-- عرض الصورة -->
        <td><?php echo $item['item_total_number']; ?></td>
        <td>
            <a href="edit_item.php?id=<?php echo $item['item_id']; ?>">Edit</a> | 
            <a href="delete_item.php?id=<?php echo $item['item_id']; ?>" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

    <h2>Orders</h2>
    <a href="create_order.php">Add New Order</a>

    <table border="1">
        <tr>
            <th>Order ID</th>
            <th>User Name</th>
            <th>Item Description</th>
        </tr>
        <?php while ($order = $orders->fetch_assoc()): ?>
        <tr>
            <td><?php echo $order['order_id']; ?></td>
            <td><?php echo $order['user_name']; ?></td>
            <td><?php echo $order['item_description']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>
