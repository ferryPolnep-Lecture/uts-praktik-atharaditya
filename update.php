<?php
require_once "koneksi_db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama = trim($_POST['name']);
    $nim = trim($_POST['nim']);
    $kelas = $_POST['kelas'] ?? '';
    $makul = isset($_POST['makul']) ? $_POST['makul'] : [];
    
    $errors = [];

    // Validasi nama
    if (empty($nama) || !preg_match("/^[a-zA-Z ]*$/", $nama)) {
        $errors[] = "Nama hanya boleh berisi huruf";
    }

    // Validasi NIM
    if (empty($nim) || !preg_match("/^[0-9]{10}$/", $nim)) {
        $errors[] = "NIM harus berisi 10 digit angka";
    }

    // Validasi kelas
    if (empty($kelas)) {
        $errors[] = "Kelas harus dipilih";
    }

    // Validasi makul
    if (empty($makul)) {
        $errors[] = "Minimal satu mata kuliah harus dipilih";
    }

    if (empty($errors)) {
        $makul_str = implode(", ", $makul);
        
        $sql = "UPDATE krs SET nama=?, nim=?, kelas=?, makul=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $nama, $nim, $kelas, $makul_str, $id);
        
        if ($stmt->execute()) {
            header("Location: index.php?status=updated");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
}

$conn->close();
?>