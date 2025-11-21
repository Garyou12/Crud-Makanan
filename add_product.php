<?php
include 'config.php';

if (!is_logged() || !is_admin()) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $conn->real_escape_string($_POST['nama']);
    $harga = (int)$_POST['harga'];
    $conn->query("INSERT INTO products (nama,harga) VALUES ('$nama',$harga)");
    header('Location: admin.php');
    exit;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Tambah Produk</title>
<link rel="stylesheet" href="admin.css">
<script src="admin.js" defer></script>
</head>
<body>

<!-- ========== NAVBAR ========== -->
<div class="navbar">
    <div class="nav-left">
        Tambah Produk
    </div>
    <div class="nav-right">
        <a href="admin.php" class="nav-btn">Dashboard</a>
        <a href="logout.php" class="nav-btn">Logout</a>
    </div>
</div>

<h2>Tambah Produk</h2>

<form method="post">
    <label>Nama</label>
    <input name="nama" type="text" required>

    <label>Harga</label>
    <input name="harga" type="number" required>

    <button type="submit">Simpan</button>
</form>

</body>
</html>
