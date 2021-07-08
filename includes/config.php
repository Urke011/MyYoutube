<?php
ob_start();
session_start();
date_default_timezone_set("Europe/Berlin");

try {
  $con = new PDO("mysql:host=localhost;dbname=myYoutube","root","");
  $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
} catch (PDOException $e) {

echo "Connection faild: ". $e->getMessage();
}

 ?>
