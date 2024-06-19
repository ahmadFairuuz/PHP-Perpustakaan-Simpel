<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database_name = "perpuss";

    try{
        $db = mysqli_connect($hostname, 
                                $username, 
                                $password, 
                                $database_name);
    }catch(mysqli_sql_exception){
        echo "Koneksi Database Gagal";
    }
?>