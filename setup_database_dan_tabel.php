<?php
$host = 'localhost';
$user = 'root';
$pass = '';

// buat koneksi
$conn = new mysqli($host, $user, $pass);

// cek koneksi
if ($conn->connect_error) {
    die('koneksi gagal:'. $conn->connect_error);
}

// buat database
$sql = 'CREATE DATABASE IF NOT EXISTS uts5a';
if ($conn->query($sql) === TRUE) {
    echo 'Database berhasil dibuat<br>';
} else {
    echo 'Error membuat database : ' . $conn->error . "<br>"; 
}

// pilih database
$conn->select_db("uts5a");

//buat tabel
$sql = "CREATE TABLE IF NOT EXISTS krs (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    nim CHAR(10) NOT NULL,
    kelas ENUM('5A','5B','5C','5D','5E') NOT NULL,
    makul VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Tabel berhasil dibuat<br>";
} else {
    echo "Error membuat tabel: ". $conn->error ."<br>";
}

$conn->close();
?>