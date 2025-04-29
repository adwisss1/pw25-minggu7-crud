<?php
session_start();
include 'db.php';

// Periksa apakah form login telah dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']); // Tidak menggunakan hashing karena tabel Anda menyimpan password dalam teks biasa

    // Query untuk memeriksa pengguna di tabel admin
    $result = $conn->query("SELECT * FROM admin WHERE username_admin='$username' AND password_admin='$password'");
    if ($result->num_rows > 0) {
        // Jika login berhasil, simpan sesi admin
        $_SESSION['username'] = $username;
        $_SESSION['role'] = 'admin'; // Tetapkan role sebagai admin
        header("Location: beranda.php"); // Arahkan ke halaman beranda
        exit;
    } else {
        echo "<script>alert('Username atau password salah!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="login-container">
        <h1>Login Admin</h1>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>