<?php
require_once 'db.php';
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM anak WHERE id = $id");
$data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = $_POST['nama'];
  $nik = $_POST['nik'];
  $tanggal_lahir = $_POST['tanggal_lahir'];
  $jenis_kelamin = $_POST['jenis_kelamin'];
  $nama_ortu = $_POST['nama_ortu'];
  $alamat = $_POST['alamat'];

  $sql = "UPDATE anak SET nama = ?, nik = ?, tanggal_lahir = ?, jenis_kelamin = ?, nama_ortu = ?, alamat = ? WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssssssi", $nama, $nik, $tanggal_lahir, $jenis_kelamin, $nama_ortu, $alamat, $id);

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
  <title>Edit Data Anak</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f7f7f7; }
    .container { max-width: 400px; margin: 40px auto; background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 2px 8px #ccc; }
    h2 { text-align: center; }
    label { display: block; margin-top: 12px; }
    input[type="text"], input[type="date"], select, textarea {
      width: 100%; padding: 8px; margin-top: 4px; border: 1px solid #ccc; border-radius: 4px;
    }
    textarea { resize: vertical; }
    button { margin-top: 16px; width: 100%; padding: 10px; background: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
    button:hover { background: #0056b3; }
    .actions { display: flex; justify-content: space-between; align-items: center; margin-top: 16px; }
    .delete-link { color: #dc3545; text-decoration: none; }
    .delete-link:hover { text-decoration: underline; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Edit Data Anak</h2>
    <form method="POST">
      <label for="nama">Nama Anak</label>
      <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>

      <label for="nik">NIK</label>
      <input type="text" id="nik" name="nik" value="<?= htmlspecialchars($data['nik']) ?>" required>

      <label for="tanggal_lahir">Tanggal Lahir</label>
      <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="<?= htmlspecialchars($data['tanggal_lahir']) ?>" required>

      <label for="jenis_kelamin">Jenis Kelamin</label>
      <select id="jenis_kelamin" name="jenis_kelamin" required>
        <option value="Laki-laki" <?= $data['jenis_kelamin'] === 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
        <option value="Perempuan" <?= $data['jenis_kelamin'] === 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
      </select>

      <label for="nama_ortu">Nama Orang Tua</label>
      <input type="text" id="nama_ortu" name="nama_ortu" value="<?= htmlspecialchars($data['nama_ortu']) ?>" required>

      <label for="alamat">Alamat</label>
      <textarea id="alamat" name="alamat" required><?= htmlspecialchars($data['alamat']) ?></textarea>

      <button type="submit">Simpan</button>
    </form>
    <div class="actions">
      <a href="anak.php" style="color:#007bff;">Kembali</a>
      <a href="anak.php?hapus=<?= $data['id'] ?>" class="delete-link" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
    </div>
  </div>
</body>
</html>