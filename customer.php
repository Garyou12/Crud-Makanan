<?php 
include 'config.php';
if (!is_logged() || is_admin()) { 
    header('Location:index.php'); 
    exit; 
}

// ambil produk
$prod = $conn->query("SELECT * FROM products");

// notif pembatalan
$uid = $_SESSION['user_id'];
$notif = $conn->query("
    SELECT COUNT(*) AS c 
    FROM notifications 
    WHERE user_id=$uid AND status='unread'
");
$n = $notif->fetch_assoc()['c'];
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Pelanggan</title>

<link rel="stylesheet" href="customer.css">
<script src="customer.js" defer></script>
</head>

<body>

<!-- ========== NAVBAR ========== -->
<div class="navbar">

    <div class="nav-left">
        Halo, <?= htmlspecialchars($_SESSION['nama_user']); ?>
    </div>

    <div class="nav-right">
        <a href="customer_orders.php" class="nav-btn">Pesanan</a>

        <a href="notifications.php" class="nav-btn">
            Notif
            <?php if ($n > 0): ?>
                <span class="badge"><?= $n ?></span>
            <?php endif; ?>
        </a>

        <a href="logout.php" class="nav-btn">Logout</a>
    </div>

</div>

<!-- ========== FORM PEMESANAN ========== -->
<h3>Form Pemesanan</h3>

<form method="post" action="place_order.php">

    <label>Pilih Menu</label>
    <select name="product_id" id="product" onchange="updateTotal()">
        <?php while ($p = $prod->fetch_assoc()): ?>
        <option value="<?= $p['id']; ?>" data-harga="<?= $p['harga']; ?>">
            <?= htmlspecialchars($p['nama']) . ' - Rp ' . number_format($p['harga']); ?>
        </option>
        <?php endwhile; ?>
    </select>

    <label>Jumlah</label>
    <input type="number" id="jumlah" name="jumlah" value="1" min="1" onchange="updateTotal()">

    <label>Total</label>
    <input type="text" id="total_harga" name="total_harga" readonly>

    <button type="submit">Pesan</button>
</form>

</body>
</html>
