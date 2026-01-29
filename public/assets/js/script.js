/**
 * SIBEAUTY - Project JavaScript
 * Menangani interaksi UI/UX di website
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // 1. AUTO-HIDE ALERT (FLASHER)
    // Berfungsi untuk menghilangkan notifikasi sukses/error secara otomatis setelah 3 detik
    const flashMessages = document.querySelectorAll('.alert-dismissible');
    flashMessages.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 3000);
    });

    // 2. KONFIRMASI HAPUS
    // Menghindari user atau admin tidak sengaja menghapus data
    // 2. KONFIRMASI HAPUS (Perbaikan)
    // Kita hapus selector '.text-danger' agar Logout tidak kena target
    const deleteButtons = document.querySelectorAll('.btn-hapus');
    
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            if (!confirm('Apakah kamu yakin ingin menghapus data ini?')) {
                e.preventDefault();
            }
        });
    });

    // 3. KONFIRMASI LOGOUT (Baru)
    // Khusus menangkap link yang mengarah ke logout
    const logoutButton = document.querySelector('a[href*="logout"]');
    
    if (logoutButton) {
        logoutButton.addEventListener('click', function(e) {
            if (!confirm('Yakin ingin keluar dari akun?')) {
                e.preventDefault();
            }
        });
    }

    // 4. LOGIKA KERANJANG (Lanjutannya sama seperti sebelumnya...)
    // ... (kode btnPlus / btnMinus biarkan saja) ...

    // 3. LOGIKA KERANJANG (PLUS/MINUS QUANTITY)
    // Memudahkan user mengatur jumlah barang di halaman keranjang
    const btnPlus = document.querySelectorAll('.btn-plus');
    const btnMinus = document.querySelectorAll('.btn-minus');

    btnPlus.forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            input.value = parseInt(input.value) + 1;
        });
    });

    btnMinus.forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        });
    });

    // 4. PREVIEW GAMBAR (UNTUK UPLOAD PRODUK)
    // Menampilkan gambar secara instan saat Admin memilih file foto baru
    const inputGambar = document.querySelector('#image-upload');
    const previewGambar = document.querySelector('.img-preview');

    if (inputGambar && previewGambar) {
        inputGambar.onchange = function() {
            const [file] = inputGambar.files;
            if (file) {
                previewGambar.src = URL.createObjectURL(file);
            }
        };
    }

    console.log("SIBEAUTY Script: Berhasil dimuat! 🚀");
});