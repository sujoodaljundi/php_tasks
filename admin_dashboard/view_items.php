<?php
include 'functions.php';
$items = getItems();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Items</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Items</h2>
    <a href="add_item.php" class="add-button">+ Add New Item</a>
    
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Description</th>
            <th>Total Number</th>
            <th>Actions</th>
        </tr>
        <?php while($item = $items->fetch_assoc()): ?>
        <tr>
            <td><?php echo $item['item_id']; ?></td>
            <td><?php echo $item['item_description']; ?></td>
            <td><?php echo $item['item_total_number']; ?></td>
            <td>
                <a href="edit_item.php?id=<?php echo $item['item_id']; ?>">Edit</a>
                <a href="delete_item.php?id=<?php echo $item['item_id']; ?>">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
