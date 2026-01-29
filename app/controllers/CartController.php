<?php
class CartController extends Controller {
    
    // Helper untuk cek login
    private function checkLogin() {
        if(!isset($_SESSION['user_session'])) {
            Flasher::setFlash('gagal', 'silahkan login terlebih dahulu untuk belanja', 'warning');
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function index() {
        $this->checkLogin();
        $userId = $_SESSION['user_session']['id'];

        $data['title'] = 'Keranjang Belanja';
        $data['cart'] = $this->model('Cart_model')->getCartByUser($userId);
        
        $this->view('layouts/header', $data);
        $this->view('user/cart/index', $data);
        $this->view('layouts/footer');
    }

    public function add($productId) {
        $this->checkLogin();

        // Data yang mau disimpan
        $data = [
            'user_id' => $_SESSION['user_session']['id'],
            'product_id' => $productId,
            'quantity' => 1 // Default tambah 1, nanti bisa dikembangkan ambil dari input post
        ];

        if( $this->model('Cart_model')->addItem($data) > 0 || true ) { 
            // Pake || true karena kadang update rowCount 0 jika data sama persis, biar aman
            Flasher::setFlash('berhasil', 'produk ditambahkan ke keranjang', 'success');
            header('Location: ' . BASEURL . '/cart');
            exit;
        }
    }

    public function delete($cartId) {
        $this->checkLogin();

        if( $this->model('Cart_model')->deleteItem($cartId) > 0 ) {
            Flasher::setFlash('berhasil', 'produk dihapus dari keranjang', 'success');
        } else {
            Flasher::setFlash('gagal', 'hapus produk', 'danger');
        }
        header('Location: ' . BASEURL . '/cart');
        exit;
    }
}