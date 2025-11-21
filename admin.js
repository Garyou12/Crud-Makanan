// admin.js

// konfirmasi sebelum hapus produk
document.querySelectorAll('a[href*="delete_product.php"]').forEach(link => {
    link.addEventListener('click', function(e) {
        if (!confirm('Apakah kamu yakin ingin menghapus produk ini?')) {
            e.preventDefault();
        }
    });
});

// konfirmasi sebelum cancel order
document.querySelectorAll('a[href*="cancel_order_reason.php"]').forEach(link => {
    link.addEventListener('click', function(e) {
        if (!confirm('Apakah kamu yakin ingin membatalkan pesanan ini?')) {
            e.preventDefault();
        }
    });
});

// highlight baris table saat hover
document.querySelectorAll('table tr').forEach(row => {
    row.addEventListener('mouseenter', () => {
        row.style.backgroundColor = '#e0f4ea'; // hijau very light
    });
    row.addEventListener('mouseleave', () => {
        row.style.backgroundColor = '';
    });
});