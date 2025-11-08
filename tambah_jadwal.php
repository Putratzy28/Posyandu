<?php
require_once 'db.php';
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $tanggal = $_POST['tanggal'];
  $jenis_imunisasi = $_POST['jenis_imunisasi'];
  $lokasi = $_POST['lokasi'];

  $sql = "INSERT INTO jadwal (tanggal, jenis_imunisasi, lokasi)
          VALUES (?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sss", $tanggal, $jenis_imunisasi, $lokasi);

  if ($stmt->execute()) {
    header("Location: jadwal.php");
    exit();
  } else {
    echo "Error: " . $stmt->error;
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Jadwal</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f7f7f7; }
    .container { max-width: 400px; margin: 40px auto; background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 2px 8px #ccc; }
    h2 { text-align: center; }
    label { display: block; margin-top: 12px; }
    input[type="text"], input[type="date"], select, textarea {
      width: 100%; padding: 8px; margin-top: 4px; border: 1px solid #ccc; border-radius: 4px;
    }
    textarea { resize: vertical; }
    button { margin-top: 16px; width: 100%; padding: 10px; background: #27ae60; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
    button:hover { background: #219150; }
    .actions { display: flex; justify-content: space-between; align-items: center; margin-top: 16px; }
    .back-link { color: #007bff; text-decoration: none; }
    .back-link:hover { text-decoration: underline; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Tambah Jadwal</h2>
    <form method="POST">
      <label for="tanggal">Tanggal Imunisasi</label>
      <input type="date" id="tanggal" name="tanggal" required>

      <label for="jenis_imunisasi">Jenis Imunisasi</label>
      <input type="text" id="jenis_imunisasi" name="jenis_imunisasi" required>

      <label for="lokasi">Lokasi</label>
      <input type="text" id="lokasi" name="lokasi" required>

      <button type="submit">Simpan</button>
    </form>
    <div class="actions">
      <a href="jadwal.php" class="back-link">Kembali</a>
    </div>
  </div>
</body>
</html>
