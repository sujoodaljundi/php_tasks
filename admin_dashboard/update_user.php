<?php
include 'functions.php';

$user_id = $_GET['id'];
$user = null;

// Fetch current user
$sql = "SELECT * FROM User WHERE user_id=$user_id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    if (updateUser($user_id, $name, $mobile, $email, $address)) {
        header("Location: view_users.php");
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
    <title>Update User</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Update User</h2>
    <form method="POST" action="">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="<?php echo $user['user_name']; ?>" required><br>
        <label for="mobile">Mobile:</label><br>
        <input type="text" id="mobile" name="mobile" value="<?php echo $user['user_mobile']; ?>" required><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo $user['user_email']; ?>" required><br>
        <label for="address">Address:</label><br>
        <input type="text" id="address" name="address" value="<?php echo $user['user_address']; ?>" required><br><br>
        <input type="submit" value="Update User">
    </form>
</body>
</html>
