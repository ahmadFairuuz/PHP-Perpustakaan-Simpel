<?php
include "database.php";
session_start();

if (isset($_SESSION["is_login"])) {
    header("location: dashboard.php");
}

if (isset($_POST['masuk'])) {
    if (!empty($_POST['password']) && !empty($_POST['username'])) {
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password = mysqli_real_escape_string($db, $_POST['password']);

        $sql = "SELECT * FROM anggota WHERE username = '$username'";
        $result = mysqli_query($db, $sql);
        $data = mysqli_fetch_assoc($result);

        if ($data) {
            if ($data['password'] === $password) {
                // LOGIN UNTUK ADMIN
                if ($username === 'admin' && $password === 'admin') {
                    header("Location: admin.php");
                } else {
                    $_SESSION['username'] = $data['username'];
                    $_SESSION['is_login'] = true;
                    header("Location: dashboard.php");
                }
            } else {
                $error_password = "Maaf password yang anda masukkan salah";
            }
        } else {
            $error_username = "Maaf username yang anda masukkan salah";
        }
    } else {
        $error_empty = "username dan password tidak boleh kosong";
    }
}
mysqli_close($db);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="header&footer.css" />
    <link rel="stylesheet" href="daftar&masuk.css" />
    <link rel="stylesheet" href="masuk.css" />
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
        <div class="content container-fluid bg-white py-5">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <h3 class="text-center text-primary">LOGIN PERPUSTAKAAN</h3>
                    <div class="login-form">
                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label text-white fw-bold">Username</label>
                                <input type="text" class="form-control" id="username" placeholder="Username" name="username">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label text-white fw-bold">Password</label>
                                <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                            </div>
                            <button type="submit" name="masuk" class="btn btn-primary">Masuk Sekarang</button>
                        </form>
                        <?php if (isset($error_username)) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $error_username; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($error_password)) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $error_password; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($error_empty)) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $error_empty; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <img src="image/logo.png" />
        <p class="navbar-logo">Perpustakaan Kita</p>
        <p class="end"> @2024 All Right Reserved </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>