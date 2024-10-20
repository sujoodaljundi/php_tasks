<?php
include 'db_connection.php';
include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    if (createUser($name, $mobile, $email, $address)) {
        header("Location: index.php"); // عودة إلى الصفحة الرئيسية
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
    <title>Add User</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Add New User</h2>
    <form method="POST" action="">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br>
        <label for="mobile">Mobile:</label><br>
        <input type="text" id="mobile" name="mobile" required><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <label for="address">Address:</label><br>
        <input type="text" id="address" name="address" required><br><br>
        <input type="submit" value="Add User">
    </form>
</body>
</html>
