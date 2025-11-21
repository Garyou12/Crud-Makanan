<?php 
include 'config.php';

if(!is_logged() || is_admin()) { 
    header('Location:index.php'); 
    exit; 
}

$uid = (int)$_SESSION['user_id'];

// pesanan aktif
$orders = $conn->query("
    SELECT o.*, p.nama AS produk_nama
    FROM orders o
    JOIN products p ON o.product_id = p.id
    WHERE o.user_id = $uid
    ORDER BY o.tanggal_pesan DESC
");

// pesanan selesai
$done = $conn->query("
    SELECT * 
    FROM orders_selesai 
    WHERE user_id = $uid
    ORDER BY tanggal_selesai DESC
");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Pesanan Saya</title>

<link rel="stylesheet" href="customer.css">
<script src="customer.js" defer></script>
<style>
/* tambahan buat h2/h3 punya rectangle */
h2, h3 {
    background: var(--white);
    display: inline-block;
    padding: 10px 18px;
    border-radius: var(--radius);
    box-shadow: 0 3px 12px rgba(0,0,0,0.08);
    margin-bottom: 20px;
}

/* table responsive & rapih */
table th, table td {
    text-align: center;
}

/* tombol navbar */
.nav-btn {
    text-decoration: none;
    background: var(--navy);
    color: var(--white);
    padding: 8px 16px;
    font-size: 14px;
    font-weight: 600;
    border-radius: 30px;
    transition: 0.25s;
    display: inline-block;
}

.nav-btn:hover {
    background: #2f3f5f;
    transform: translateY(-2px);
}
</style>
</head>

<body>

<!-- ========== NAVBAR ================= -->
<div class="navbar">
    <div class="nav-left">
        Pesanan <?= htmlspecialchars($_SESSION['nama_user']); ?>
    </div>

    <div class="nav-right">
        <a href="customer.php" class="nav-btn">Beranda</a>
        <a href="notifications.php" class="nav-btn">Notifikasi</a>
        <a href="logout.php" class="nav-btn">Logout</a>
    </div>
</div>

<!-- ================= PESANAN AKTIF ================= -->
<h3>Pesanan Aktif</h3>

<table>
<tr>
<th>ID</th>
<th>Produk</th>
<th>Jumlah</th>
<th>Total</th>
<th>Tanggal</th>
<th>Status</th>
</tr>

<?php if ($orders->num_rows > 0): ?>
<?php while($o = $orders->fetch_assoc()): ?>
<tr>
<td><?= $o['id'] ?></td>
<td><?= htmlspecialchars($o['produk_nama']) ?></td>
<td><?= $o['jumlah'] ?></td>
<td>Rp <?= number_format($o['total_harga']) ?></td>
<td><?= $o['tanggal_pesan'] ?></td>
<td>
<?php 
if($o['status'] == "menunggu") 
    echo "<span class='status-menunggu'>Menunggu</span>";
else if($o['status'] == "dikonfirmasi") 
    echo "<span class='status-proses'>Diproses</span>";
else 
    echo htmlspecialchars($o['status']);
?>
</td>
</tr>
<?php endwhile; ?>
<?php else: ?>
<tr><td colspan="6" style="text-align:center;">Belum ada pesanan aktif.</td></tr>
<?php endif; ?>
</table>

<br><br>

<!-- ================= PESANAN SELESAI ================= -->
<h3>Pesanan Selesai</h3>

<table>
<tr>
<th>ID</th>
<th>Produk</th>
<th>Jumlah</th>
<th>Total</th>
<th>Tgl Pesan</th>
<th>Tgl Selesai</th>
</tr>

<?php if ($done->num_rows > 0): ?>
<?php while($d = $done->fetch_assoc()): ?>
<tr>
<td><?= $d['id'] ?></td>
<td><?= htmlspecialchars($d['nama_pesanan']) ?></td>
<td><?= $d['jumlah'] ?></td>
<td>Rp <?= number_format($d['total_harga']) ?></td>
<td><?= $d['tanggal_pesan'] ?></td>
<td><span class="status-selesai"><?= $d['tanggal_selesai'] ?></span></td>
</tr>
<?php endwhile; ?>
<?php else: ?>
<tr><td colspan="6" style="text-align:center;">Belum ada pesanan selesai.</td></tr>
<?php endif; ?>
</table>

</body>
</html>
