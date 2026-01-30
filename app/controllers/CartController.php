<?php

class CartController extends Controller {
    
    // 1. HALAMAN KERANJANG
    public function index() {
        if(!isset($_SESSION['user_session'])) {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }

        $data['title'] = 'Keranjang Belanja';
        $userId = $_SESSION['user_session']['id'];
        
        // Ambil data keranjang user
        $data['cart'] = $this->model('Cart_model')->getCartByUser($userId);
        
        $this->view('layouts/header', $data);
        $this->view('user/cart/index', $data);
        $this->view('layouts/footer');
    }

    // 2. TAMBAH KE KERANJANG (Anti-Crash)
    // Kita kasih default null ($id = null) biar gak error kalau URL-nya kosong
    public function add($id = null) {
        // Cek Login dulu
        if(!isset($_SESSION['user_session'])) {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }

        // LOGIKA PENYELAMAT:
        // Kalau $id kosong (null), coba cari di data POST (dari form)
        if( $id === null ) {
            if( isset($_POST['product_id']) ) {
                $id = $_POST['product_id'];
            } else {
                // Kalau di URL gak ada, di POST juga gak ada -> Balikin ke halaman produk
                header('Location: ' . BASEURL . '/product');
                exit;
            }
        }

        $userId = $_SESSION['user_session']['id'];
        
        // Ambil quantity dari form, kalau gak ada anggap 1
        $qty = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

        // Panggil Model untuk simpan
        if( $this->model('Cart_model')->addToCart($userId, $id, $qty) > 0 ) {
            Flasher::setFlash('berhasil', 'masuk keranjang', 'success');
        } else {
            // Kalau gagal (misal stok habis atau error sistem)
            Flasher::setFlash('gagal', 'masuk keranjang', 'danger');
        }
        
        // Redirect ke halaman keranjang biar user tau barangnya masuk
        header('Location: ' . BASEURL . '/cart');
        exit;
    }

    // 3. HAPUS ITEM KERANJANG
    public function delete($id = null) {
        if( !isset($_SESSION['user_session']) || $id === null ) {
            header('Location: ' . BASEURL . '/cart');
            exit;
        }
        
        // Hapus item spesifik (perlu method deleteItem di Cart_model)
        if( $this->model('Cart_model')->removeFromCart($id) > 0 ) {
            Flasher::setFlash('berhasil', 'dihapus', 'warning');
        }
        
        header('Location: ' . BASEURL . '/cart');
        exit;
    }

    // 4. UPDATE QUANTITY (Opsional, buat tombol +/- di keranjang)
    public function update() {
        if(isset($_POST['id']) && isset($_POST['qty'])) {
            $id = $_POST['id'];
            $qty = $_POST['qty'];
            
            // Panggil model update
            $this->model('Cart_model')->updateQuantity($id, $qty);
        }
        header('Location: ' . BASEURL . '/cart');
        exit;
    }
}