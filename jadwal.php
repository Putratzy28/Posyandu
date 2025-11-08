<?php
require_once 'db.php';
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

$sql = "SELECT * FROM jadwal ORDER BY tanggal ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Jadwal Imunisasi</title>
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
    h2 {
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

<!-- Tambahkan CSS untuk mempercantik tabel -->
<style>
  body {
    font-family: Arial, sans-serif;
    background: #f7f7f7;
    margin: 0;
    padding: 0;
  }
  .jadwal-container {
    max-width: 700px;
    margin: 40px auto;
    background: #fff;
    padding: 24px 32px 32px 32px;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  }
  h2 {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 24px;
  }
  table {
    width: 100%;
    border-collapse: collapse;
    background: #fafafa;
  }
  th, td {
    padding: 12px 10px;
    text-align: left;
  }
  th {
    background: #3498db;
    color: #fff;
    font-weight: 600;
  }
  tr:nth-child(even) {
    background: #f2f8fc;
  }
  tr:hover {
    background: #eaf6fb;
  }
</style>

<body>
  <div class="sidebar">
    <a href="dashboard.php">Dashboard</a>
    <a href="anak.php">Anak</a>
    <a href="imunisasi.php">Imunisasi</a>
    <a href="jadwal.php" style="background-color:#4CAF50;">Jadwal</a>
    <a href="laporan.php">Laporan</a>
    <a href="logout.php">Logout</a>
  </div>

  <div class="container">
    <h2>Jadwal Imunisasi</h2>
    <a href="tambah_jadwal.php" style="display:inline-block;margin-bottom:18px;padding:8px 18px;background:#27ae60;color:#fff;border-radius:5px;text-decoration:none;font-weight:600;transition:background 0.2s;">+ Tambah Jadwal</a>
    <table>
      <tr>
        <th>Jenis Imunisasi</th>
        <th>Tanggal</th>
        <th>Lokasi</th>
      </tr>
      <?php while($row = $result->fetch_assoc()) : ?>
        <tr>
          <td><?= htmlspecialchars($row['jenis_imunisasi']) ?></td>
          <td><?= htmlspecialchars($row['tanggal']) ?></td>
          <td><?= htmlspecialchars($row['lokasi']) ?></td>
        </tr>
      <?php endwhile; ?>
    </table>
  </div>
</body>
</html>
