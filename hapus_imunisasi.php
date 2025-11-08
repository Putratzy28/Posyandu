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

// Hapus data imunisasi berdasarkan ID
$stmt = $conn->prepare("DELETE FROM imunisasi WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: imunisasi.php");
exit();