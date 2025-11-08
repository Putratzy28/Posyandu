<?php
require_once 'db.php';
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

if (!isset($_GET['id'])) {
  header("Location: imunisasi.php");
  exit();
}

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM imunisasi WHERE id = $id");
$data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $jenis_imunisasi = $_POST['jenis_imunisasi'];
  $tanggal = $_POST['tanggal'];
  $berat = $_POST['berat'];
  $tinggi = $_POST['tinggi'];
  $petugas = $_POST['petugas'];
  $keterangan = $_POST['keterangan'];

  $sql = "UPDATE imunisasi SET jenis_imunisasi = ?, tanggal = ?, berat = ?, tinggi = ?, petugas = ?, keterangan = ? WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssddssi", $jenis_imunisasi, $tanggal, $berat, $tinggi, $petugas, $keterangan, $id);

  if ($stmt->execute()) {
    header("Location: imunisasi.php");
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
  <title>Edit Data Imunisasi</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f7f7f7; }
    .container { max-width: 400px; margin: 40px auto; background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 2px 8px #ccc; }
    h2 { text-align: center; }
    label { display: block; margin-top: 12px; }
    input[type="text"], input[type="date"], input[type="number"], textarea {
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
    <h2>Edit Data Imunisasi</h2>
    <form method="POST">
      <label for="jenis_imunisasi">Jenis Imunisasi</label>
      <input type="text" id="jenis_imunisasi" name="jenis_imunisasi" value="<?= htmlspecialchars($data['jenis_imunisasi']) ?>" required>

      <label for="tanggal">Tanggal</label>
      <input type="date" id="tanggal" name="tanggal" value="<?= htmlspecialchars($data['tanggal']) ?>" required>

      <label for="berat">Berat (kg)</label>
      <input type="number" step="0.01" id="berat" name="berat" value="<?= htmlspecialchars($data['berat']) ?>" required>

      <label for="tinggi">Tinggi (cm)</label>
      <input type="number" step="0.1" id="tinggi" name="tinggi" value="<?= htmlspecialchars($data['tinggi']) ?>" required>

      <label for="petugas">Petugas</label>
      <input type="text" id="petugas" name="petugas" value="<?= htmlspecialchars($data['petugas']) ?>" required>

      <label for="keterangan">Keterangan</label>
      <textarea id="keterangan" name="keterangan"><?= htmlspecialchars($data['keterangan']) ?></textarea>

      <button type="submit">Simpan</button>
    </form>
    <div class="actions">
      <a href="imunisasi.php" style="color:#007bff;">Kembali</a>
      <a href="hapus_imunisasi.php?id=<?= $data['id'] ?>" class="delete-link" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
    </div>
  </div>
</body>
</html>
