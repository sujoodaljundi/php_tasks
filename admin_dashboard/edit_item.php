<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $item_id = $_GET['id'];
    $sql = "SELECT * FROM Item WHERE item_id = $item_id";
    $result = $conn->query($sql);
    $item = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_id = $_POST['item_id'];
    $item_description = $_POST['item_description'];
    $item_total_number = $_POST['item_total_number'];
    
    if ($_FILES["item_image"]["name"]) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["item_image"]["name"]);
        move_uploaded_file($_FILES["item_image"]["tmp_name"], $target_file);
        
        $sql = "UPDATE Item SET item_description='$item_description', item_image='$target_file', item_total_number=$item_total_number WHERE item_id=$item_id";
    } else {
        $sql = "UPDATE Item SET item_description='$item_description', item_total_number=$item_total_number WHERE item_id=$item_id";
    }

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
    <title>Edit Item</title>
</head>
<body>
    <h2>Edit Item</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
        <label for="item_description">Item Description:</label>
        <input type="text" name="item_description" value="<?php echo $item['item_description']; ?>" required>
        <br>
        <label for="item_image">Item Image:</label>
        <input type="file" name="item_image" accept="image/*">
        <br>
        <label for="item_total_number">Item Total Number:</label>
        <input type="number" name="item_total_number" value="<?php echo $item['item_total_number']; ?>" required>
        <br>
        <input type="submit" value="Update Item">
    </form>
</body>
</html>
