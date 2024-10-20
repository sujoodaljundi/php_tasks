<?php
include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $user_id = $_GET['id'];
    softDeleteUser($user_id);
    header("Location: view_users.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $sql = "DELETE FROM User WHERE user_id = $user_id";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . $conn->error;    }
    }
?>
