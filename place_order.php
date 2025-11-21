<?php
include 'config.php';

if (!is_logged() || is_admin()) { 
    header('Location: index.php'); 
    exit; 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $uid = (int)$_SESSION['user_id'];
    $product_id = (int)$_POST['product_id'];
    $jumlah = (int)$_POST['jumlah'];
    $total = (int)$_POST['total_harga'];

    // ambil nama produk (buat disimpan ke orders biar gampang lihat)
    $cek = $conn->query("SELECT nama FROM products WHERE id=$product_id LIMIT 1");
    $p = $cek->fetch_assoc();
    $nama_pesanan = $p['nama'];

    // simpan ke tabel orders
    $q = "
    INSERT INTO orders (user_id, product_id, nama_pesanan, jumlah, total_harga, tanggal_pesan, status, locked)
    VALUES ($uid, $product_id, '$nama_pesanan', $jumlah, $total, NOW(), 'menunggu', 0)
    ";

    if ($conn->query($q)) {
        header("Location: customer.php");
        exit;
    } else {
        echo "Gagal menyimpan pesanan: " . $conn->error;
    }
}
?>
