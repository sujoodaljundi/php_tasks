<?php
include 'functions.php';

$item_id = $_GET['id'];
$item = null;

// Fetch the current item
$sql = "SELECT * FROM Item WHERE item_id=$item_id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $item = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $description = $_POST['description'];
    $image = $_POST['image'];
    $total_number = $_POST['total_number'];

    if (updateItem($item_id, $description, $image, $total_number)) {
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
    <title>Update Item</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Update Item</h2>
    <form method="POST" action="">
        <label for="description">Description:</label><br>
        <input type="text" id="description" name="description" value="<?php echo $item['item_description']; ?>" required><br>
        <label for="image">Image:</label><br>
        <input type="text" id="image" name="image" value="<?php echo $item['item_image']; ?>" required><br>
        <label for="total_number">Total Number:</label><br>
        <input type="number" id="total_number" name="total_number" value="<?php echo $item['item_total_number']; ?>" required><br><br>
        <input type="submit" value="Update Item">
    </form>
</body>
</html>
