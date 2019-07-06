<?php
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
if ($mysqli->connect_error) {
    header("Location: ./error.php?err=No se puede conectar");
    exit();
}