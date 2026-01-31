<?php

class Product_model {
    private $table = 'products';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // --- FUNGSI KHUSUS HOMEPAGE ---
    public function getLatestProducts($limit = 8) {
        $query = "SELECT products.*, categories.name as category_name 
                  FROM " . $this->table . " 
                  LEFT JOIN categories ON products.category_id = categories.id 
                  ORDER BY products.created_at DESC 
                  LIMIT :limit";
        
        $this->db->query($query);
        $this->db->bind('limit', $limit);
        return $this->db->resultSet();
    }

    // --- FUNGSI KATALOG & USER ---

    public function getProductsByPage($start, $limit) {
        $query = "SELECT products.*, categories.name as category_name 
                  FROM " . $this->table . " 
                  LEFT JOIN categories ON products.category_id = categories.id 
                  ORDER BY products.created_at DESC LIMIT :start, :limit";
        
        $this->db->query($query);
        $this->db->bind('start', $start);
        $this->db->bind('limit', $limit);
        return $this->db->resultSet();
    }

    public function getProductsByCategory($categoryId, $start, $limit) {
        $query = "SELECT products.*, categories.name as category_name 
                  FROM " . $this->table . " 
                  LEFT JOIN categories ON products.category_id = categories.id 
                  WHERE products.category_id = :cid OR categories.parent_id = :cid
                  ORDER BY products.created_at DESC LIMIT :start, :limit";
        
        $this->db->query($query);
        $this->db->bind('cid', $categoryId);
        $this->db->bind('start', $start);
        $this->db->bind('limit', $limit);
        return $this->db->resultSet();
    }

    public function searchProducts($keyword) {
        $query = "SELECT products.*, categories.name as category_name 
                  FROM " . $this->table . " 
                  LEFT JOIN categories ON products.category_id = categories.id 
                  WHERE products.name LIKE :keyword OR products.description LIKE :keyword";
        
        $this->db->query($query);
        $this->db->bind('keyword', "%$keyword%");
        return $this->db->resultSet();
    }

    public function getProductById($id) {
        $query = "SELECT products.*, categories.name as category_name 
                  FROM " . $this->table . " 
                  LEFT JOIN categories ON products.category_id = categories.id 
                  WHERE products.id = :id";
        
        $this->db->query($query);
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    // --- FUNGSI HITUNG (PAGINATION) ---

    public function countProducts() {
        $this->db->query('SELECT COUNT(*) as total FROM ' . $this->table);
        $result = $this->db->single();
        return $result['total'];
    }

    public function countProductsByCategory($categoryId) {
        $query = "SELECT COUNT(products.id) as total FROM " . $this->table . " 
                  JOIN categories ON products.category_id = categories.id 
                  WHERE products.category_id = :cid OR categories.parent_id = :cid";
        $this->db->query($query);
        $this->db->bind('cid', $categoryId);
        $result = $this->db->single();
        return $result['total'];
    }

    // --- FUNGSI ADMIN (CRUD) ---

    public function getAllProducts() {
        $query = "SELECT products.*, categories.name as category_name 
                  FROM " . $this->table . " 
                  LEFT JOIN categories ON products.category_id = categories.id 
                  ORDER BY products.created_at DESC";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function addProduct($data, $files) {
        $image = $this->uploadImage($files);
        if(!$image) return 0;

        $query = "INSERT INTO products (name, description, price, stock, category_id, image, created_at)
                  VALUES (:name, :desc, :price, :stock, :cat_id, :img, NOW())";
        
        $this->db->query($query);
        $this->db->bind('name', $data['name']);
        $this->db->bind('desc', $data['description']);
        $this->db->bind('price', $data['price']);
        $this->db->bind('stock', $data['stock']);
        $this->db->bind('cat_id', $data['category_id']);
        $this->db->bind('img', $image);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function updateProduct($data, $files) {
        $image = $data['old_image'];
        if($files['image']['error'] !== 4) {
            $image = $this->uploadImage($files);
        }

        $query = "UPDATE products SET 
                    name = :name, 
                    description = :desc, 
                    price = :price, 
                    stock = :stock, 
                    category_id = :cat_id, 
                    image = :img 
                  WHERE id = :id";
        
        $this->db->query($query);
        $this->db->bind('name', $data['name']);
        $this->db->bind('desc', $data['description']);
        $this->db->bind('price', $data['price']);
        $this->db->bind('stock', $data['stock']);
        $this->db->bind('cat_id', $data['category_id']);
        $this->db->bind('img', $image);
        $this->db->bind('id', $data['id']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function deleteProduct($id) {
        $this->db->query('DELETE FROM ' . $this->table . ' WHERE id=:id');
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function addStock($id, $qty) {
        $this->db->query("UPDATE products SET stock = stock + :qty WHERE id = :id");
        $this->db->bind('qty', $qty);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    // --- HELPER UPLOAD ---
    private function uploadImage($files) {
        $namaFile = $files['image']['name'];
        $tmpName = $files['image']['tmp_name'];
        $ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
        
        if(!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) return false;

        $namaBaru = uniqid() . '.' . $ext;
        
        // Simpan ke folder products biar rapi
        move_uploaded_file($tmpName, '../public/assets/img/products/' . $namaBaru);
        return $namaBaru;
    }

} // <--- INI DIA KURUNG TUTUP YANG TADI HILANG!