<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'uts5a';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>