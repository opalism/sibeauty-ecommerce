<?php

class Product_model {
    private $table = 'products';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // 1. Ambil SEMUA produk (Untuk Admin)
    public function getAllProducts() {
        $this->db->query("SELECT products.*, categories.name as category_name 
                          FROM products 
                          JOIN categories ON products.category_id = categories.id 
                          ORDER BY products.id DESC");
        return $this->db->resultSet();
    }

    // 2. AMBIL SATU PRODUK BERDASARKAN ID (SOLUSI ERROR TADI)
    public function getProductById($id) {
    // Kita JOIN ke tabel categories agar bisa ambil kolom 'name' sebagai 'category_name'
    $query = "SELECT products.*, categories.name as category_name 
              FROM " . $this->table . " 
              JOIN categories ON products.category_id = categories.id 
              WHERE products.id = :id";
              
    $this->db->query($query);
    $this->db->bind('id', $id);
    return $this->db->single();
}

    // 3. Ambil Produk dengan Pagination (Untuk User)
    public function getProductsByPage($start, $limit) {
        $query = "SELECT products.*, categories.name as category_name 
                  FROM products 
                  JOIN categories ON products.category_id = categories.id 
                  ORDER BY products.id DESC LIMIT :start, :limit";
        $this->db->query($query);
        $this->db->bind('start', $start);
        $this->db->bind('limit', $limit);
        return $this->db->resultSet();
    }

    // 4. Hitung Total Produk
    public function countProducts() {
        $this->db->query("SELECT COUNT(*) as total FROM products");
        $result = $this->db->single();
        return $result['total'];
    }

    // 5. PROSES UPDATE PRODUK (UNTUK EDIT)
    public function updateProduct($data, $file) {
        $id = $data['id'];
        $oldImage = $data['oldImage'];

        // Cek apakah ada upload gambar baru
        if($file['image']['error'] === 4) {
            $image = $oldImage;
        } else {
            $image = $this->uploadImage($file);
            if(!$image) return 0;
            
            // Hapus foto lama biar hemat storage
            if(file_exists('assets/img/products/' . $oldImage) && $oldImage != 'default.jpg') {
                unlink('assets/img/products/' . $oldImage);
            }
        }

        $query = "UPDATE products SET 
                    name = :name, 
                    category_id = :cat_id, 
                    description = :desc, 
                    price = :price, 
                    stock = :stock, 
                    image = :img 
                  WHERE id = :id";
        
        $this->db->query($query);
        $this->db->bind('name', $data['name']);
        $this->db->bind('cat_id', $data['category_id']);
        $this->db->bind('desc', $data['description']);
        $this->db->bind('price', $data['price']);
        $this->db->bind('stock', $data['stock']);
        $this->db->bind('img', $image);
        $this->db->bind('id', $id);

        $this->db->execute();
        return $this->db->rowCount();
    }

    // 6. FUNGSI UPLOAD GAMBAR
    // Perbaikan pada Method uploadImage di Product_model.php
    public function uploadImage($file) {
        $namaFile = $file['image']['name'];
        $tmpName = $file['image']['tmp_name'];
        $error = $file['image']['error'];

        if($error === 4) return false;

        $ekstensiValid = ['jpg', 'jpeg', 'png', 'webp'];
        // Perbaikan: end() butuh variabel, tidak bisa langsung hasil fungsi explode
        $pecahNama = explode('.', $namaFile);
        $ekstensi = strtolower(end($pecahNama));

        if(!in_array($ekstensi, $ekstensiValid)) return false;

        $namaBaru = uniqid() . '.' . $ekstensi;
        
        // Pastikan path sesuai struktur: public/assets/img/products/
        move_uploaded_file($tmpName, 'assets/img/products/' . $namaBaru);

        return $namaBaru;
    }

    // 7. FITUR RESTOCK CEPAT (+)
    public function addStock($id, $quantity) {
        $query = "UPDATE products SET stock = stock + :qty WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('qty', $quantity);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    // --- SISANYA FUNGSI BAWAAN KAMU ---
    public function getProductBySlug($slug) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE slug = :slug');
        $this->db->bind('slug', $slug);
        return $this->db->single();
    }

    public function searchProducts($keyword) {
        $query = "SELECT * FROM products WHERE name LIKE :keyword";
        $this->db->query($query);
        $this->db->bind('keyword', "%$keyword%");
        return $this->db->resultSet();
    }

    public function getProductsByCategory($categoryId, $start, $limit) {
        $query = "SELECT * FROM products WHERE category_id = :cat_id ORDER BY id DESC LIMIT :start, :limit";
        $this->db->query($query);
        $this->db->bind('cat_id', $categoryId);
        $this->db->bind('start', $start);
        $this->db->bind('limit', $limit);
        return $this->db->resultSet();
    }

    public function countProductsByCategory($categoryId) {
        $query = "SELECT COUNT(*) as total FROM products WHERE category_id = :cat_id";
        $this->db->query($query);
        $this->db->bind('cat_id', $categoryId);
        $result = $this->db->single();
        return $result['total'];
    }

    public function deleteProduct($id) {
        $this->db->query("DELETE FROM products WHERE id = :id");
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }
}