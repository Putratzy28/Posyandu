<?php
require_once 'db.php';
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['cetak_data'])) {
    header("Location: login.php");
    exit();
}

$data = $_SESSION['cetak_data'];
// Hapus data dari session setelah digunakan
unset($_SESSION['cetak_data']);

// Library FPDF
require_once('fpdf/fpdf.php');

// Buat PDF dengan FPDF
class PDF extends FPDF
{
    // Page header
    function Header()
    {
        $this->SetFont('Arial','B',16);
        $this->Cell(0,10,'SERTIFIKAT IMUNISASI',0,1,'C');
        $this->Ln(5);
        
        // Garis horizontal
        $this->Line(10, 30, 200, 30);
        $this->Ln(10);
    }
    
    // Page footer
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Dicetak pada: '.date('d/m/Y H:i:s'),0,0,'C');
    }
}

// Instansiasi PDF
$pdf = new PDF();
$pdf->AddPage();

// Set font untuk konten
$pdf->SetFont('Arial','',12);

// Konten sertifikat
$pdf->Ln(10);
$pdf->Cell(0,10,'Dengan ini dinyatakan bahwa:',0,1,'C');
$pdf->Ln(5);

// Data anak
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,$data['nama'],0,1,'C');
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,10,'NIK: ' . $data['nik'],0,1,'C');
$pdf->Ln(10);

$pdf->Cell(0,10,'Telah menerima imunisasi:',0,1,'C');
$pdf->Ln(5);

// Jenis imunisasi
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,$data['jenis_imunisasi'],0,1,'C');
$pdf->SetFont('Arial','',12);
$pdf->Ln(10);

// Detail imunisasi
$pdf->Cell(0,10,'Tanggal Imunisasi: ' . date('d F Y', strtotime($data['tanggal'])),0,1,'C');
$pdf->Cell(0,10,'Petugas: ' . $data['petugas'],0,1,'C');
$pdf->Ln(20);

// Tanda tangan
$pdf->Cell(0,10,'Mengetahui,',0,1,'R');
$pdf->Ln(20);
$pdf->Cell(0,10,'(__________________)',0,1,'R');
$pdf->Cell(0,10,'Petugas Kesehatan',0,1,'R');

// Kotak untuk info tambahan
$pdf->Ln(10);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,8,'INFORMASI PENTING:',0,1,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(0,6,'- Simpan sertifikat ini dengan baik',0,1,'L');
$pdf->Cell(0,6,'- Bawa sertifikat ini saat kontrol selanjutnya',0,1,'L');
$pdf->Cell(0,6,'- Hubungi petugas kesehatan jika ada reaksi',0,1,'L');

// Output PDF
$pdf->Output('D', 'Sertifikat_Imunisasi_' . $data['nama'] . '_' . date('Y-m-d') . '.pdf');
?>