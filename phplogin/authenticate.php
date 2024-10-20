<?php
session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if (!isset($_POST['email'], $_POST['password'])) {
    exit('Please fill both the email and password fields!');
}

if ($stmt = $con->prepare('SELECT id, password, username, profile_image FROM accounts WHERE email = ?')) {
    $stmt->bind_param('s', $_POST['email']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password, $username, $profileImage);
        $stmt->fetch();

        if (password_verify($_POST['password'], $password)) {
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['id'] = $id; 
            $_SESSION['profile_image'] = $profileImage; // حفظ مسار الصورة في الجلسة

            // تعيين الكوكي لاسم المستخدم لمدة ساعة
            setcookie('username', $username, time() + 3600, '/');

            header('Location: home.php');
        } else {
            echo 'Incorrect email and/or password!';
        }
    } else {
        echo 'Incorrect email and/or password!';
    }
    $stmt->close();
}
?>
