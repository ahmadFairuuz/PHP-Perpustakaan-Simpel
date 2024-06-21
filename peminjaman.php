<?php
include "database.php";

session_start();

if (isset($_POST['pinjam'])) {
    // Memeriksa apakah sudah ada buku yang dipinjam dalam sesi
    $judulBuku = $_POST['judulBuku'];
    $durasiPinjam = $_POST['durasiPinjam'];
    $judulBuku = mysqli_real_escape_string($db, $judulBuku);
    $durasiPinjam = mysqli_real_escape_string($db, $durasiPinjam);
    // Corrected SQL to fetch id_buku
    $pickIDQuery = "SELECT id_buku,pengarang,penerbit,cover FROM buku WHERE judul = '$judulBuku'";

    if ($result = mysqli_query($db, $pickIDQuery)) {
        $row = mysqli_fetch_assoc($result);
        $idBuku = $row['id_buku'];
        $pengarang = $row['pengarang'];
        $penerbit = $row['penerbit'];
        $cover = $row['cover'];
        // Use the fetched id_buku to delete the book
        $deleteQuery = "DELETE FROM buku WHERE id_buku = '$idBuku'";
        if (mysqli_query($db, $deleteQuery)) {
            $_SESSION['perpus-simpel'] = [
                'judul' => $judulBuku,
                'pengarangBuku' => $pengarang,
                'penerbitBuku' => $penerbit,
                'coverBuku' => $cover,
                'durasi' => $durasiPinjam,
                'borrow_time' => time(),
            ];
            echo "<script>alert('Buku berhasil dipinjam untuk $durasiPinjam hari.');</script>";
            header("Location: dashboard.php");
            exit();
        } else {
            // Handle error in delete query execution
            echo "Error deleting book: " . mysqli_error($db);
        }
    } else {
        // Handle error in select query execution
        echo "Error fetching book id: " . mysqli_error($db);
    }
}

if (isset($_SESSION["is_login"])) {
    $ambilBuku = "SELECT * FROM buku";
    $result = mysqli_query($db, $ambilBuku);
}

if (isset($_POST['keluar'])){
    session_destroy();
    header("location: home.php");
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap');
    </style>
    <link rel="stylesheet" href="peminjaman.css" />
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
            <a href="dashboard.php">Dashboard </a>
            <a class="keluar" href="logout.php">Keluar</a>
            <p >Halo <span><?=$_SESSION["username"]?></span></p>
        </div>
    </nav>

    <main>
        <h1>Daftar Buku</h1>
        <table>
            <thead>
                <tr>
                    <th>Cover</th>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Penerbit</th>
                    <th>Durasi Pinjam</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($data = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td><img src='" . $data["cover"] . "' alt='Cover Buku' width='100' height='150'></td>";
                    echo "<td>" . $data["judul"] . "</td>";
                    echo "<td>" . $data["pengarang"] . "</td>";
                    echo "<td>" . $data["penerbit"] . "</td>";
                    echo "<td>";
                    echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . "'>";
                    echo "<select name='durasiPinjam' required>";
                    echo "<option value='3'>3 Hari</option>";
                    echo "<option value='5'>5 Hari</option>";
                    echo "<option value='7'>7 Hari</option>";
                    echo "</select>";
                    echo "</td>";
                    echo "<td>";
                    echo "<input type='hidden' name='judulBuku' value='" . $data["judul"] . "'>";
                    echo "<button class='pinjam' name='pinjam'>Pinjam Buku</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </main>

    <footer>
        <img src="image/logo.png" />
        <p class="navbar-logo">Perpustakaan Kita</p>
        <p class="end"> @2024 All Right Reserved </p>
    </footer>

</body>

</html>