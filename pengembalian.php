<?php
include "database.php";
session_start();
$message = "";


// Memeriksa apakah form telah disubmit
if (isset($_POST['pengembalian'])) {
    $judul = mysqli_real_escape_string($db, $_POST['judul']);
    $pengarang = mysqli_real_escape_string($db, $_POST['pengarang']);
    $penerbit = mysqli_real_escape_string($db, $_POST['penerbit']);
    $cover = mysqli_real_escape_string($db, $_POST['cover']);

    if (isset($_SESSION['perpus-simpel'])) {
        $buku_dipinjam = $_SESSION['perpus-simpel'];
        if ($buku_dipinjam['judul'] == $judul) {
            $sql = "INSERT INTO buku (judul, pengarang, penerbit,cover) VALUES ('$judul', '$pengarang', '$penerbit', '$cover')";
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
    <link rel="stylesheet" href="header&footer.css" />
    <link rel="stylesheet" href="pengembalian.css" />
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
        <h1>Menu Pengembalian</h1>

        <table>
            <thead>
                <tr>
                    <th>Cover</th>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Penerbit</th>
                    <th>Deadline Pinjam</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_SESSION['perpus-simpel'])) {
                    $buku_dipinjam = $_SESSION['perpus-simpel'];

                    $borrowTime = $buku_dipinjam['borrow_time'];
                    $duration = $buku_dipinjam['durasi'];
                    $deadline = date('Y-m-d H:i:s', $borrowTime + ($duration * 86400)); // 86400 seconds in a day

                    echo "<tr>";
                    echo "<td><img src='" . htmlspecialchars($buku_dipinjam['coverBuku']) . "' alt='Cover Buku' width='100' height='150'></td>";
                    echo "<td>" . htmlspecialchars($buku_dipinjam["judul"]) . "</td>";
                    echo "<td>" . htmlspecialchars($buku_dipinjam["pengarangBuku"]) . "</td>";
                    echo "<td>" . htmlspecialchars($buku_dipinjam["penerbitBuku"]) . "</td>";
                    echo "<td>" . htmlspecialchars($deadline) . "</td>";
                    echo "<td>";
                    echo "<form method='post' action='" . htmlspecialchars($_SERVER['PHP_SELF']) . "'>";
                    echo "<input type='hidden' name='judul' value='" . htmlspecialchars($buku_dipinjam["judul"]) . "'>";
                    echo "<input type='hidden' name='pengarang' value='" . htmlspecialchars($buku_dipinjam["pengarangBuku"]) . "'>";
                    echo "<input type='hidden' name='penerbit' value='" . htmlspecialchars($buku_dipinjam["penerbitBuku"]) . "'>";
                    echo "<input type='hidden' name='cover' value='" . htmlspecialchars($buku_dipinjam["coverBuku"]) . "'>";
                    echo "<button class='pengembalian' name='pengembalian'>Kembalikan Buku</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                } else {
                    echo "<tr><td colspan='6' class='text-center'>Tidak ada buku yang dipinjam.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>

    <?php
    if (!empty($message)) {
        echo "<script>alert('$message');</script>";
    }
    ?>

    <footer>
        <img src="image/logo.png" />
        <p class="navbar-logo">Perpustakaan Kita</p>
        <p class="end"> @2024 All Right Reserved </p>
    </footer>

</body>

</html>