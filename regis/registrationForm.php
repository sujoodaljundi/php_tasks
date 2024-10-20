<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
 
</head>

<body>
    <?php

    session_start();

    if($_SERVER["REQUEST_METHOD"]=="POST"){
         if(!isset($_SESSION["users"]))
         {
         $_SESSION['users']=[];
        }
        $name=$_POST['name'];
        $email=$_POST['email'];
        $password=$_POST['password'];

        $newUser=[
            "name"=>$name,
            "email"=>$email,
            "password"=>$password,
        ];
        $_SESSION["users"][]=$newUser;
        if (isset($_POST['delete'])) {
            unset($_SESSION['users']);
        }     }  
    ?>


    <form method="POST">
        Name: <input type="text" name="name" required><br>
        E-mail: <input type="email" name="email" required><br>
        password: <input type="password" name="password" required><br>
        <input type="submit" value="Submit">
    </form>


</body>
</html>