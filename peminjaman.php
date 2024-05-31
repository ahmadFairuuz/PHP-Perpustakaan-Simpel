<?php
    include "database.php";

    session_start();

    if(isset($_POST['pinjam'])){
        $judulBuku = $_POST['judulBuku'];
        $judulBuku = mysqli_real_escape_string($db, $judulBuku);
        
        // Corrected SQL to fetch id_buku
        $pickIDQuery = "SELECT id_buku FROM buku WHERE judul = '$judulBuku'";
        $result = mysqli_query($db, $pickIDQuery);
        
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $idBuku = $row['id_buku'];
            
            // Use the fetched id_buku to delete the book
            $deleteQuery = "DELETE FROM buku WHERE id_buku = '$idBuku'";
            if (mysqli_query($db, $deleteQuery)) {
                $_SESSION['judulBuku']= $judulBuku;
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

    if(isset($_SESSION["is_login"])){
        $sql = "SELECT * FROM buku";
        
        $result = mysqli_query($db , $sql);

            while($data = mysqli_fetch_assoc($result)){
                $_SESSION['buku'] = $data['judul'];
                // echo $data["judul"]. "<br>". "penulis :" . $data["pengarang"] ."<br>".
                //                                 "penerbit :" .$data["penerbit"]."<br>";
                // echo "<br>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1><?php echo $data['judul'] ?></h1>
    <p>Pengarang >>> <?php echo $data['pengarang'] ?><p>
    <p>Penerbit >>> <?php echo $data['penerbit'] ?></p>
<?php 
    }
    
}
?>
    <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
        <br>Masukkan Judul Buku Yang Akan Dipinjam <br>
        <input type="text" placeholder="judul buku" name="judulBuku">
        <input type="submit" name="pinjam" value="Pinjam Buku">
    </form>
</body>
</html>
