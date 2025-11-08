<?php 
require_once 'db.php'; 
session_start(); 

if (!isset($_SESSION['user'])) {   
    header("Location: login.php");   
    exit(); 
}

// Handler untuk cetak PDF
if (isset($_POST['cetak_pdf'])) {
    header("Location: cetak_pdf.php");
    exit();
}

// Handler untuk cetak data single
if (isset($_POST['cetak_single'])) {
    $data = [
        'nama' => $_POST['nama'],
        'nik' => $_POST['nik'],
        'jenis_imunisasi' => $_POST['jenis_imunisasi'],
        'tanggal' => $_POST['tanggal'],
        'petugas' => $_POST['petugas']
    ];
    
    // Simpan data ke session untuk dikirim ke preview_single.php
    $_SESSION['cetak_data'] = $data;
    header("Location: preview_single.php");
    exit();
}

// Query data laporan 
$sql = "SELECT a.nama, a.nik, i.jenis_imunisasi, i.tanggal, i.petugas          
        FROM imunisasi i         
        JOIN anak a ON i.anak_id = a.id         
        ORDER BY i.tanggal DESC"; 
$result = $conn->query($sql);  

?> 
<!DOCTYPE html> 
<html lang="en"> 
<head>   
    <meta charset="UTF-8">   
    <title>Laporan Imunisasi</title>   
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
            text-align: center;       
            margin-bottom: 24px;     
        }     
        table {       
            width: 100%;       
            border-collapse: collapse;       
            margin-top: 20px;       
            background: #fafafa;     
        }     
        th, td {       
            padding: 12px 10px;       
            text-align: left;       
            border: 1px solid #ccc;     
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
        .btn-cetak {       
            padding: 10px 20px;       
            background: #e74c3c;       
            color: #fff;       
            border: none;       
            border-radius: 5px;       
            cursor: pointer;       
            margin-bottom: 16px;
            font-size: 14px;
            transition: background-color 0.3s;
        }
        .btn-cetak:hover {
            background: #c0392b;
        }
        .btn-print {
            padding: 10px 20px;
            background: #2ecc71;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
            font-size: 14px;
            transition: background-color 0.3s;
        }
        .btn-print:hover {
            background: #27ae60;
        }
        .btn-single {
            padding: 5px 10px;
            background: #f39c12;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 12px;
            transition: background-color 0.3s;
        }
        .btn-single:hover {
            background: #e67e22;
        }
    </style> 
</head> 
<body>   
    <div class="sidebar">     
        <a href="dashboard.php">Dashboard</a>     
        <a href="anak.php">Anak</a>     
        <a href="imunisasi.php">Imunisasi</a>     
        <a href="jadwal.php">Jadwal</a>     
        <a href="laporan.php" style="background-color:#4CAF50;">Laporan</a>     
        <a href="logout.php">Logout</a>   
    </div>    

    <div class="container">     
        <h2>Laporan Imunisasi</h2>     
        <div style="margin-bottom: 20px;">
            <form method="post" style="display: inline;">       
                <button type="submit" name="cetak_pdf" class="btn-cetak">📄 Cetak PDF</button>     
            </form>
            <button onclick="window.print()" class="btn-print">🖨️ Print Halaman</button>
        </div>
        
        <table>       
            <tr>         
                <th>Nama Anak</th>         
                <th>NIK</th>         
                <th>Jenis Imunisasi</th>         
                <th>Tanggal</th>         
                <th>Petugas</th>
                <th>Aksi</th>       
            </tr>       
            <?php while($row = $result->fetch_assoc()) : ?>         
                <tr>           
                    <td><?= htmlspecialchars($row['nama']) ?></td>           
                    <td><?= htmlspecialchars($row['nik']) ?></td>           
                    <td><?= htmlspecialchars($row['jenis_imunisasi']) ?></td>           
                    <td><?= htmlspecialchars($row['tanggal']) ?></td>           
                    <td><?= htmlspecialchars($row['petugas']) ?></td>
                    <td>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="nama" value="<?= htmlspecialchars($row['nama']) ?>">
                            <input type="hidden" name="nik" value="<?= htmlspecialchars($row['nik']) ?>">
                            <input type="hidden" name="jenis_imunisasi" value="<?= htmlspecialchars($row['jenis_imunisasi']) ?>">
                            <input type="hidden" name="tanggal" value="<?= htmlspecialchars($row['tanggal']) ?>">
                            <input type="hidden" name="petugas" value="<?= htmlspecialchars($row['petugas']) ?>">
                            <button type="submit" name="cetak_single" class="btn-single">📄 Cetak</button>
                        </form>
                    </td>         
                </tr>       
            <?php endwhile; ?>     
        </table>   
    </div> 
</body> 
</html>