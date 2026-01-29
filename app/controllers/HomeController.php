<?php
class HomeController extends Controller {
    public function index() {
        $data['title'] = 'SIBEAUTY - Premium Beauty Store';
        
        // Perbaikan: Panggil Model yang benar ('Product_model')
        // Dan gunakan method 'getLatestProducts' yang baru kita buat
        $data['products'] = $this->model('Product_model')->getLatestProducts(8);
        
        $this->view('layouts/header', $data);
        $this->view('user/home', $data);
        $this->view('layouts/footer');
    }
}