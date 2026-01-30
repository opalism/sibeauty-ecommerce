<?php

class ProductController extends Controller {

    // 1. HALAMAN UTAMA & SEARCH
    public function index($page = 1) {
        $data['title'] = 'Katalog Produk';
        
        // --- LOGIKA PAGINATION ---
        $limit = 8;
        $data['page'] = (int)$page;
        $data['start'] = ($data['page'] - 1) * $limit;
        
        // --- LOGIKA PENCARIAN (SEARCH) ---
        if(isset($_POST['keyword'])) {
            $data['products'] = $this->model('Product_model')->searchProducts($_POST['keyword']);
            $data['keyword'] = $_POST['keyword'];
            $data['totalPages'] = 1; 
        } else {
            $data['products'] = $this->model('Product_model')->getProductsByPage($data['start'], $limit);
            
            // Hitung Total Halaman
            $totalProducts = $this->model('Product_model')->countProducts();
            $data['totalPages'] = ceil($totalProducts / $limit);
        }
        
        $this->view('layouts/header', $data);
        $this->view('user/product/index', $data);
        $this->view('layouts/footer');
    }

    // 2. HALAMAN DETAIL
    public function detail($id = null) {
        if( is_null($id) ) {
            header('Location: ' . BASEURL . '/product');
            exit;
        }

        $data['product'] = $this->model('Product_model')->getProductById($id);
        
        if( !$data['product'] ) {
            header('Location: ' . BASEURL . '/product');
            exit;
        }

        $data['title'] = $data['product']['name'];
        
        // Ambil produk serupa (opsional, jika model support)
        // $data['related'] = $this->model('Product_model')->getRelatedProducts($data['product']['category_id'], $id);

        $this->view('layouts/header', $data);
        $this->view('user/product/detail', $data);
        $this->view('layouts/footer');
    }

    // 3. HALAMAN FILTER KATEGORI
    public function category($id, $page = 1) {
        // PERBAIKAN: Pakai Model, jangan bikin koneksi Database manual di Controller (melanggar MVC)
        // Pastikan Category_model punya method 'getCategoryById' atau kita query manual lewat model jika kepepet
        // Disini saya pakai query manual lewat db wrapper controller biar aman
        $db = new Database;
        $db->query("SELECT name FROM categories WHERE id = :id");
        $db->bind('id', $id);
        $cat = $db->single();

        if(!$cat) {
            header('Location: ' . BASEURL . '/product');
            exit;
        }

        $data['title'] = 'Kategori: ' . $cat['name'];
        $data['category_id'] = $id;
        
        // Pagination Kategori
        $limit = 6;
        $data['page'] = (int)$page;
        $data['start'] = ($data['page'] - 1) * $limit;
        
        $data['products'] = $this->model('Product_model')->getProductsByCategory($id, $data['start'], $limit);
        
        $totalProducts = $this->model('Product_model')->countProductsByCategory($id);
        $data['totalPages'] = ceil($totalProducts / $limit);
        
        $this->view('layouts/header', $data);
        $this->view('user/product/index', $data);
        $this->view('layouts/footer');
    }

    // 4. LOGIKA SEARCH (Route Khusus)
    public function search() {
        $data['title'] = 'Hasil Pencarian';
        
        // PERBAIKAN: Cek dulu apakah ada POST keyword
        if(isset($_POST['keyword'])) {
            $keyword = $_POST['keyword'];
            $data['keyword'] = $keyword;
            $data['products'] = $this->model('Product_model')->searchProducts($keyword);
        } else {
            // Kalau akses langsung tanpa ngetik, balikin ke index
            header('Location: ' . BASEURL . '/product');
            exit;
        }
        
        $this->view('layouts/header', $data);
        $this->view('user/product/index', $data);
        $this->view('layouts/footer');
    }
}