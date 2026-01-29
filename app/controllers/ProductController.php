<?php

class ProductController extends Controller {

    // 1. HALAMAN UTAMA & SEARCH (Digabung biar rapi)
    public function index($page = 1) {
        $data['title'] = 'Katalog Produk';
        
        // --- LOGIKA PAGINATION ---
        $limit = 8; // Mau tampilkan berapa produk per halaman?
        $data['page'] = (int)$page;
        
        // Hitung mulai dari data ke berapa
        $data['start'] = ($data['page'] - 1) * $limit;
        
        // --- LOGIKA PENCARIAN (SEARCH) ---
        // Kita gabung di sini supaya hasil search tetap pakai view yang sama tanpa error
        if(isset($_POST['keyword'])) {
            $data['products'] = $this->model('Product_model')->searchProducts($_POST['keyword']);
            $data['keyword'] = $_POST['keyword'];
            $data['totalPages'] = 1; // Kalau search, kita set 1 halaman saja dulu biar simpel
        } else {
            // Kalau tidak search, ambil data normal dengan pagination
            $data['products'] = $this->model('Product_model')->getProductsByPage($data['start'], $limit);
            
            // Hitung Total Halaman
            $totalProducts = $this->model('Product_model')->countProducts();
            $data['totalPages'] = ceil($totalProducts / $limit);
        }
        
        $this->view('layouts/header', $data);
        $this->view('user/product/index', $data);
        $this->view('layouts/footer');
    }

    // 2. HALAMAN DETAIL (Pakai ID, bukan Slug)
    public function detail($id = null) {
        if( is_null($id) ) {
            header('Location: ' . BASEURL . '/product');
            exit;
        }

        // Pakai getProductById (sesuai Model kita)
        $data['product'] = $this->model('Product_model')->getProductById($id);
        
        if( !$data['product'] ) {
            // Kalau ID asal-asalan dan produk tidak ketemu
            header('Location: ' . BASEURL . '/product');
            exit;
        }

        $data['title'] = $data['product']['name'];
        
        // (Opsional) Kita hapus 'related' dulu karena Modelnya belum ada
        // $data['related'] = ... 

        $this->view('layouts/header', $data);
        $this->view('user/product/detail', $data);
        $this->view('layouts/footer');
    }

    // 3. HALAMAN FILTER KATEGORI
    public function category($id, $page = 1) {
        // Ambil nama kategori buat Judul
        $db = new Database;
        $db->query("SELECT name FROM categories WHERE id = :id");
        $db->bind('id', $id);
        $cat = $db->single();

        // Cek jika kategori tidak ditemukan
        if(!$cat) {
            header('Location: ' . BASEURL . '/product');
            exit;
        }

        $data['title'] = 'Kategori: ' . $cat['name'];
        $data['category_id'] = $id;
        
        // --- LOGIKA PAGINATION ---
        $limit = 6;
        $data['page'] = (int)$page;
        $data['start'] = ($data['page'] - 1) * $limit;
        
        // Panggil Model Khusus Kategori
        $data['products'] = $this->model('Product_model')->getProductsByCategory($id, $data['start'], $limit);
        
        // Hitung Halaman
        $totalProducts = $this->model('Product_model')->countProductsByCategory($id);
        $data['totalPages'] = ceil($totalProducts / $limit);
        
        $this->view('layouts/header', $data);
        $this->view('user/product/index', $data);
        $this->view('layouts/footer');
    }

    public function search() {
    $data['title'] = 'Hasil Pencarian';
    
    // Ambil keyword dari form pencarian
    $keyword = $_POST['keyword'];
    
    // Simpan keyword ke data biar bisa ditampilkan di view (opsional)
    $data['keyword'] = $keyword;
    
    // Panggil method searchProducts yang sudah ada di Model kamu
    $data['products'] = $this->model('Product_model')->searchProducts($keyword);
    
    // Kita gunakan view yang sama dengan index, tapi datanya hasil filter
    $this->view('layouts/header', $data);
    $this->view('user/product/index', $data); //
    $this->view('layouts/footer');
}
 


}