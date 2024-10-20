<?php
include 'db_connection.php';

function getUsers() {
    global $conn;
    $sql = "SELECT * FROM User WHERE is_deleted = 0";
    $result = $conn->query($sql);
    return $result;
}

function createUser($name, $mobile, $email, $address) {
    global $conn;
    $sql = "INSERT INTO User (user_name, user_mobile, user_email, user_address) VALUES ('$name', '$mobile', '$email', '$address')";
    return $conn->query($sql);
}

function updateUser($id, $name, $mobile, $email, $address) {
    global $conn;
    $sql = "UPDATE User SET user_name='$name', user_mobile='$mobile', user_email='$email', user_address='$address' WHERE user_id=$id";
    return $conn->query($sql);
}

function softDeleteUser($id) {
    global $conn;
    $sql = "UPDATE User SET is_deleted=1 WHERE user_id=$id";
    return $conn->query($sql);
}

function getItems() {
    global $conn;
    $sql = "SELECT * FROM Item";
    $result = $conn->query($sql);
    return $result;
}

function createItem($description, $image, $total_number) {
    global $conn;
    $sql = "INSERT INTO Item (item_description, item_image, item_total_number) VALUES ('$description', '$image', $total_number)";
    return $conn->query($sql);
}

function updateItem($id, $description, $image, $total_number) {
    global $conn;
    $sql = "UPDATE Item SET item_description='$description', item_image='$image', item_total_number=$total_number WHERE item_id=$id";
    return $conn->query($sql);
}

function softDeleteItem($id) {
    global $conn;
    $sql = "UPDATE Item SET is_deleted=1 WHERE item_id=$id";
    return $conn->query($sql);
}

function getOrdersWithDetails() {
    global $conn;
    $sql = "SELECT o.order_id, u.user_name, i.item_description 
            FROM `Order` o 
            JOIN User u ON o.user_order_id = u.user_id 
            JOIN Item i ON o.user_item_order_id = i.item_id";
    $result = $conn->query($sql);
    return $result;
}

function createOrder($user_order_id, $user_item_order_id) {
    global $conn;
    $sql = "INSERT INTO `Order` (user_order_id, user_item_order_id) VALUES ($user_order_id, $user_item_order_id)";
    return $conn->query($sql);
}

?>
