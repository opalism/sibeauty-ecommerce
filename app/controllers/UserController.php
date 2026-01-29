<?php

class UserController extends Controller {
    
    public function index() {
        // Proteksi: Jika belum login, tendang ke halaman login
        if(!isset($_SESSION['user_session'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }

        $data['title'] = 'Home - SIBEAUTY';
        $data['user'] = $_SESSION['user_session'];
        
        // Ambil 4 produk terbaru/terlaris untuk ditampilkan di Home
        $data['products'] = $this->model('Product_model')->getProductsByPage(0, 4);

        $this->view('layouts/header', $data);
        $this->view('user/index', $data); // Ini file yang kamu kirim tadi
        $this->view('layouts/footer');
    }
}