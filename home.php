<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap');
    </style>
    <link rel="stylesheet" href="home.css" />
</head>

<body>
    <nav class="navbar">
        <div class="logo-box">
            <img src="image/logo.png" />
            <p class="navbar-logo">Perpustakaan Kita</p>
        </div>
        <div class="navbar-nav">
            <a href="home.php">Beranda</a>
            <a href="masuk.php">Masuk</a>
            <a href="daftar.php">Daftar</a>
        </div>
    </nav>
    
    <main> 
        <div class="container">
            <div class="wrapper">
                <img src="image\perpus1.jpg">
                <img src="image\perpus2.jpg">
                <img src="image\perpus3.jpg">
                <img src="image\perpus4.jpg">
            </div>
        </div>
        <div class="box-teks">
            <h1 class="teks-utama">SELAMAT DATANG</h1>
            <h1 >temukan dunia pengetahuan di setiap halaman buku</h1>
        </div>
    </main>

    <footer>
        <img src="image/logo.png" />
        <p class="navbar-logo">Perpustakaan Kita</p>
        <p class="end"> @2024 All Right Reserved </p>
    </footer>
</body>

</html>