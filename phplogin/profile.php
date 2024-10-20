<?php
session_start();

// تأكد من أن المستخدم مسجل الدخول
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.html');
    exit;
}

// اتصال بقاعدة البيانات
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

// تحقق من الاتصال بقاعدة البيانات
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// تأكد من أن معرف المستخدم موجود في الجلسة
if (!isset($_SESSION['id'])) {
    exit('User ID not found in session.');
}

// جلب بيانات المستخدم من قاعدة البيانات
$stmt = $con->prepare('SELECT password, email, username, profile_image, cv_file FROM accounts WHERE id = ?');
if ($stmt) {
    $stmt->bind_param('i', $_SESSION['id']);
    $stmt->execute();
    $stmt->bind_result($password, $email, $username, $profileImage, $cvFile);
    if (!$stmt->fetch()) {
        echo "<script>alert('No data found for this user.');</script>";
        $profileImage = 'default_profile.png'; // صورة افتراضية في حال عدم وجود صورة
        $cvFile = ''; // مسار افتراضي للـ CV في حال عدم وجود ملف
    }
    $stmt->close();
} else {
    echo "<script>alert('Failed to prepare statement: " . $con->error . "');</script>";
}

// التعامل مع تحديث الصورة الشخصية والـ CV
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $targetDirectory = "uploads/";

    // تحديث الصورة الشخصية
    if (isset($_FILES['new_profile_image']) && $_FILES['new_profile_image']['error'] == UPLOAD_ERR_OK) {
        $newProfileImage = $_FILES['new_profile_image']['name'];
        $targetFile = $targetDirectory . basename($newProfileImage);
        
        if (move_uploaded_file($_FILES['new_profile_image']['tmp_name'], $targetFile)) {
            $stmt = $con->prepare('UPDATE accounts SET profile_image = ? WHERE id = ?');
            $stmt->bind_param('si', $targetFile, $_SESSION['id']);
            $stmt->execute();
            $stmt->close();

            $profileImage = $targetFile;
        } else {
            echo "<script>alert('Error uploading file!');</script>";
        }
    }

    // تحديث الـ CV
    if (isset($_FILES['new_cv_file']) && $_FILES['new_cv_file']['error'] == UPLOAD_ERR_OK) {
        $newCVFile = $_FILES['new_cv_file']['name'];
        $targetFile = $targetDirectory . basename($newCVFile);
        
        if (move_uploaded_file($_FILES['new_cv_file']['tmp_name'], $targetFile)) {
            $stmt = $con->prepare('UPDATE accounts SET cv_file = ? WHERE id = ?');
            $stmt->bind_param('si', $targetFile, $_SESSION['id']);
            $stmt->execute();
            $stmt->close();

            $cvFile = $targetFile;
        } else {
            echo "<script>alert('Error uploading CV file!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Profile Page</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body class="loggedin">
<nav class="navtop">
    <div>
        <h1>Hello PHP!</h1>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
    </div>
</nav>
<div class="content">
    <h2>Profile Page</h2>
    <div>
        <p>Your account details are below:</p>
        <table>
            <tr>
                <td>Profile Image:</td>
                <td>
                    <img src="<?= htmlspecialchars($profileImage ?? 'default_profile.png', ENT_QUOTES) ?>?<?= time(); ?>" alt="Profile Image" style="width: 100px; height: auto;">
                </td>
            </tr>
            <tr>
                <td>Username:</td>
                <td><?= htmlspecialchars($username, ENT_QUOTES) ?></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><?= htmlspecialchars($email, ENT_QUOTES) ?></td>
            </tr>
            <tr>
                <td>CV:</td>
                <td>
                    <?php if (!empty($cvFile)): ?>
                        <a href="<?= htmlspecialchars($cvFile, ENT_QUOTES) ?>" target="_blank">Download CV</a>
                    <?php else: ?>
                        <p>No CV uploaded</p>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>

    <form action="" method="post" enctype="multipart/form-data">
        <label for="new_profile_image">Change Profile Image:</label>
        <input type="file" name="new_profile_image" accept="image/*">
        
        <label for="new_cv_file">Upload New CV:</label>
        <input type="file" name="new_cv_file" accept=".pdf,.doc,.docx">

        <button type="submit">Upload</button>
    </form>
</div>
</body>
</html>
