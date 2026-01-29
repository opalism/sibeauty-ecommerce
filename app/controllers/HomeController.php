<?php
class HomeController extends Controller {
    public function index() {
        $data['title'] = 'Premium Beauty Store';
        // Nanti kita ambil data produk dari Model disini
        // $data['products'] = $this->model('Product')->getBestSellers();
        
        $this->view('layouts/header', $data);
        $this->view('user/home', $data);
        $this->view('layouts/footer');
    }
}