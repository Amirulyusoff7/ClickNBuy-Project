<?php
session_start();

unset($_SESSION["ses"]);
header("Location:custlogin.php");
?> 