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
            // Cek dulu apakah bootstrap terdefinisi (jaga-jaga)
            if (typeof bootstrap !== 'undefined') {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 3000);
    });

    // 2. KONFIRMASI HAPUS
    // Menghindari user atau admin tidak sengaja menghapus data
    const deleteButtons = document.querySelectorAll('.btn-hapus');
    
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            if (!confirm('Apakah kamu yakin ingin menghapus data ini?')) {
                e.preventDefault();
            }
        });
    });

    // 3. KONFIRMASI LOGOUT
    // Khusus menangkap link yang mengarah ke logout
    const logoutButton = document.querySelector('a[href*="logout"]');
    
    if (logoutButton) {
        logoutButton.addEventListener('click', function(e) {
            if (!confirm('Yakin ingin keluar dari akun?')) {
                e.preventDefault();
            }
        });
    }

    // 4. LOGIKA KERANJANG (PLUS/MINUS QUANTITY)
    // Memudahkan user mengatur jumlah barang di halaman keranjang
    const btnPlus = document.querySelectorAll('.btn-plus');
    const btnMinus = document.querySelectorAll('.btn-minus');

    btnPlus.forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            if(input) input.value = parseInt(input.value) + 1;
        });
    });

    btnMinus.forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            if (input && parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        });
    });

    // 5. PREVIEW GAMBAR (UNTUK UPLOAD PRODUK)
    // Menampilkan gambar secara instan saat Admin memilih file foto baru
    const inputGambar = document.querySelector('#image-upload');
    const previewGambar = document.querySelector('.img-preview');

    if (inputGambar && previewGambar) {
        inputGambar.onchange = function() {
            const [file] = inputGambar.files;
            if (file) {
                previewGambar.src = URL.createObjectURL(file);
                // Tampilkan gambar jika sebelumnya hidden
                previewGambar.style.display = 'block'; 
            }
        };
    }

    console.log("SIBEAUTY Script: Berhasil dimuat! 🚀");

    // ============================================================
    // [FIX] PENGAMAN NAVBAR SCROLL (BAGIAN INI YANG TADI ERROR)
    // ============================================================
    const navbar = document.querySelector('.navbar-sibeauty');
    
    // Kita cek dulu: "Apakah Navbar-nya ADA?"
    if (navbar) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
                navbar.classList.remove('py-3'); // Kecilkan padding
            } else {
                navbar.classList.remove('navbar-scrolled');
                navbar.classList.add('py-3'); // Balikkan padding normal
            }
        });
    }
});