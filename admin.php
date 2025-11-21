<?php
include 'config.php';

if (!is_logged() || !is_admin()) {
    header('Location: index.php');
    exit;
}

// produk
$prod_res = $conn->query("SELECT * FROM products ORDER BY id DESC");

// pesanan aktif
$order_res = $conn->query("
    SELECT o.*, u.nama_user, p.nama AS nama_pesanan
    FROM orders o
    JOIN users u ON o.user_id = u.id
    JOIN products p ON o.product_id = p.id
    ORDER BY o.tanggal_pesan DESC
");

// pesanan selesai
$done_res = $conn->query("SELECT * FROM orders_selesai ORDER BY tanggal_selesai DESC");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Admin - Dashboard</title>
<link rel="stylesheet" href="admin.css">
<script src="admin.js" defer></script>
</head>

<body>

<!-- ========== NAVBAR ========== -->
<div class="navbar">
    <div class="nav-left">
        Halo, <?= htmlspecialchars($_SESSION['nama_user']); ?>
    </div>
    <div class="nav-right">
        <a href="admin.php" class="nav-btn">Dashboard</a>
        <a href="logout.php" class="nav-btn">Logout</a>
    </div>
</div>

<!-- ================= HEADING UTAMA ================= -->
<h2>Admin Dashboard</h2>

<!-- ================= PRODUK ================= -->
<h3>Produk</h3>
<a href="add_product.php" class="nav-btn">Tambah Produk</a>

<?php $no = 1; ?>
<table>
<tr>
    <th>No</th><th>ID</th><th>Nama</th><th>Harga</th><th>Aksi</th>
</tr>
<?php while($p = $prod_res->fetch_assoc()): ?>
<tr>
<td><?= $no++ ?></td>
<td><?= $p['id'] ?></td>
<td><?= htmlspecialchars($p['nama']) ?></td>
<td>Rp <?= number_format($p['harga']) ?></td>
<td>
<a href="edit_product.php?id=<?= $p['id'] ?>" class="nav-btn small">Edit</a> |
<a href="delete_product.php?id=<?= $p['id'] ?>" class="nav-btn small" onclick="return confirm('Hapus produk?')">Hapus</a>
</td>
</tr>
<?php endwhile; ?>
</table>
<br>
<!-- ================= PESANAN AKTIF ================= -->
<h3>Pesanan Aktif</h3>

<?php $no = 1; ?>
<table>
<tr>
    <th>No</th><th>ID</th><th>UserID</th><th>Nama User</th><th>Pesanan</th>
    <th>Jumlah</th><th>Total</th><th>Tanggal</th><th>Status</th><th>Aksi</th>
</tr>
<?php while($o = $order_res->fetch_assoc()): ?>
<tr>
<td><?= $no++ ?></td>
<td><?= $o['id'] ?></td>
<td><?= $o['user_id'] ?></td>
<td><?= htmlspecialchars($o['nama_user']) ?></td>
<td><?= htmlspecialchars($o['nama_pesanan']) ?></td>
<td><?= $o['jumlah'] ?></td>
<td>Rp <?= number_format($o['total_harga']) ?></td>
<td><?= $o['tanggal_pesan'] ?></td>
<td><?= $o['status'] ?></td>
<td>
<?php if($o['status'] == 'menunggu'): ?>
    <a href="confirm_order.php?id=<?= $o['id'] ?>" class="nav-btn small">Konfirmasi</a> |
    <a href="cancel_order_reason.php?id=<?= $o['id'] ?>" class="nav-btn small">Batalkan</a>
<?php elseif($o['status'] == 'dikonfirmasi'): ?>
    <a href="complete_order.php?id=<?= $o['id'] ?>" class="nav-btn small">Selesai</a>
<?php else: ?>
    (locked)
<?php endif; ?>
</td>
</tr>
<?php endwhile; ?>
</table>
<br>

<!-- ================= PESANAN SELESAI ================= -->
<h3>Pesanan Selesai</h3>

<?php $no = 1; ?>
<table>
<tr>
    <th>No</th><th>ID</th><th>Nama User</th><th>Pesanan</th>
    <th>Jumlah</th><th>Total</th><th>Tgl Pesan</th><th>Tgl Selesai</th>
</tr>
<?php while($d = $done_res->fetch_assoc()): ?>
<tr>
<td><?= $no++ ?></td>
<td><?= $d['id'] ?></td>
<td><?= htmlspecialchars($d['nama_user']) ?></td>
<td><?= htmlspecialchars($d['nama_pesanan']) ?></td>
<td><?= $d['jumlah'] ?></td>
<td>Rp <?= number_format($d['total_harga']) ?></td>
<td><?= $d['tanggal_pesan'] ?></td>
<td><?= $d['tanggal_selesai'] ?></td>
</tr>
<?php endwhile; ?>
</table>

</body>
</html>
