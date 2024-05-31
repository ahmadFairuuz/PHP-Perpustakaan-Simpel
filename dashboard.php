<?php
    session_start();

    if (isset($_POST['keluar'])){
        session_destroy();
        header("location: home.php");
    }

    if(isset($_POST['peminjaman'])){
        if(isset($_SESSION['judulBuku'])){
            echo "MAKSIMAL PEMINJAMAN 1 BUKU";
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
<?= include "header.html"?>
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
    <p><?php echo $_SESSION['judulBuku']?><p>

<?= include "footer.html"?>
</body>
</html>

<?php


    echo "daftar buku dipinjam"
?>