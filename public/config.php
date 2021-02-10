<?php
define("HOST","localhost");
define("USER","root");
define("PASSWORD","");
define("DB","cars");
session_start();
$_SESSION['adminLogin'] = "admin@gmail.com";
$_SESSION['adminPassword'] = "admin";
?>