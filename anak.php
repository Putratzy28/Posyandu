<?php
require_once 'db.php';
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

// Hapus data jika ada permintaan
if (isset($_GET['hapus'])) {
  $id = intval($_GET['hapus']);
  $conn->query("DELETE FROM anak WHERE id = $id");
  header("Location: anak.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Data Anak</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f8ff;
      margin: 0;
      padding: 0;
    }
    .sidebar {
      width: 200px;
      background-color: #1e2a38;
      color: white;
      height: 100vh;
      position: fixed;
      padding-top: 20px;
    }
    .sidebar a {
      display: block;
      color: white;
      text-decoration: none;
      padding: 10px 15px;
    }
    .sidebar a:hover {
      background-color: #4CAF50;
    }
    .container {
      margin-left: 220px;
      padding: 20px;
    }
    h1 {
      color: #333;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    table, th, td {
      border: 1px solid #ccc;
    }
    th, td {
      padding: 10px;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
    }
    .form-box {
      margin-top: 30px;
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 5px rgba(0,0,0,0.1);
      max-width: 500px;
    }
    input, textarea, select {
      width: 100%;
      padding: 10px;
      margin-top: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    button {
      margin-top: 15px;
      padding: 10px 15px;
      border: none;
      background-color: #4CAF50;
      color: white;
      border-radius: 5px;
      cursor: pointer;
    }
    button:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <a href="dashboard.php">Dashboard</a>
    <a href="anak.php">Anak</a>
    <a href="imunisasi.php">Imunisasi</a>
    <a href="jadwal.php">Jadwal</a>
    <a href="laporan.php">Laporan</a>
    <a href="logout.php">Logout</a>
  </div>

  <div class="container">
    <h1>Data Anak</h1>
    <!-- Baris tombol tambah dan search di atas tabel -->
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
      <!-- Tombol tambah di kiri -->
      <a href="tambah_anak.php" style="padding:8px 18px;background:#27ae60;color:#fff;border:none;border-radius:5px;cursor:pointer;font-weight:600;text-decoration:none;">
        + Tambah Data Anak
      </a>
      <!-- Search di kanan -->
      <div style="display:flex;align-items:center;gap:8px;">
        <input type="text" id="searchInput" placeholder="Cari anak, NIK, ortu, alamat..." style="padding:8px 32px 8px 32px;border-radius:5px;border:1px solid #ccc;width:250px;">
        <span style="position:relative;left:-32px;">
          <svg width="18" height="18" fill="#888"><circle cx="8" cy="8" r="7" stroke="#888" stroke-width="2" fill="none"/><line x1="13" y1="13" x2="17" y2="17" stroke="#888" stroke-width="2" /></svg>
        </span>
      </div>
    </div>
    <table id="anakTable">
      <tr>
        <th>Nama Anak</th>
        <th>NIK</th>
        <th>Tanggal Lahir</th>
        <th>Jenis Kelamin</th>
        <th>Nama Ortu</th>
        <th>Alamat</th>
        <th>Aksi</th>
      </tr>
      <?php
      $sql = "SELECT * FROM anak";
      $result = $conn->query($sql);
      while ($row = $result->fetch_assoc()) :
      ?>
        <tr>
          <td><?= htmlspecialchars($row['nama']) ?></td>
          <td><?= htmlspecialchars($row['nik']) ?></td>
          <td><?= htmlspecialchars($row['tanggal_lahir']) ?></td>
          <td><?= htmlspecialchars($row['jenis_kelamin']) ?></td>
          <td><?= htmlspecialchars($row['nama_ortu']) ?></td>
          <td><?= htmlspecialchars($row['alamat']) ?></td>
          <td>
            <a href="edit_anak.php?id=<?= $row['id'] ?>">Edit</a>
            <a href="anak.php?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </table>
  </div>
  <!-- Script filter tetap di bawah -->
  <script>
  document.getElementById('searchInput').addEventListener('keyup', function() {
    var filter = this.value.toLowerCase();
    var rows = document.querySelectorAll('#anakTable tr:not(:first-child)');
    rows.forEach(function(row) {
      var text = row.textContent.toLowerCase();
      row.style.display = text.indexOf(filter) > -1 ? '' : 'none';
    });
  });
  </script>
</body>
</html>
