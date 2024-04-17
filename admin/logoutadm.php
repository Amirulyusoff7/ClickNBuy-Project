<?php
session_start();
unset($_SESSION["adminID"]);
unset($_SESSION["email"]);
header("Location:login.php");
?>