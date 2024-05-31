<?php
    include "database.php";

    $pesan_masuk = "";

    if(isset($_POST['daftar'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        try{
            $sql = "INSERT INTO anggota (username,password)
                                VALUES ('$username','$password')";
            if(mysqli_query($db, $sql)){
                $pesan_masuk = "daftar berhasil, silahkan login";
            }else{
                $pesan_masuk = "daftar gagal, coba lagi";
            }
            
        }catch(mysqli_sql_exception){
            $pesan_masuk = "username sudah terpakai, gunakan yang lain";
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
    <h3>SILAHKAN DAFTAR</h3>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <input type="text" placeholder="username" name="username">
        <input type="password" placeholder="password" name="password">
        <input type="submit" name="daftar" value="Daftar Sekarang">
    </form>
    <i><?= $pesan_masuk ?></i>
    
    <br>
    <br>

<?PHP include "footer.html"?>
</body>
</html>