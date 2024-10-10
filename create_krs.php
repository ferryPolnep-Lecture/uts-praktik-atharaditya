<?php
require_once "koneksi_db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // validasi input
    
    $nama = trim($_POST['name']);
    $nim = trim($_POST['nim']);
    $kelas = $_POST['kelas'] ?? '';
    $makul = isset($_POST['makul']) ? $_POST['makul'] : [];

    $errors = [];

    // validasi nama (hanya huruf)
    if (empty($nama) || !preg_match("/^[a-zA-Z ]*$/", $nama)) {
        $errors[] = "Nama hanya boleh berisi huruf";
    }

    // validasi NIM (10digit angka)
    if (empty($nim) || !preg_match("/^[0-9]{10}$/", $nim)) {
        $errors[] = "NIM harus berisi 10 digit angka";
    }

    // validasi kelas
    if (empty($kelas)) {
        $errors[] = "Kelas harus dipilih";
    }

     // Validasi makul
     if (empty($makul)) {
        $errors[] = "Minimal satu mata kuliah harus dipilih";
    }

    if (empty($errors)) {
        // Konversi array makul menjadi string
        $makul_str = implode(", ", $makul);

        // query insert
        $sql = "INSERT INTO krs (nama, nim, kelas, makul) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nama, $nim, $kelas, $makul_str);

        if ($stmt->execute()) {
            header("Location: index.php?status=success");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        // tampilan error
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
}

$conn->close();
?>