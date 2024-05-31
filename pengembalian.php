<?php
    include "database.php";
    session_start();

    $pesan_masuk = "";

    if(isset($_SESSION['judulBuku'])){
        if($_SESSION['judulBuku'] == $judul){
            $sql = "INSERT INTO buku (judul,pengarang,penerbit)
                                VALUES ('$judul','$pengarang','$penerbit')";
            if(mysqli_query($db, $sql)){
                $pesan_masuk = "BUKU BERHASIL DIKEMBALIKAN";
            }else{
                $pesan_masuk = "BUKU GAGAL DIKEMBALIKAN";
            }
        }else{
            $pesan_masuk = "BUKU YANG DIINPUT TIDAK COCOK";
        }
    }else{
        $pesan_pengembalian =  "Belum Ada Buku Yang Dipinjam";
    }

    if(isset($_POST['pengembalian'])){
        $judul = $_POST['judul'];
        $pengarang = $_POST['pengarang'];
        $penerbit = $_POST['penerbit'];
        
        

        // try{
            
            
        // }catch(mysqli_sql_exception){
        //     $pesan_masuk = "username sudah terpakai, gunakan yang lain";
        // }
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
    <h3><?php echo $pesan_pengembalian  ?></h3>
    <?php echo $_SESSION['judulBuku']; ?><br><br>
    <h1>SELAMAT DATANG DI MENU PENGEMBALIAN</h1>
    <?php echo $pesan_masuk ?>
    <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
        <input type="text" placeholder="masukkan judul" name="judul">
        <input type="text" placeholder="masukkan pengarang" name="pengarang">
        <input type="text" placeholder="masukkan penerbit" name="penerbit">
        <input type="submit" value="Kembalikan Buku" name="pengembalian">
    </form>
</body>
</html>
<?php
 unset($_SESSION['judulBuku']);
?>