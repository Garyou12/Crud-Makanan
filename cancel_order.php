<?php
include 'config.php';

if (!is_logged() || !is_admin()) {
    header("Location: index.php");
    exit;
}

$id = (int)$_POST['id'];
$alasan = $conn->real_escape_string($_POST['alasan']);

// ambil data order untuk dapat user_id
$check = $conn->query("SELECT * FROM orders WHERE id=$id");
$o = $check->fetch_assoc();

if ($o) {

    // simpan notifikasi ke user
    $conn->query("
        INSERT INTO notifications (user_id, order_id, pesan)
        VALUES ({$o['user_id']}, {$o['id']}, '$alasan')
    ");

    // hapus order
    $conn->query("DELETE FROM orders WHERE id=$id");
}

header("Location: admin.php");
exit;
?>
