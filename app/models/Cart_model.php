<?php

class Cart_model {
    private $table = 'cart';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // 1. AMBIL ITEM KERANJANG (DIPERBAIKI: Tambah products.stock)
    public function getCartByUser($userId) {
        // Perhatikan bagian 'products.stock' di bawah ini
        $query = "SELECT cart.*, products.name, products.price, products.image, products.stock 
                  FROM " . $this->table . " 
                  JOIN products ON cart.product_id = products.id 
                  WHERE cart.user_id = :uid";
        
        $this->db->query($query);
        $this->db->bind('uid', $userId);
        return $this->db->resultSet();
    }

    // 2. TAMBAH BARANG
    public function addToCart($userId, $productId, $qty) {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE user_id = :uid AND product_id = :pid");
        $this->db->bind('uid', $userId);
        $this->db->bind('pid', $productId);
        $item = $this->db->single();

        if ($item) {
            $newQty = $item['quantity'] + $qty;
            $query = "UPDATE " . $this->table . " SET quantity = :qty WHERE id = :id";
            $this->db->query($query);
            $this->db->bind('qty', $newQty);
            $this->db->bind('id', $item['id']);
        } else {
            $query = "INSERT INTO " . $this->table . " (user_id, product_id, quantity) VALUES (:uid, :pid, :qty)";
            $this->db->query($query);
            $this->db->bind('uid', $userId);
            $this->db->bind('pid', $productId);
            $this->db->bind('qty', $qty);
        }
        $this->db->execute();
        return $this->db->rowCount();
    }

    // 3. UPDATE QUANTITY
    public function updateQuantity($cartId, $qty) {
        $query = "UPDATE " . $this->table . " SET quantity = :qty WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('qty', $qty);
        $this->db->bind('id', $cartId);
        $this->db->execute();
        return $this->db->rowCount();
    }

    // 4. HAPUS ITEM
    public function removeFromCart($cartId) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $cartId);
        $this->db->execute();
        return $this->db->rowCount();
    }

    // 5. HITUNG TOTAL ITEM (BADGE NAVBAR)
    public function countCart($userId) {
        $this->db->query("SELECT SUM(quantity) as total FROM " . $this->table . " WHERE user_id = :uid");
        $this->db->bind('uid', $userId);
        $result = $this->db->single();
        return $result['total'] ?? 0;
    }

    // 6. KOSONGKAN KERANJANG (SETELAH CHECKOUT)
    public function clearCart($userId) {
        $query = "DELETE FROM " . $this->table . " WHERE user_id = :uid";
        $this->db->query($query);
        $this->db->bind('uid', $userId);
        $this->db->execute();
        return $this->db->rowCount();
    }
}