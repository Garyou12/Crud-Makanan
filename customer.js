// Auto-update total harga
function updateTotal() {
    const select = document.getElementById("product");
    const jumlah = parseInt(document.getElementById("jumlah").value || 0);

    const harga = parseInt(select.selectedOptions[0].dataset.harga || 0);
    const total = harga * jumlah;

    document.getElementById("total_harga").value = total;
}

// Set total saat halaman pertama kali dibuka
window.addEventListener("DOMContentLoaded", () => {
    updateTotal();

    // animasi hover pada navbar
    document.querySelectorAll(".navbar a").forEach(a => {
        a.addEventListener("mouseenter", () => {
            a.style.transform = "translateY(-2px)";
        });
        a.addEventListener("mouseleave", () => {
            a.style.transform = "translateY(0)";
        });
    });
});