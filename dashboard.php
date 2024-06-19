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
</head>
<body>
<?php include "header.html"?>
    <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
        <input type="submit" name="keluar" value="Keluar Akun">
    </form>
    <h1>SELAMAT DATANG <?=$_SESSION["username"]?> DI DASHBOARD</h1>
    <h3>Silahkan Pilih Layanan Kami</h3>
    <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
        <input type="submit" name="peminjaman" value="PEMINJAMAN">
        <input type="submit" name="pengembalian" value="PENGEMBALIAN">
    </form>

<h1>DAFTAR BUKU DIPINJAM</h1>
<ul>
    <?php
    if (isset($_SESSION['perpus-simpel'])) {
        $buku_dipinjam = $_SESSION['perpus-simpel'];
        $borrowTime = $buku_dipinjam['borrow_time'];
        $duration = $buku_dipinjam['durasi'];
        $deadline = date('Y-m-d H:i:s', $borrowTime + ($duration * 86400)); // 86400 seconds in a day
        
        echo "<p>Buku: " . $buku_dipinjam['judul'] . " - Durasi: " . $buku_dipinjam['durasi'] . " hari</p>";
        echo "<p>Deadline: " . $deadline . "</p>";
    } else {
        echo "<p>Tidak ada buku yang dipinjam.</p>";
    }
   ?>
</ul>
 
<?php
    if (!empty($message)) {
        echo "<script>alert('$message');</script>";
    }
?>

<?php include "footer.html"?>
</body>
</html>