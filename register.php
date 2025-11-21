<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username   = $conn->real_escape_string($_POST['username']);
    $password   = $conn->real_escape_string($_POST['password']);
    $nama_user  = $conn->real_escape_string($_POST['nama_user']);

    $role = "user";

    // cek username
    $cek = $conn->query("SELECT id FROM users WHERE username='$username' LIMIT 1");
    if ($cek->num_rows > 0) {
        echo "Username sudah dipakai. <a href='register.php'>Coba lagi</a>";
        exit;
    }

    // simpan data
    $q = "
        INSERT INTO users (username, password, nama_user, role)
        VALUES ('$username', '$password', '$nama_user', '$role')
    ";

    if ($conn->query($q)) {
        echo "Registrasi berhasil! <a href='index.php'>Login</a>";
    } else {
        echo "Gagal daftar. Error: " . $conn->error;
    }

    exit;
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Register</title>

<link rel="stylesheet" href="auth.css">
<script src="auth.js" defer></script>

</head>
<body>

<form method="post">
    <h2>Daftar Akun</h2>

    <label>Username</label>
    <input type="text" name="username" required>

    <label>Password</label>
    <div class="input-wrap">
        <input type="password" name="password" id="password" required>
        <span class="eye-btn" id="togglePw">👁️</span>
    </div>

    <label>Nama Lengkap / Nama Panggilan</label>
    <input type="text" name="nama_user" required>

    <button type="submit">Daftar</button>

    <p>Sudah punya akun? <a href="index.php">Login</a></p>
</form>

</body>
</html>
