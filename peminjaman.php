<?php
    include "database.php";

    session_start();

    // if(isset($_POST['pinjam'])){
    //     $judulBuku = $_POST['judulBuku'];
    //     $judulBuku = mysqli_real_escape_string($db, $judulBuku);
        
    //     // Corrected SQL to fetch id_buku
    //     $pickIDQuery = "SELECT id_buku FROM buku WHERE judul = '$judulBuku'";
    //     $result = mysqli_query($db, $pickIDQuery);
        
    //     if ($result) {
    //         $row = mysqli_fetch_assoc($result);
    //         $idBuku = $row['id_buku'];
            
    //         // Use the fetched id_buku to delete the book
    //         $deleteQuery = "DELETE FROM buku WHERE id_buku = '$idBuku'";
    //         if (mysqli_query($db, $deleteQuery)) {
    //             $_SESSION['judulBuku']= $judulBuku;
    //             header("Location: dashboard.php");
    //             exit();
    //         } else {
    //             // Handle error in delete query execution
    //             echo "Error deleting book: ". mysqli_error($db);
    //         }
    //     } else {
    //         // Handle error in select query execution
    //         echo "Error fetching book id: ". mysqli_error($db);
    //     }
    // }
    if(isset($_POST['pinjam'])){
        // Memeriksa apakah sudah ada buku yang dipinjam dalam sesi
            $judulBuku = $_POST['judulBuku'];
            $durasiPinjam = $_POST['durasiPinjam'];
            $judulBuku = mysqli_real_escape_string($db, $judulBuku);
            $durasiPinjam = mysqli_real_escape_string($db, $durasiPinjam);
            // Corrected SQL to fetch id_buku
            $pickIDQuery = "SELECT id_buku FROM buku WHERE judul = '$judulBuku'";
            
            if ($result = mysqli_query($db, $pickIDQuery)) {
                $row = mysqli_fetch_assoc($result);
                $idBuku = $row['id_buku'];
                
                // Use the fetched id_buku to delete the book
                $deleteQuery = "DELETE FROM buku WHERE id_buku = '$idBuku'";
                if (mysqli_query($db, $deleteQuery)) {
                    $_SESSION['perpus-simpel'] = [
                        'judul' => $judulBuku, 
                        'durasi' => $durasiPinjam,
                        'borrow_time' => time(),
                    ];
                    echo "<script>alert('Buku berhasil dipinjam untuk $durasiPinjam hari.');</script>";
                    header("Location: dashboard.php");
                    exit();
                } else {
                    // Handle error in delete query execution
                    echo "Error deleting book: ". mysqli_error($db);
                }
            } else {
                // Handle error in select query execution
                echo "Error fetching book id: ". mysqli_error($db);
            }
        }

    if(isset($_SESSION["is_login"])){
        $ambilBuku = "SELECT * FROM buku";
        $result = mysqli_query($db, $ambilBuku);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="peminjaman.css">
</head>
<body>
<h1>Daftar Buku</h1>
<table>
    <thead>
        <tr>
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
            echo "<button type='submit' name='pinjam'>Pinjam</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>
