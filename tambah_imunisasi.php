<?php
require_once 'db.php';
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

// Ambil data anak untuk pilihan dropdown
$anakList = [];
$res = $conn->query("SELECT id, nama FROM anak ORDER BY nama ASC");
while ($row = $res->fetch_assoc()) {
  $anakList[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $anak_id = $_POST['anak_id'];
  $jenis_imunisasi = $_POST['jenis_imunisasi'];
  $tanggal = $_POST['tanggal'];
  $berat = $_POST['berat'];
  $tinggi = $_POST['tinggi'];
  $petugas = $_POST['petugas'];
  $keterangan = $_POST['keterangan'];

  $sql = "INSERT INTO imunisasi (anak_id, jenis_imunisasi, tanggal, berat, tinggi, petugas, keterangan)
          VALUES (?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("issddss", $anak_id, $jenis_imunisasi, $tanggal, $berat, $tinggi, $petugas, $keterangan);

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
  <title>Tambah Data Imunisasi</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f7f7f7; }
    .container { max-width: 400px; margin: 40px auto; background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 2px 8px #ccc; }
    h2 { text-align: center; }
    label { display: block; margin-top: 12px; }
    input[type="text"], input[type="date"], input[type="number"], select, textarea {
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
    <h2>Tambah Data Imunisasi</h2>
    <form method="POST">
      <label for="anak_id">Nama Anak</label>
      <select id="anak_id" name="anak_id" required>
        <option value="">-- Pilih Anak --</option>
        <?php foreach($anakList as $anak): ?>
          <option value="<?= $anak['id'] ?>"><?= htmlspecialchars($anak['nama']) ?></option>
        <?php endforeach; ?>
      </select>

      <label for="jenis_imunisasi">Jenis Imunisasi</label>
      <input type="text" id="jenis_imunisasi" name="jenis_imunisasi" required>

      <label for="tanggal">Tanggal</label>
      <input type="date" id="tanggal" name="tanggal" required>

      <label for="berat">Berat (kg)</label>
      <input type="number" step="0.01" id="berat" name="berat" required>

      <label for="tinggi">Tinggi (cm)</label>
      <input type="number" step="0.1" id="tinggi" name="tinggi" required>

      <label for="petugas">Petugas</label>
      <input type="text" id="petugas" name="petugas" required>

      <label for="keterangan">Keterangan</label>
      <textarea id="keterangan" name="keterangan"></textarea>

      <button type="submit">Simpan</button>
    </form>
    <div class="actions">
      <a href="imunisasi.php" class="back-link">Kembali</a>
    </div>
  </div>
</body>
</html>