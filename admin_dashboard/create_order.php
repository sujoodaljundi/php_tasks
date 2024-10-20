<?php
include 'functions.php';
$users = getUsers();
$items = getItems();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_order_id = $_POST['user_order_id'];
    $user_item_order_id = $_POST['user_item_order_id'];

    if (createOrder($user_order_id, $user_item_order_id)) {
        header("Location: view_orders.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Order</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Add New Order</h2>
    <form method="POST" action="">
        <label for="user_order_id">User:</label><br>
        <select id="user_order_id" name="user_order_id" required>
            <?php while($user = $users->fetch_assoc()): ?>
                <option value="<?php echo $user['user_id']; ?>"><?php echo $user['user_name']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="user_item_order_id">Item:</label><br>
        <select id="user_item_order_id" name="user_item_order_id" required>
            <?php while($item = $items->fetch_assoc()): ?>
                <option value="<?php echo $item['item_id']; ?>"><?php echo $item['item_description']; ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <input type="submit" value="Add Order">
    </form>
</body>
</html>
