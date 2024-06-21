<?php
include "database.php";
session_start();
$message = "";

if (isset($_POST['keluar'])){
    session_destroy();
    header("location: home.php");
}

// MENGHAPUS BUKU DARI TABEL
if (isset($_POST['hapus'])) {
    $judulBuku = $_POST['judulBuku'];
    $judulBuku = mysqli_real_escape_string($db, $judulBuku);
    $pickIDQuery = "SELECT id_buku FROM buku WHERE judul = '$judulBuku'";
    if ($result = mysqli_query($db, $pickIDQuery)) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $idBuku = $row['id_buku'];
            $deleteQuery = "DELETE FROM buku WHERE id_buku = '$idBuku'";
            if (mysqli_query($db, $deleteQuery)) {
                $message = "Buku berhasil dihapus";
            } else {
                $message = "Buku gagal dihapus" . mysqli_error($db);
            }
        }
    } else {
        $message = "Gagal Mengambil Id Buku" . mysqli_error($db);
    }
}

// MENAMBAHKAN BUKU
if (isset($_POST['tambah'])) {
    $judul = mysqli_real_escape_string($db, $_POST['judul']);
    $pengarang = mysqli_real_escape_string($db, $_POST['pengarang']);
    $penerbit = mysqli_real_escape_string($db, $_POST['penerbit']);

    // Handle file upload
    if (isset($_FILES['cover']) && $_FILES['cover']['error'] == 0) {
        $cover = $_FILES['cover'];
        $target_dir = "uploads/";

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        $target_file = $target_dir . basename($cover["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file is an actual image
        $check = getimagesize($cover["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($cover["tmp_name"], $target_file)) {
                $coverPath = mysqli_real_escape_string($db, $target_file);
            } else {
                $message = "Sorry, there was an error uploading your file.";
            }
        } else {
            $message = "File is not an image.";
        }
    }

        $ambilJudul = "SELECT judul FROM buku WHERE judul = '$judul'";
        $result = mysqli_query($db, $ambilJudul);
        if ($result && mysqli_num_rows($result) == 0) {
            $tambahBuku = "INSERT INTO buku (judul, pengarang, penerbit, cover) VALUES ('$judul', '$pengarang', '$penerbit', '$coverPath')";
            if (mysqli_query($db, $tambahBuku)) {
                $message = "Buku berhasil ditambahkan";
            } else {
                $message = "Buku gagal ditambahkan" . mysqli_error($db);
            }
        } else {
            $message = "Sudah ada buku yang sama dalam database" . mysqli_error($db);
        }
    }

// MENAMPILKAN BUKU DI TABEL
$ambilBuku = "SELECT * FROM buku";
$result = mysqli_query($db, $ambilBuku);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h1,
        h3 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            text-align: center;
            margin-bottom: 30px;
        }

        input[type="text"] {
            padding: 10px;
            width: 200px;
            margin-right: 10px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4caf50;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <h1>SELAMAT DATANG ADMINISTRATOR</h1>

    <h3>DAFTAR BUKU</h3>
    <table>
        <thead>
            <tr>
                <th>Cover</th>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Penerbit</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($data = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td><img src='" . $data["cover"] . "' alt='Cover Buku' width='100' height='150'></td>";
                    echo "<td>" . $data["judul"] . "</td>";
                    echo "<td>" . $data["pengarang"] . "</td>";
                    echo "<td>" . $data["penerbit"] . "</td>";
                    echo "<td><form method='post' action='" . $_SERVER['PHP_SELF'] . "'>";
                    echo "<input type='hidden' name='judulBuku' value='" . $data["judul"] . "'>";
                    echo "<button type='submit' name='hapus'>Hapus Buku</button>";
                    echo "</form></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' style='text-align:center;'>Tidak ada buku dalam database</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <h3>MENU TAMBAH BUKU</h3>
    <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
        <input type="text" placeholder="masukkan judul" name="judul" required>
        <input type="text" placeholder="masukkan pengarang" name="pengarang" required>
        <input type="text" placeholder="masukkan penerbit" name="penerbit" required>
        <input type="file" placeholder="masukkan cover buku" name="cover" required/>
        <input type="submit" value="Tambahkan Buku" name="tambah">
    </form>
    
    <div class="content d-flex justify-content-center align-items-center vh-50">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <button type="submit" name="keluar" value="Keluar Akun" class="btn btn-danger">Keluar dari Akun</button>
        </form>
    </div>

    <?php
    if (!empty($message)) {
        echo "<script>alert('$message');</script>";
    }
    ?>

</body>

</html>