<?php
require_once 'db.php';
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['cetak_data'])) {
    header("Location: login.php");
    exit();
}

$data = $_SESSION['cetak_data'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Preview Sertifikat Imunisasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #2c3e50;
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
        }
        .divider {
            height: 2px;
            background: #3498db;
            margin: 20px 0;
        }
        .content {
            text-align: center;
            line-height: 1.8;
        }
        .child-name {
            font-size: 20px;
            font-weight: bold;
            color: #2c3e50;
            margin: 20px 0;
        }
        .nik {
            color: #7f8c8d;
            margin-bottom: 30px;
        }
        .vaccine-type {
            font-size: 18px;
            font-weight: bold;
            color: #e74c3c;
            background: #ffeaa7;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .details {
            margin: 30px 0;
        }
        .signature {
            text-align: right;
            margin-top: 50px;
        }
        .info-box {
            background: #ecf0f1;
            padding: 20px;
            border-radius: 5px;
            margin-top: 30px;
            text-align: left;
        }
        .info-box h4 {
            color: #2c3e50;
            margin-top: 0;
        }
        .info-box ul {
            margin: 10px 0;
            padding-left: 20px;
        }
        .btn-container {
            text-align: center;
            margin: 30px 0;
        }
        .btn {
            padding: 10px 20px;
            margin: 0 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
        }
        .btn-print {
            background: #2ecc71;
            color: white;
        }
        .btn-pdf {
            background: #e74c3c;
            color: white;
        }
        .btn-back {
            background: #95a5a6;
            color: white;
        }
        .btn:hover {
            opacity: 0.8;
        }
        
        @media print {
            .btn-container {
                display: none;
            }
            body {
                background: white;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="btn-container">
            <button onclick="window.print()" class="btn btn-print">🖨️ Print</button>
            <form method="post" action="cetak_single.php" style="display: inline;">
                <button type="submit" class="btn btn-pdf">📄 Download PDF</button>
            </form>
            <a href="laporan.php" class="btn btn-back">← Kembali</a>
        </div>
        
        <div class="header">
            <h1>Sertifikat Imunisasi</h1>
        </div>
        
        <div class="divider"></div>
        
        <div class="content">
            <p>Dengan ini dinyatakan bahwa:</p>
            
            <div class="child-name"><?= htmlspecialchars($data['nama']) ?></div>
            <div class="nik">NIK: <?= htmlspecialchars($data['nik']) ?></div>
            
            <p>Telah menerima imunisasi:</p>
            
            <div class="vaccine-type"><?= htmlspecialchars($data['jenis_imunisasi']) ?></div>
            
            <div class="details">
                <p><strong>Tanggal Imunisasi:</strong> <?= date('d F Y', strtotime($data['tanggal'])) ?></p>
                <p><strong>Petugas:</strong> <?= htmlspecialchars($data['petugas']) ?></p>
            </div>
            
            <div class="signature">
                <p>Mengetahui,</p>
                <br><br>
                <p>(__________________)</p>
                <p>Petugas Kesehatan</p>
            </div>
        </div>
        
        <div class="info-box">
            <h4>INFORMASI PENTING:</h4>
            <ul>
                <li>Simpan sertifikat ini dengan baik</li>
                <li>Bawa sertifikat ini saat kontrol selanjutnya</li>
                <li>Hubungi petugas kesehatan jika ada reaksi</li>
                <li>Jadwal imunisasi selanjutnya dapat dilihat di buku KIA</li>
            </ul>
        </div>
        
        <div style="text-align: center; margin-top: 30px; font-size: 12px; color: #7f8c8d;">
            Dicetak pada: <?= date('d F Y, H:i:s') ?> WIB
        </div>
    </div>
</body>
</html>