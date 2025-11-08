<?php
require_once 'db.php';

$id = $_GET['id'];

// Hapus data terkait di tabel imunisasi
$sql_imunisasi = "DELETE FROM imunisasi WHERE id_anak = ?";
$stmt_imunisasi = $conn->prepare($sql_imunisasi);
$stmt_imunisasi->bind_param("i", $id);
$stmt_imunisasi->execute();

// Hapus data anak
$sql_anak = "DELETE FROM anak WHERE id = ?";
$stmt_anak = $conn->prepare($sql_anak);
$stmt_anak->bind_param("i", $id);
$stmt_anak->execute();

header("Location: anak.php");
exit();
?>