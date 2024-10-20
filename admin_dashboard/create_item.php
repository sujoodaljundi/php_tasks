<?php
include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $description = $_POST['description'];
    $image = $_POST['image'];
    $total_number = $_POST['total_number'];

    if (createItem($description, $image, $total_number)) {
        header("Location: view_items.php");
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
    <title>Add Item</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Add New Item</h2>
    <form method="POST" action="">
        <label for="description">Description:</label><br>
        <input type="text" id="description" name="description" required><br>
        <label for="image">Image:</label><br>
        <input type="text" id="image" name="image" required><br>
        <label for="total_number">Total Number:</label><br>
        <input type="number" id="total_number" name="total_number" required><br><br>
        <input type="submit" value="Add Item">
    </form>
</body>
</html>
