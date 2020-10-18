<?php
ini_set('default_charset', 'UTF-8');
$conn = mysqli_connect('localhost', 'userweb', 'S3nh@L0c@1', 'projetofinal2');

require_once("Database.php");
$db = new Database('projetofinal2', 'userweb', 'S3nh@L0c@1');
?>