<?php
include "database.php";
session_start();
$message = "";

// Memeriksa apakah form telah disubmit
if (isset($_POST['pengembalian'])) {
    $judul = mysqli_real_escape_string($db, $_POST['judul']);
    $pengarang = mysqli_real_escape_string($db, $_POST['pengarang']);
    $penerbit = mysqli_real_escape_string($db, $_POST['penerbit']);

    if (isset($_SESSION['perpus-simpel'])) {
        $buku_dipinjam = $_SESSION['perpus-simpel'];
        if ($buku_dipinjam['judul'] == $judul) {
            $sql = "INSERT INTO buku (judul, pengarang, penerbit) VALUES ('$judul', '$pengarang', '$penerbit')";
            if (mysqli_query($db, $sql)) {
                unset($_SESSION['perpus-simpel']);
                $pesan_masuk = "BUKU BERHASIL DIKEMBALIKAN";
                header("Location: dashboard.php");
                exit();
            } else {
                $message = "BUKU GAGAL DIKEMBALIKAN: " . mysqli_error($db);
            }
        } else {
            $message = "BUKU YANG DIINPUT TIDAK COCOK";
        }
    } else {
        $message = "Belum Ada Buku Yang Dipinjam";
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
    <?=include "header.html" ?>

<h1>SELAMAT DATANG DI MENU PENGEMBALIAN</h1>
<?php
// Menampilkan judul buku yang dipinjam
if(isset($_SESSION['perpus-simpel'])) {
    $buku_dipinjam = $_SESSION['perpus-simpel'];
    $judul = $buku_dipinjam['judul'];
    echo "Judul Buku yang dipinjam";
    echo "<br><b>$judul<b>";
}else{
    echo "Tidak ada buku yang dipinjam.";
}
?>
<form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
    <input type="text" placeholder="masukkan judul" name="judul">
    <input type="text" placeholder="masukkan pengarang" name="pengarang">
    <input type="text" placeholder="masukkan penerbit" name="penerbit">
    <input type="submit" value="Kembalikan Buku" name="pengembalian">
</form>

<?php
    if (!empty($message)) {
        echo "<script>alert('$message');</script>";
    }
?>

</body>
</html>