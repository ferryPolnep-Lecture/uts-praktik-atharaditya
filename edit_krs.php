<?php
require_once "koneksi_db.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM krs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    
    if (!$data) {
        die("Data tidak ditemukan");
    }
    
    $selected_makul = explode(", ", $data['makul']);
} else {
    die("ID tidak ditemukan");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit KRS</title>
</head>
<body>
    <h2>Edit KRS</h2>
    <form action="update_krs.php" method="post">
    <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
        
        <label for="name">Nama Mahasiswa: </label><br>
        <input type="text" name="name" value="<?php echo htmlspecialchars($data['nama']); ?>"><br>
        
        <label for="nim">NIM: </label><br>
        <input type="text" name="nim" value="<?php echo htmlspecialchars($data['nim']); ?>"><br>

        <label for="kelas">Kelas: </label><br>
        <?php
        $kelas_options = ['5A', '5B', '5C', '5D', '5E'];
        foreach ($kelas_options as $kelas) {
            $checked = ($data['kelas'] == $kelas) ? 'checked' : '';
            echo "<input type='radio' name='kelas' value='$kelas' $checked>Kelas $kelas<br>";
        }
        ?>

        <label for="makul">Mata Kuliah Pilihan: </label><br>
        <?php
        $makul_options = [
            'WebApp' => 'Web Application Development',
            'MobileApp' => 'Mobile Application Development',
            'UI/UX' => 'UI/UX Design',
            'SoftEng' => 'Software Engineering',
            'DataEng' => 'Data Engineering'
        ];
        
        foreach ($makul_options as $value => $label) {
            $checked = in_array($value, $selected_makul) ? 'checked' : '';
            echo "<input type='checkbox' name='makul[]' value='$value' $checked>$label<br>";
        }
        ?>
        <br>
        <input type="submit" value="Update KRS">
        <a href="index.php">Kembali</a>
    </form>
</body>
</html>