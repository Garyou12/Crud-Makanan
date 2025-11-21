<?php
include 'config.php';

if(!is_logged() || is_admin()) {
    header("Location:index.php");
    exit;
}

$uid = $_SESSION['user_id'];

$notif = $conn->query("
    SELECT * 
    FROM notifications 
    WHERE user_id=$uid
    ORDER BY tanggal DESC
");

// tandai semua notif sebagai read
$conn->query("UPDATE notifications SET status='read' WHERE user_id=$uid");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Notifikasi</title>

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

/* table rapih & teks center */
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
        Notifikasi
    </div>

    <div class="nav-right">
        <a href="customer.php" class="nav-btn">Beranda</a>
        <a href="customer_orders.php" class="nav-btn">Pesanan</a>
        <a href="logout.php" class="nav-btn">Logout</a>
    </div>
</div>

<h2>Notifikasi Pembatalan</h2>

<table>
<tr>
<th>Tanggal</th>
<th>Order ID</th>
<th>Alasan</th>
</tr>

<?php while($n = $notif->fetch_assoc()): ?>
<tr>
<td><?= $n['tanggal'] ?></td>
<td>#<?= $n['order_id'] ?></td>
<td><?= htmlspecialchars($n['pesan']) ?></td>
</tr>
<?php endwhile; ?>

</table>

</body>
</html>
