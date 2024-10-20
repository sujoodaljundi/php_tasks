<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $sql = "SELECT * FROM User WHERE user_id = $user_id";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $user_name = $_POST['user_name'];
    $user_mobile = $_POST['user_mobile'];
    $user_email = $_POST['user_email'];
    $user_address = $_POST['user_address'];

    $sql = "UPDATE User SET user_name='$user_name', user_mobile='$user_mobile', user_email='$user_email', user_address='$user_address' WHERE user_id=$user_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
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
    <title>Edit User</title>
</head>
<body>
    <h2>Edit User</h2>
    <form method="POST" action="">
        <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
        <label for="user_name">User Name:</label>
        <input type="text" name="user_name" value="<?php echo $user['user_name']; ?>" required>
        <br>
        <label for="user_mobile">User Mobile:</label>
        <input type="text" name="user_mobile" value="<?php echo $user['user_mobile']; ?>" required>
        <br>
        <label for="user_email">User Email:</label>
        <input type="email" name="user_email" value="<?php echo $user['user_email']; ?>" required>
        <br>
        <label for="user_address">User Address:</label>
        <input type="text" name="user_address" value="<?php echo $user['user_address']; ?>" required>
        <br>
        <input type="submit" value="Update User">
    </form>
</body>
</html>
