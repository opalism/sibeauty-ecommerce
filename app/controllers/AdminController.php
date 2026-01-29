<?php

class AdminController extends Controller {

    public function __construct() {
        // Cek Login Admin - SATU PINTU
        if(!isset($_SESSION['user_session']) || $_SESSION['user_session']['role'] != 'admin') {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }
    }

    public function index() {
        $data['title'] = 'Dashboard Admin';
        
        // Menggunakan count() PHP biasa agar aman jika model belum punya fungsi count khusus
        $products = $this->model('Product_model')->getAllProducts();
        $data['total_products'] = count($products);
        
        // Menggunakan method baru di Order_model
        $data['total_orders']   = $this->model('Order_model')->countOrders();
        $data['total_income']   = $this->model('Order_model')->calculateIncome();
        
        $data['recent_orders']  = $this->model('Order_model')->getAllOrders(); 

        $this->view('layouts/admin_header', $data);
        $this->view('admin/index', $data);
        $this->view('layouts/admin_footer');
    }

    // ... (Fungsi Products, Categories, Orders biarkan sama seperti sebelumnya) ...
    // ... Agar tidak kepanjangan, saya taruh inti perubahannya di bawah ini ...

    public function products() {
        $data['title'] = 'Kelola Produk';
        $data['products'] = $this->model('Product_model')->getAllProducts();
        $this->view('layouts/admin_header', $data);
        $this->view('admin/products/index', $data);
        $this->view('layouts/admin_footer');
    }
    
    public function orders() {
        $data['title'] = 'Kelola Pesanan';
        $data['orders'] = $this->model('Order_model')->getAllOrders();
        $this->view('layouts/admin_header', $data);
        $this->view('admin/orders/index', $data);
        $this->view('layouts/admin_footer');
    }

    public function orderDetail($id) {
        $data['title'] = 'Detail Pesanan';
        $data['order'] = $this->model('Order_model')->getOrderById($id);
        $data['items'] = $this->model('Order_model')->getOrderItems($id);
        $this->view('layouts/admin_header', $data);
        $this->view('admin/orders/detail', $data);
        $this->view('layouts/admin_footer');
    }

    public function categories() {
        $data['title'] = 'Kelola Kategori';
        $data['categories'] = $this->model('Category_model')->getAllCategories();
        $this->view('layouts/admin_header', $data);
        $this->view('admin/categories/index', $data);
        $this->view('layouts/admin_footer');
    }

    // --- [BARU] FITUR LAPORAN ---
    public function laporan() {
        $data['title'] = 'Laporan Penjualan';
        
        // Ambil data yang statusnya 'completed'
        $data['orders'] = $this->model('Order_model')->getCompletedOrders();
        
        // Load view khusus laporan
        $this->view('admin/laporan', $data);
    }
}