<?php

class ProductController extends Controller {

    // 1. HALAMAN UTAMA (KATALOG)
    public function index($page = 1) {
        $data['title'] = 'Katalog Produk';
        
        // --- PAGINATION ---
        $limit = 9; 
        $data['page'] = (int)$page;
        $data['start'] = ($data['page'] - 1) * $limit;
        
        // --- DATA PRODUK ---
        // Kita pakai getProductsByPage sesuai model kamu
        $data['products'] = $this->model('Product_model')->getProductsByPage($data['start'], $limit);
        
        // Hitung Total Halaman
        $totalProducts = $this->model('Product_model')->countProducts();
        $data['totalPages'] = ceil($totalProducts / $limit);
        
        // --- [PENTING] DATA KATEGORI (INI YANG HILANG) ---
        // Kita ambil semua kategori, lalu susun jadi Induk-Anak
        $rawCategories = $this->model('Category_model')->getAllCategories();
        $data['categories'] = $this->organizeCategories($rawCategories);

        $this->view('layouts/header', $data);
        $this->view('user/product/index', $data);
        $this->view('layouts/footer');
    }

    // 2. HALAMAN DETAIL PRODUK
    public function detail($id = null) {
        if(is_null($id)) {
            header('Location: ' . BASEURL . '/product');
            exit;
        }

        $data['product'] = $this->model('Product_model')->getProductById($id);
        
        if(!$data['product']) {
            header('Location: ' . BASEURL . '/product');
            exit;
        }

        $data['title'] = $data['product']['name'];
        
        // Tampilkan kategori juga di header/sidebar jika perlu
        $rawCategories = $this->model('Category_model')->getAllCategories();
        $data['categories'] = $this->organizeCategories($rawCategories);

        $this->view('layouts/header', $data);
        $this->view('user/product/detail', $data);
        $this->view('layouts/footer');
    }

    // 3. HALAMAN FILTER PER KATEGORI
    public function category($id, $page = 1) {
        // Ambil info kategori via Model (Bukan query manual lagi biar rapi)
        $cat = $this->model('Category_model')->getCategoryById($id);

        if(!$cat) {
            header('Location: ' . BASEURL . '/product');
            exit;
        }

        $data['title'] = 'Kategori: ' . $cat['name'];
        $data['category_id'] = $id;
        
        // Pagination
        $limit = 9;
        $data['page'] = (int)$page;
        $data['start'] = ($data['page'] - 1) * $limit;
        
        // Ambil Produk per Kategori
        $data['products'] = $this->model('Product_model')->getProductsByCategory($id, $data['start'], $limit);
        
        // Hitung Total Data Kategori
        $totalProducts = $this->model('Product_model')->countProductsByCategory($id);
        $data['totalPages'] = ceil($totalProducts / $limit);

        // --- [PENTING] DATA KATEGORI SIDEBAR ---
        $rawCategories = $this->model('Category_model')->getAllCategories();
        $data['categories'] = $this->organizeCategories($rawCategories);
        
        $this->view('layouts/header', $data);
        $this->view('user/product/index', $data);
        $this->view('layouts/footer');
    }

    // 4. HASIL PENCARIAN
    public function search() {
        $data['title'] = 'Hasil Pencarian';
        
        if(isset($_POST['keyword'])) {
            $keyword = $_POST['keyword'];
            $data['keyword'] = $keyword;
            $data['products'] = $this->model('Product_model')->searchProducts($keyword);
        } else {
            header('Location: ' . BASEURL . '/product');
            exit;
        }

        // --- [PENTING] DATA KATEGORI SIDEBAR ---
        // Biarpun lagi cari barang, sidebar kategori harus tetap muncul
        $rawCategories = $this->model('Category_model')->getAllCategories();
        $data['categories'] = $this->organizeCategories($rawCategories);
        
        $this->view('layouts/header', $data);
        $this->view('user/product/index', $data);
        $this->view('layouts/footer');
    }

    // =========================================================
    // HELPER: MENYUSUN KATEGORI INDUK & ANAK
    // =========================================================
    private function organizeCategories($cats) {
        $tree = [];
        // 1. Ambil Induk (yang parent_id nya kosong)
        foreach($cats as $cat) {
            if($cat['parent_id'] == null) {
                $cat['children'] = [];
                $tree[$cat['id']] = $cat;
            }
        }
        // 2. Masukkan Anak ke Induknya
        foreach($cats as $cat) {
            if($cat['parent_id'] != null) {
                if(isset($tree[$cat['parent_id']])) {
                    $tree[$cat['parent_id']]['children'][] = $cat;
                }
            }
        }
        return $tree;
    }
}