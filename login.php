<?php
// login.php
session_start();
require_once 'db.php'; // Menggunakan koneksi database

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk memeriksa username
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Debug: Tampilkan data user
        // echo "<pre>"; print_r($user); echo "</pre>";

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $username;
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Password salah.";
        }
    } else {
        $error = "Username tidak ditemukan.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Posyandu</title>
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
    .login-box {
      background-color: #f3f3f3;
      padding: 40px;
      border-radius: 25px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      text-align: center;
    }
    h1 {
      margin-bottom: 5px;
    }
    h2 {
      margin-top: 0;
      font-weight: normal;
      color: gray;
    }
    input[type="text"], input[type="password"] {
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
    .register-link {
      margin-top: 15px;
      display: block;
      color: #007bff;
      text-decoration: none;
    }
    .register-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <h1>Posyandu</h1>
    <h2>Desa Solo</h2>
    <form method="POST">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
    <?php if ($error): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <a href="register.php" class="register-link">Belum punya akun? Daftar di sini</a>
  </div>
</body>
</html>
