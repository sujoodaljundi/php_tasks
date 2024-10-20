<?php 
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $email = $_POST['email'];

    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: home.php');
    exit;
}

    // Handle profile image upload
    $profileImagePath = null; 
    $allowedImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxFileSize = 2 * 1024 * 1024; 

    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
        $fileType = $_FILES['profile_image']['type'];
        $fileSize = $_FILES['profile_image']['size'];

        if (in_array($fileType, $allowedImageTypes) && $fileSize <= $maxFileSize) {
            $profileImagePath = $targetDir . basename($_FILES['profile_image']['name']);
            if (!move_uploaded_file($_FILES['profile_image']['tmp_name'], $profileImagePath)) {
                echo "<script>alert('Error uploading profile image!');</script>";
                exit; 
            }
        } else {
            if ($fileSize > $maxFileSize) {
                echo "<script>alert('Profile image size exceeds the maximum limit of 2MB!');</script>";
            } else {
                echo "<script>alert('Only JPG, PNG, and GIF files are allowed for profile image!');</script>";
            }
            exit; 
        }
    }

    // Handle CV upload
    $cvFilePath = null; 
    $allowedCVTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']; // PDF, DOC, DOCX
    $maxCVFileSize = 5 * 1024 * 1024; // 5MB

    if (isset($_FILES['cv_file']) && $_FILES['cv_file']['error'] == UPLOAD_ERR_OK) {
        $cvFileType = $_FILES['cv_file']['type'];
        $cvFileSize = $_FILES['cv_file']['size'];

        if (in_array($cvFileType, $allowedCVTypes) && $cvFileSize <= $maxCVFileSize) {
            $cvFilePath = $targetDir . basename($_FILES['cv_file']['name']);
            if (!move_uploaded_file($_FILES['cv_file']['tmp_name'], $cvFilePath)) {
                echo "<script>alert('Error uploading CV!');</script>";
                exit; 
            }
        } else {
            if ($cvFileSize > $maxCVFileSize) {
                echo "<script>alert('CV file size exceeds the maximum limit of 5MB!');</script>";
            } else {
                echo "<script>alert('Only PDF, DOC, and DOCX files are allowed for CV!');</script>";
            }
            exit; 
        }
    }

    $servername = "localhost";
    $db_username = "root"; 
    $db_password = ""; 
    $dbname = "phplogin"; 

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    $stmt = $conn->prepare("SELECT * FROM accounts WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Username already exists!');</script>";
    } else {
        $sql = "INSERT INTO accounts (username, password, email, profile_image, cv_file) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $username, $password, $email, $profileImagePath, $cvFilePath);
        
        if ($stmt->execute()) {
            echo "<script>alert('New record created successfully');</script>";
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $email; // يمكنك حفظ البريد الإلكتروني في الجلسة
            $_SESSION['username'] = $username; // حفظ اسم المستخدم في الجلسة
            header('Location: home.php'); // توجيه المستخدم إلى الصفحة الرئيسية
            exit;
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="signup">
        <h1>Sign Up</h1>
        <form action="signup.php" method="post" enctype="multipart/form-data">
            <label for="username">
                <i class="fas fa-user"></i>
            </label>
            <input type="text" name="username" placeholder="Username" id="username" required>
            <label for="email">
                <i class="fas fa-envelope"></i>
            </label>
            <input type="email" name="email" placeholder="Email" id="email" required>
            <label for="password">
                <i class="fas fa-lock"></i>
            </label>
            <input type="password" name="password" placeholder="Password" id="password" required>
            <div class="input-container">
        <label for="profile_image">
            <i class="fas fa-image"></i>
        </label>
        <input type="file" name="profile_image" id="profile_image" accept="image/*">
    </div>

    <!-- CV -->
    <div class="input-container">
        <label for="cv_file">
            <i class="fas fa-file-alt"></i> Upload CV:
        </label>
        <input type="file" name="cv_file" id="cv_file" accept=".pdf,.doc,.docx" required>
    </div>

            <input type="submit" value="Sign Up">
        </form>
        <a href="index.html" class="signup-button">Sign In</a>
    </div>
    <script>
        function validatePassword(password) {
            const regex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{7,}$/;
            return regex.test(password);
        }

        document.querySelector('form').addEventListener('submit', function(event) {
            const passwordInput = document.querySelector('#password');
            if (!validatePassword(passwordInput.value)) {
                event.preventDefault();
                alert("Password must contain at least 7 characters, including at least one letter, one number, and one special character.");
            }
        });
    </script>
</body>
</html>