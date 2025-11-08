<?php
// dashboard.php
require_once 'db.php';
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

// Ambil jumlah anak
$jumlahAnakQuery = "SELECT COUNT(*) AS total_anak FROM anak";
$jumlahAnakResult = $conn->query($jumlahAnakQuery);
$jumlahAnak = $jumlahAnakResult->fetch_assoc()['total_anak'];

// Ambil jumlah imunisasi
$jumlahImunisasiQuery = "SELECT COUNT(*) AS total_imunisasi FROM imunisasi";
$jumlahImunisasiResult = $conn->query($jumlahImunisasiQuery);
$jumlahImunisasi = $jumlahImunisasiResult->fetch_assoc()['total_imunisasi'];

// Ambil daftar anak
$daftarAnakQuery = "SELECT nama, berat, tinggi FROM anak LEFT JOIN imunisasi ON anak.id = imunisasi.anak_id LIMIT 10";
$daftarAnakResult = $conn->query($daftarAnakQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Posyandu</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      /* Ganti background-color dengan background-image */
      background: url('aset/tes.jpg') no-repeat center center fixed;
      background-size: cover;
    }
    .sidebar {
      width: 200px;
      background-color: #1e2a38;
      color: white;
      height: 100vh;
      position: fixed;
      padding-top: 20px;
    }
    .sidebar h2 {
      text-align: center;
      margin-bottom: 30px;
    }
    .sidebar a {
      display: block;
      color: white;
      padding: 10px 20px;
      text-decoration: none;
    }
    .sidebar a:hover {
      background-color: #31475e;
    }
    .main {
      margin-left: 200px;
      padding: 20px;
    }
    .cards {
      display: flex;
      gap: 20px;
    }
    .card {
      background-color: #e0f7fa;
      padding: 20px;
      border-radius: 10px;
      flex: 1;
      text-align: center;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    th {
      background-color: #b2ebf2;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <h2>Dashboard</h2>
    <a href="anak.php">Anak</a>
    <a href="imunisasi.php">Imunisasi</a>
    <a href="jadwal.php">Jadwal</a>
    <a href="laporan.php">Laporan</a>
    <a href="logout.php">Logout</a>
  </div>

  <div class="main">
    <h1>👋 Halo, <?= htmlspecialchars($_SESSION['user']) ?></h1>
    <div class="cards">
      <div class="card">
        <h2>Jumlah Anak</h2>
        <p><?= $jumlahAnak ?></p>
      </div>
      <div class="card">
        <h2>Jumlah Imunisasi</h2>
        <p><?= $jumlahImunisasi ?></p>
      </div>
    </div>

    <h2>Daftar Anak</h2>
    <table>
      <thead>
        <tr>
          <th>Nama Anak</th>
          <th>Berat Badan</th>
          <th>Tinggi Badan</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $daftarAnakResult->fetch_assoc()) : ?>
          <tr>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td><?= htmlspecialchars($row['berat'] ?? '-') ?></td>
            <td><?= htmlspecialchars($row['tinggi'] ?? '-') ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
