<?php

class AdminController extends Controller {

    public function __construct() {
        if(!isset($_SESSION['user_session']) || $_SESSION['user_session']['role'] != 'admin') {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }
    }

    public function index() {
        $data['title'] = 'Dashboard Admin';
        $data['total_products'] = count($this->model('Product_model')->getAllProducts());
        $data['total_orders']   = $this->model('Order_model')->countOrders();
        $data['total_income']   = $this->model('Order_model')->calculateIncome();
        $data['recent_orders']  = $this->model('Order_model')->getAllOrders(); 

        $this->view('layouts/admin_header', $data);
        $this->view('admin/index', $data);
        $this->view('layouts/admin_footer');
    }

    // --- PRODUK ---
    public function products() {
        $data['title'] = 'Kelola Produk';
        $data['products'] = $this->model('Product_model')->getAllProducts();
        $this->view('layouts/admin_header', $data);
        $this->view('admin/products/index', $data);
        $this->view('layouts/admin_footer');
    }

    public function productCreate() {
        $data['title'] = 'Tambah Produk';
        $data['categories'] = $this->model('Category_model')->getAllCategories();
        $this->view('layouts/admin_header', $data);
        $this->view('admin/products/create', $data);
        $this->view('layouts/admin_footer');
    }

    public function productStore() {
        if($this->model('Product_model')->addProduct($_POST, $_FILES) > 0) {
            Flasher::setFlash('berhasil', 'ditambahkan', 'success');
        } else {
            Flasher::setFlash('gagal', 'ditambahkan', 'danger');
        }
        header('Location: ' . BASEURL . '/admin/products');
        exit;
    }

    public function productEdit($id) {
        $data['title'] = 'Edit Produk';
        $data['product'] = $this->model('Product_model')->getProductById($id);
        $data['categories'] = $this->model('Category_model')->getAllCategories();
        $this->view('layouts/admin_header', $data);
        $this->view('admin/products/edit', $data);
        $this->view('layouts/admin_footer');
    }

    public function productUpdate() {
        if($this->model('Product_model')->updateProduct($_POST, $_FILES) > 0) {
            Flasher::setFlash('berhasil', 'diupdate', 'success');
        } else {
            Flasher::setFlash('info', 'Data produk diperbarui', 'primary');
        }
        header('Location: ' . BASEURL . '/admin/products');
        exit;
    }

    public function productDelete($id) {
        if($this->model('Product_model')->deleteProduct($id) > 0) {
            Flasher::setFlash('berhasil', 'dihapus', 'success');
        } else {
            Flasher::setFlash('gagal', 'dihapus', 'danger');
        }
        header('Location: ' . BASEURL . '/admin/products');
        exit;
    }

    public function productRestock() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($this->model('Product_model')->addStock($_POST['product_id'], $_POST['quantity']) > 0) {
                Flasher::setFlash('berhasil', 'stok ditambahkan', 'success');
            } else {
                Flasher::setFlash('gagal', 'menambah stok', 'danger');
            }
        }
        header('Location: ' . BASEURL . '/admin/products');
        exit;
    }

    // --- KATEGORI (INI YANG KITA TAMBAHKAN) ---
    public function categories() {
        $data['title'] = 'Kelola Kategori';
        $data['categories'] = $this->model('Category_model')->getAllCategories();
        $this->view('layouts/admin_header', $data);
        $this->view('admin/categories/index', $data);
        $this->view('layouts/admin_footer');
    }

    public function categoryStore() {
        if($this->model('Category_model')->addCategory($_POST) > 0) {
            Flasher::setFlash('berhasil', 'kategori ditambahkan', 'success');
        } else {
            Flasher::setFlash('gagal', 'menambah kategori', 'danger');
        }
        header('Location: ' . BASEURL . '/admin/categories');
        exit;
    }

    public function categoryUpdate() {
        if($this->model('Category_model')->updateCategory($_POST) > 0) {
            Flasher::setFlash('berhasil', 'kategori diupdate', 'success');
        } else {
            Flasher::setFlash('gagal', 'mengupdate kategori', 'danger');
        }
        header('Location: ' . BASEURL . '/admin/categories');
        exit;
    }

    public function categoryDelete($id) {
        if($this->model('Category_model')->deleteCategory($id) > 0) {
            Flasher::setFlash('berhasil', 'kategori dihapus', 'success');
        } else {
            Flasher::setFlash('gagal', 'menghapus kategori', 'danger');
        }
        header('Location: ' . BASEURL . '/admin/categories');
        exit;
    }

    // --- PESANAN & LAPORAN ---
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

    public function updateOrder() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['order_id'];
            $status = $_POST['status'];
            if($this->model('Order_model')->updateStatus($id, $status) > 0) {
                Flasher::setFlash('berhasil', 'status diperbarui', 'success');
            } else {
                Flasher::setFlash('gagal', 'memperbarui status', 'danger');
            }
            header('Location: ' . BASEURL . '/admin/orderDetail/' . $id);
            exit;
        }
    }

    public function laporan() {
        $data['title'] = 'Laporan Penjualan';
        $data['orders'] = $this->model('Order_model')->getCompletedOrders();
        $this->view('admin/laporan', $data);
    }
}