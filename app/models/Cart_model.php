<?php

class Cart_model {
    private $table = 'cart';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // 1. AMBIL ITEM KERANJANG BERDASARKAN USER
    public function getCartByUser($userId) {
        // Kita join dengan tabel products biar dapat nama & gambar barangnya
        $query = "SELECT cart.*, products.name, products.price, products.image, products.stock 
                  FROM " . $this->table . " 
                  JOIN products ON cart.product_id = products.id 
                  WHERE cart.user_id = :uid";
        
        $this->db->query($query);
        $this->db->bind('uid', $userId);
        return $this->db->resultSet();
    }

    // 2. TAMBAH BARANG KE KERANJANG
    public function addToCart($userId, $productId, $qty) {
        // Cek dulu, barang ini udah ada di keranjang belum?
        $this->db->query("SELECT * FROM " . $this->table . " WHERE user_id = :uid AND product_id = :pid");
        $this->db->bind('uid', $userId);
        $this->db->bind('pid', $productId);
        $item = $this->db->single();

        if ($item) {
            // Kalau udah ada, update quantity-nya aja (nambah)
            $newQty = $item['quantity'] + $qty;
            $query = "UPDATE " . $this->table . " SET quantity = :qty WHERE id = :id";
            $this->db->query($query);
            $this->db->bind('qty', $newQty);
            $this->db->bind('id', $item['id']);
        } else {
            // Kalau belum ada, bikin baris baru
            $query = "INSERT INTO " . $this->table . " (user_id, product_id, quantity) VALUES (:uid, :pid, :qty)";
            $this->db->query($query);
            $this->db->bind('uid', $userId);
            $this->db->bind('pid', $productId);
            $this->db->bind('qty', $qty);
        }

        $this->db->execute();
        return $this->db->rowCount();
    }

    // 3. UPDATE JUMLAH BARANG (Tombol Plus/Minus)
    public function updateQuantity($cartId, $qty) {
        $query = "UPDATE " . $this->table . " SET quantity = :qty WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('qty', $qty);
        $this->db->bind('id', $cartId);
        $this->db->execute();
        return $this->db->rowCount();
    }

    // 4. HAPUS SATU BARANG DARI KERANJANG
    public function removeFromCart($cartId) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $cartId);
        $this->db->execute();
        return $this->db->rowCount();
    }

    // 5. HITUNG TOTAL ITEM DI KERANJANG (Buat Notif di Navbar)
    public function countCart($userId) {
        $this->db->query("SELECT SUM(quantity) as total FROM " . $this->table . " WHERE user_id = :uid");
        $this->db->bind('uid', $userId);
        $result = $this->db->single();
        return $result['total'] ?? 0;
    }

    // 6. KOSONGKAN KERANJANG (Dipakai setelah Checkout sukses)
    public function clearCart($userId) {
        $query = "DELETE FROM " . $this->table . " WHERE user_id = :uid";
        $this->db->query($query);
        $this->db->bind('uid', $userId);
        $this->db->execute();
        return $this->db->rowCount();
    }
}