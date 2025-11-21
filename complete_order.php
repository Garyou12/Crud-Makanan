<?php
include 'config.php';

if (!is_logged() || !is_admin()) {
    header('Location: index.php');
    exit;
}

$id = (int)$_GET['id'];

$res = $conn->query("
    SELECT o.*, u.nama_user, p.nama AS nama_pesanan
    FROM orders o
    JOIN users u ON o.user_id = u.id
    JOIN products p ON o.product_id = p.id
    WHERE o.id=$id
");

$data = $res->fetch_assoc();

if ($data) {
    $conn->query("
        INSERT INTO orders_selesai
        (id, user_id, nama_user, product_id, nama_pesanan, jumlah, total_harga, tanggal_pesan, tanggal_selesai)
        VALUES (
            {$data['id']},
            {$data['user_id']},
            '{$data['nama_user']}',
            {$data['product_id']},
            '{$data['nama_pesanan']}',
            {$data['jumlah']},
            {$data['total_harga']},
            '{$data['tanggal_pesan']}',
            NOW()
        )
    ");

    $conn->query("DELETE FROM orders WHERE id=$id");
}

header("Location: admin.php");
exit;
?>
