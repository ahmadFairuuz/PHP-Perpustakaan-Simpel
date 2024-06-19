<?php
    include "database.php";
    session_start();

    if(isset($_SESSION["is_login"])){
        header("location: dashboard.php");
    }

    if(isset($_POST['masuk'])){
        if(!empty($_POST['password']) && !empty($_POST['username'])){
            $username = $_POST['username'];
            $password = $_POST['password'];

            $sql = "SELECT * FROM anggota WHERE username = '$username' 
                                            AND password = '$password'";
                                            
            $result = mysqli_query($db , $sql);
            if($data = mysqli_fetch_assoc($result)){

                // LOGIN UNTUK ADMIN
                if ($username === 'admin' && $password === 'admin') {
                    header("Location: admin.php");
                }else{
                    $_SESSION['username'] = $data['username'];
                    $_SESSION['is_login'] = true;
                    header("Location: dashboard.php");
                }
            }
        }
        else{
             echo "username dan password tidak boleh kosong";
        }
    }
    mysqli_close($db);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?PHP include "header.html"?>
    <h3>LOGIN DISINI </h3>
    <div>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <input type="text" placeholder="username" name="username">
        <input type="password" placeholder="password" name="password">
        <input type="submit" name="masuk" value="Masuk Sekarang">
    </form>
    </div>
    
<?PHP include "footer.html"?>
</body>
</html>