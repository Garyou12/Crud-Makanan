<?php
include 'config.php';

if (!is_logged() || !is_admin()) {
    header("Location: index.php");
    exit;
}

$id = (int)$_GET['id'];

// ambil informasi order
$res = $conn->query("
    SELECT o.*, u.nama_user 
    FROM orders o 
    JOIN users u ON o.user_id = u.id 
    WHERE o.id=$id
");
$o = $res->fetch_assoc();
?>
<!doctype html>
<html>
<head>
<title>Alasan Pembatalan</title>
</head>
<body>

<h3>Batalkan Pesanan #<?= $o['id'] ?> - <?= htmlspecialchars($o['nama_user']) ?></h3>

<form method="post" action="cancel_order.php">
    <input type="hidden" name="id" value="<?= $o['id'] ?>">

    <label>Alasan Pembatalan:</label><br>
    <textarea name="alasan" required cols="40" rows="5"></textarea><br><br>

    <button type="submit">Kirim</button>
</form>

</body>
</html>
