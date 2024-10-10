<?php
require_once "koneksi_db.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "DELETE FROM krs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: index.php?status=deleted");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
} else {
    die("ID tidak ditemukan");
}

$conn->close();
?>