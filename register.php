<?php
require_once 'db.php'; // Menggunakan koneksi database
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validasi input
    if (empty($username) || empty($password) || empty($role)) {
        $error = "Semua field harus diisi.";
    } else {
        // Validasi role
        $validRoles = ['admin', 'orangtua'];
        if (!in_array($role, $validRoles)) {
            $error = "Role tidak valid.";
        } else {
            // Periksa apakah username sudah ada
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $error = "Username sudah digunakan.";
            } else {
                // Hash password sebelum disimpan
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Simpan data ke database
                $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $username, $hashedPassword, $role);

                if ($stmt->execute()) {
                    if ($role === 'orangtua') {
                        $lastInsertedId = $conn->insert_id; // Ambil ID pengguna yang baru saja dibuat
                        $stmt = $conn->prepare("INSERT INTO anak (id_orangtua, nama, jenis_kelamin, usia) VALUES (?, ?, ?, ?)");
                        $defaultNama = "Nama Anak"; // Nama default
                        $defaultJenisKelamin = "Laki-laki"; // Jenis kelamin default
                        $defaultUsia = 0; // Usia default
                        $stmt->bind_param("issi", $lastInsertedId, $defaultNama, $defaultJenisKelamin, $defaultUsia);
                        $stmt->execute();
                    }
                    // Redirect ke login.php setelah berhasil register
                    header("Location: login.php");
                    exit();
                } else {
                    $error = "Terjadi kesalahan saat menyimpan data.";
                }
            }
            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrasi Posyandu</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #a6d4f2;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .register-box {
      background-color: #f3f3f3;
      padding: 40px;
      border-radius: 25px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      text-align: center;
    }
    h1 {
      margin-bottom: 5px;
    }
    input[type="text"], input[type="password"], select {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: none;
      border-radius: 5px;
      background-color: #cde4e8;
    }
    button {
      padding: 10px 20px;
      background-color: #8ed0e4;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .error {
      color: red;
      margin-top: 10px;
    }
    .success {
      color: green;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="register-box">
    <h1>Registrasi</h1>
    <form method="POST">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <select name="role" required>
        <option value="">Pilih Role</option>
        <option value="admin">Admin</option>
        <option value="orangtua">Orangtua</option>
      </select>
      <button type="submit">Daftar</button>
    </form>
    <?php if ($error): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
      <div class="success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
  </div>
</body>
</html>