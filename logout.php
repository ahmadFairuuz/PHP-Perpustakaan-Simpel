<?php

session_start();
session_unset();
session_destroy();
header("Location: home.php"); // Redirect to the login page or any other page
exit();
?>
