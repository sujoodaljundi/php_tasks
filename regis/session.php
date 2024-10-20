<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1Htd1nE3iB7VBIK" crossorigin="anonymous">

    <title>Document</title>
</head>
<style>
    #userTable{
        display:none;
    }

</style>
<body>
    
<?php
session_start();

if (isset($_SESSION['users']) && count($_SESSION['users']) > 0) {
    if (isset($_SESSION['users']) && count($_SESSION['users']) > 0) {
      

    echo "<table border='1' id=userTable class=table table-dark table-striped-columns>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Password</th>
            </tr>";
    
    foreach ($_SESSION['users'] as $user) {
        echo "<tr>
                <td>" . htmlspecialchars($user['name']) . "</td>
                <td>" . htmlspecialchars($user['email']) . "</td>
                <td>" . htmlspecialchars($user['password']) . "</td>
              </tr>";
    }
    
    echo "</table>";
} else {
    echo "No data stored.";
}
echo "<button onclick='toggleTable()'>Hide</button>";
}
?>
<script>
        function toggleTable() {
            const table = document.getElementById('userTable');
            if (table.style.display === 'none') {
                table.style.display = 'table';
            } else {
                table.style.display = 'none'; 
            }
        }
    </script>
</body>
</html>