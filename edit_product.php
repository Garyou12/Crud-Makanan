<?php 
include 'config.php'; 

if (!is_logged() || !is_admin()) {
    header('Location:index.php');
    exit;
}

$id = (int)$_GET['id'];
$res = $conn->query("SELECT * FROM products WHERE id=$id LIMIT 1");
if (!$res || $res->num_rows == 0) {
    echo 'Produk tidak ditemukan';
    exit;
}

$p = $res->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $conn->real_escape_string($_POST['nama']);
    $harga = (int)$_POST['harga'];
    $conn->query("UPDATE products SET nama='$nama', harga=$harga WHERE id=$id");
    header('Location: admin.php');
    exit;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Edit Produk</title>
<link rel="stylesheet" href="admin.css">
<script src="admin.js" defer></script>
</head>
<body>

<!-- ========== NAVBAR ========== -->
<div class="navbar">
    <div class="nav-left">
       Edit Produk
    </div>
    <div class="nav-right">
        <a href="admin.php" class="nav-btn">Dashboard</a>
        <a href="logout.php" class="nav-btn">Logout</a>
    </div>
</div>

<h2>Edit Produk</h2>

<form method="post">
    <label>Nama</label>
    <input name="nama" type="text" value="<?= htmlspecialchars($p['nama']); ?>" required>
<br>
    <label>Harga</label>
    <input name="harga" type="number" value="<?= $p['harga']; ?>" required>

    <button type="submit">Update</button>
</form>

</body>
</html>
