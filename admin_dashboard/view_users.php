<?php
include 'functions.php';
$users = getUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Users</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Users</h2>
    <a href="add_user.php" class="add-button">+ Add New User</a>
    
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Address</th>
            <th>Actions</th>
        </tr>
        <?php while($user = $users->fetch_assoc()): ?>
        <tr>
            <td><?php echo $user['user_id']; ?></td>
            <td><?php echo $user['user_name']; ?></td>
            <td><?php echo $user['user_mobile']; ?></td>
            <td><?php echo $user['user_email']; ?></td>
            <td><?php echo $user['user_address']; ?></td>
            <td>
                <a href="edit_user.php?id=<?php echo $user['user_id']; ?>">Edit</a>
                <a href="delete_user.php?id=<?php echo $user['user_id']; ?>">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

