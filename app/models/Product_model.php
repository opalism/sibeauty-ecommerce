<?php

class Product_model {
    private $table = 'products';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // 1. TAMBAH PRODUK (DULU HILANG, SEKARANG ADA)
    public function addProduct($data) {
        $query = "INSERT INTO products (name, slug, category_id, description, price, stock, gender, image) 
                  VALUES (:name, :slug, :category_id, :description, :price, :stock, :gender, :image)";
        
        $this->db->query($query);
        $this->db->bind('name', $data['name']);
        $this->db->bind('slug', $data['slug']);
        $this->db->bind('category_id', $data['category_id']);
        $this->db->bind('description', $data['description']);
        $this->db->bind('price', $data['price']);
        $this->db->bind('stock', $data['stock']);
        $this->db->bind('gender', $data['gender']);
        $this->db->bind('image', $data['image']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    // 2. SEARCH PRODUK (PERBAIKAN: JOIN KATEGORI)
    public function searchProducts($keyword) {
        // Tambahkan JOIN agar nama kategori tetap muncul di hasil pencarian
        $query = "SELECT products.*, categories.name as category_name 
                  FROM " . $this->table . " 
                  JOIN categories ON products.category_id = categories.id 
                  WHERE products.name LIKE :keyword 
                  OR categories.name LIKE :keyword";
                  
        $this->db->query($query);
        $this->db->bind('keyword', "%$keyword%");
        return $this->db->resultSet();
    }

    // 3. FILTER BY KATEGORI (PERBAIKAN: JOIN KATEGORI)
    public function getProductsByCategory($categoryId, $start, $limit) {
        $query = "SELECT products.*, categories.name as category_name 
                  FROM " . $this->table . " 
                  JOIN categories ON products.category_id = categories.id 
                  WHERE products.category_id = :cat_id 
                  ORDER BY products.id DESC LIMIT :start, :limit";
                  
        $this->db->query($query);
        $this->db->bind('cat_id', $categoryId);
        $this->db->bind('start', $start);
        $this->db->bind('limit', $limit);
        return $this->db->resultSet();
    }

    // --- FUNGSI LAINNYA (SUDAH AMAN) ---
    
    public function getAllProducts() {
        $this->db->query("SELECT products.*, categories.name as category_name 
                          FROM products 
                          JOIN categories ON products.category_id = categories.id 
                          ORDER BY products.id DESC");
        return $this->db->resultSet();
    }

    public function getProductById($id) {
        $query = "SELECT products.*, categories.name as category_name 
                  FROM " . $this->table . " 
                  JOIN categories ON products.category_id = categories.id 
                  WHERE products.id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        return $this->db->single();
    }

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

    public function countProducts() {
        $this->db->query("SELECT COUNT(*) as total FROM products");
        $result = $this->db->single();
        return $result['total'];
    }

    public function updateProduct($data, $file) {
        $id = $data['id'];
        $oldImage = $data['oldImage'];

        if($file['image']['error'] === 4) {
            $image = $oldImage;
        } else {
            $image = $this->uploadImage($file);
            if(!$image) return 0;
            // Hapus gambar lama jika ada
            if(file_exists('../public/assets/img/products/' . $oldImage) && $oldImage != 'default.jpg') {
                unlink('../public/assets/img/products/' . $oldImage);
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

    public function uploadImage($file) {
        $namaFile = $file['image']['name'];
        $tmpName = $file['image']['tmp_name'];
        $error = $file['image']['error'];

        if($error === 4) return false;

        $ekstensiValid = ['jpg', 'jpeg', 'png', 'webp'];
        $pecahNama = explode('.', $namaFile);
        $ekstensi = strtolower(end($pecahNama));

        if(!in_array($ekstensi, $ekstensiValid)) return false;

        $namaBaru = uniqid() . '.' . $ekstensi;
        
        // Simpan ke folder public/assets
        move_uploaded_file($tmpName, '../public/assets/img/products/' . $namaBaru);

        return $namaBaru;
    }

    public function addStock($id, $quantity) {
        $query = "UPDATE products SET stock = stock + :qty WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('qty', $quantity);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
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

    public function getLatestProducts($limit = 8) {
        $query = "SELECT products.*, categories.name as category_name 
                  FROM products 
                  JOIN categories ON products.category_id = categories.id 
                  ORDER BY products.id DESC LIMIT :limit";
        $this->db->query($query);
        $this->db->bind('limit', $limit);
        return $this->db->resultSet();
    }
}