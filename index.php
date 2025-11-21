<?php 
include 'config.php';

if (is_logged()) {
    if (is_admin()) header('Location: admin.php');
    else header('Location: customer.php');
    exit;
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Login - Pemesanan Makanan</title>

<link rel="stylesheet" href="auth.css">
<script src="auth.js" defer></script>

</head>
<body>

<form action="login_process.php" method="post">
    <h2>Login</h2>

    <label>Username</label>
    <input type="text" name="username" required>

    <label>Password</label>
    <div class="input-wrap">
        <input type="password" name="password" id="password" required>
        <span class="eye-btn" id="togglePw">👁️</span>
    </div>

    <button type="submit">Login</button>

    <p>Belum punya akun? <a href="register.php">Daftar</a></p>
</form>

</body>
</html>
