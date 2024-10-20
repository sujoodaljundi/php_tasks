<?php
include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    if (createUser($name, $mobile, $email, $address)) {
        header("Location: view_users.php"); 
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>Add User</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Add New User</h2>
    <form method="POST" action="">
        <label for="name">name:</label><br>
        <input type="text" id="name" name="name" required><br>
        <label for="mobile">mobile:</label><br>
        <input type="text" id="mobile" name="mobile" required><br>
        <label for="email">email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <label for="address">address:</label><br>
        <input type="text" id="address" name="address" required><br><br>
        <input type="submit" value="Add User">
    </form>
</body>
</html>
