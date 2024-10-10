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
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
<style>
     /* Reset beberapa elemen dasar */
     * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f8;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #34495e;
        }

        form input[type="text"],
        form input[type="radio"],
        form input[type="checkbox"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #dcdcdc;
            border-radius: 4px;
            font-size: 16px;
        }

        form input[type="radio"],
        form input[type="checkbox"] {
            width: auto;
            margin-right: 10px;
        }

        .radio-group,
        .checkbox-group {
            margin-bottom: 15px;
        }

        .radio-group label,
        .checkbox-group label {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            font-weight: 400;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .button-group input[type="submit"],
        .button-group a {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button-group input[type="submit"] {
            background-color: #3498db;
            color: #ffffff;
        }

        .button-group input[type="submit"]:hover {
            background-color: #2980b9;
        }

        .button-group a {
            background-color: #95a5a6;
            color: #ffffff;
            text-align: center;
        }

        .button-group a:hover {
            background-color: #7f8c8d;
        }

        /* Responsif */
        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }
        }
</style>
<body>

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