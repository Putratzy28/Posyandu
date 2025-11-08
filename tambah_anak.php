<?php
require_once 'db.php';
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = $_POST['nama'];
  $nik = $_POST['nik'];
  $tanggal_lahir = $_POST['tanggal_lahir'];
  $jenis_kelamin = $_POST['jenis_kelamin'];
  $nama_ortu = $_POST['nama_ortu'];
  $alamat = $_POST['alamat'];

  $sql = "INSERT INTO anak (nama, nik, tanggal_lahir, jenis_kelamin, nama_ortu, alamat)
          VALUES (?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssssss", $nama, $nik, $tanggal_lahir, $jenis_kelamin, $nama_ortu, $alamat);

  if ($stmt->execute()) {
    header("Location: anak.php");
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
  <title>Tambah Data Anak</title>
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
    <h2>Tambah Data Anak</h2>
    <form method="POST">
      <label for="nama">Nama Anak</label>
      <input type="text" id="nama" name="nama" required>

      <label for="nik">NIK</label>
      <input type="text" id="nik" name="nik" required>

      <label for="tanggal_lahir">Tanggal Lahir</label>
      <input type="date" id="tanggal_lahir" name="tanggal_lahir" required>

      <label for="jenis_kelamin">Jenis Kelamin</label>
      <select id="jenis_kelamin" name="jenis_kelamin" required>
        <option value="">-- Pilih Jenis Kelamin --</option>
        <option value="Laki-laki">Laki-laki</option>
        <option value="Perempuan">Perempuan</option>
      </select>

      <label for="nama_ortu">Nama Orang Tua</label>
      <input type="text" id="nama_ortu" name="nama_ortu" required>

      <label for="alamat">Alamat</label>
      <textarea id="alamat" name="alamat" required></textarea>

      <button type="submit">Simpan</button>
    </form>
    <div class="actions">
      <a href="anak.php" class="back-link">Kembali</a>
    </div>
  </div>
</body>
</html>
