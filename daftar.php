<?php
    include "database.php";
    session_start();
    $pesan_masuk = "";

    if(isset($_POST['daftar'])){
        $username = $_POST['username'];
       
        $password = $_POST['password'];

        if(empty($username) || empty($password)){
            $pesan_masuk = "Username dan password tidak boleh kosong";
        }else{
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
    }
    mysqli_close($db);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="daftar&masuk.css" />
    <link rel="stylesheet" href="header&footer.css" />
    
</head>
<body>
<nav class="navbar">
        <div class="logo-box">
            <img src="image/logo.png" />
            <p class="navbar-logo">Perpustakaan Kita</p>
        </div>
        <div class="navbar-nav">
            <a href="home.php">Beranda</a>
            <a href="masuk.php">Masuk</a>
            <a href="daftar.php">Daftar</a>
        </div>
    </nav>

    <main>
    <div class="content container-fluid bg-white py-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <h3 class="text-center text-primary">SILAHKAN DAFTAR</h3>
                
                <div class="login-form">
                    <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" placeholder="Username" name="username">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                        </div>
                        <button type="submit" name="daftar" class="btn btn-block">Daftar Sekarang</button>
                        <?php if(!empty($pesan_masuk)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $pesan_masuk ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </main>

    <footer>
        <img src="image/logo.png" />
        <p class="navbar-logo">Perpustakaan Kita</p>
        <p class="end"> @2024 All Right Reserved </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>