<?php
    include "database.php";
    session_start();
    $message = "";

    if (isset($_POST['keluar'])){
        session_destroy();
        header("location: home.php");
    }

    if(isset($_POST['peminjaman'])){
        if(isset($_SESSION['perpus-simpel'])){
            $message = "MAKSIMAL PEMINJAMAN 1 BUKU";
        }else{
            header("location: peminjaman.php");
        }   
    }

    if(isset($_POST['pengembalian'])){
            header("location: pengembalian.php");
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="header&footer.css" />
    <link rel="stylesheet" href="dashboard.css" />
    
</head>
<body>
<nav class="navbar">
        <div class="logo-box">
            <img src="image/logo.png" />
            <p class="navbar-logo">Perpustakaan Kita</p>
        </div>
        <div class="navbar-nav">
            <a href="home.php">Beranda</a>
            <a href="dashboard.php">Dashboard </a>
            <a class="keluar" href="logout.php">Keluar</a>
            <p >Halo <span><?=$_SESSION["username"]?></span></p>
        </div>
    </nav>

    <main>
    <div class=" container mt-5">
        <h1 class="text-center">SELAMAT DATANG <span><?=$_SESSION["username"]?></span> DI DASHBOARD</h1>
        <h3 class="text-center mb-4">Silahkan Pilih Layanan Kami</h3>
        <form method="post" action="<?php $_SERVER['PHP_SELF']?>">
            <div class="text-center">
                <button type="submit" name="peminjaman" value="PEMINJAMAN" class="btn btn-primary mx-2">PEMINJAMAN</button>
                <button type="submit" name="pengembalian" value="PENGEMBALIAN" class="btn btn-secondary mx-2">PENGEMBALIAN</button>
            </div>
        </form>

        <h1 class=" mt-5">DAFTAR BUKU DIPINJAM</h1>
        <ul class="list-group">
            <?php
            if (isset($_SESSION['perpus-simpel'])) {
                $buku_dipinjam = $_SESSION['perpus-simpel'];
                $borrowTime = $buku_dipinjam['borrow_time'];
                $duration = $buku_dipinjam['durasi'];
                $deadline = date('Y-m-d H:i:s', $borrowTime + ($duration * 86400)); // 86400 seconds in a day
                
                echo "<li class='list-group-item'>Buku: ". $buku_dipinjam['judul']. " - Durasi: ". $buku_dipinjam['durasi']. " hari</li>";
                echo "<li class='list-group-item'>Deadline: ". $deadline. "</li>";
            } else {
                echo "<li class='list-group-item'>Tidak ada buku yang dipinjam.</li>";
            }
          ?>
        </ul>
 
        <?php
            if (!empty($message)) {
                echo "<script>alert('$message');</script>";
            }
       ?>
    </div>
    </main>

    <footer>
        <img src="image/logo.png" />
        <p class="navbar-logo">Perpustakaan Kita</p>
        <p class="end"> @2024 All Right Reserved </p>
    </footer>
</body>
</html>



