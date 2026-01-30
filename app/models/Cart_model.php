<?php

class Cart_model {
    private $table = 'cart';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // 1. AMBIL ISI KERANJANG USER
    public function getCartByUser($userId) {
        // Kita JOIN ke tabel products biar dapet nama, harga, dan gambar
        $query = "SELECT cart.*, products.name, products.price, products.image, products.stock 
                  FROM " . $this->table . " 
                  JOIN products ON cart.product_id = products.id 
                  WHERE cart.user_id = :user_id";
        $this->db->query($query);
        $this->db->bind('user_id', $userId);
        return $this->db->resultSet();
    }

    // 2. TAMBAH KE KERANJANG (INI YANG HILANG TADI)
    public function addToCart($userId, $productId, $qty) {
        // Cek dulu: Barang ini udah ada di keranjang user belum?
        $this->db->query("SELECT * FROM " . $this->table . " WHERE user_id = :uid AND product_id = :pid");
        $this->db->bind('uid', $userId);
        $this->db->bind('pid', $productId);
        $item = $this->db->single();

        if($item) {
            // KASUS A: Barang sudah ada -> Tinggal tambah jumlahnya (Quantity)
            $newQty = $item['quantity'] + $qty;
            $query = "UPDATE " . $this->table . " SET quantity = :qty WHERE id = :id";
            $this->db->query($query);
            $this->db->bind('qty', $newQty);
            $this->db->bind('id', $item['id']);
        } else {
            // KASUS B: Barang belum ada -> Masukkan data baru
            $query = "INSERT INTO " . $this->table . " (user_id, product_id, quantity) VALUES (:uid, :pid, :qty)";
            $this->db->query($query);
            $this->db->bind('uid', $userId);
            $this->db->bind('pid', $productId);
            $this->db->bind('qty', $qty);
        }
        
        $this->db->execute();
        return $this->db->rowCount();
    }

    // 3. HAPUS BARANG DARI KERANJANG
    public function removeFromCart($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    // 4. UPDATE JUMLAH (Misal user ubah qty di halaman cart)
    public function updateQuantity($id, $qty) {
        $query = "UPDATE " . $this->table . " SET quantity = :qty WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('qty', $qty);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    // 5. HITUNG TOTAL ITEM (Buat notifikasi merah di navbar)
    public function countCart($userId) {
        $query = "SELECT SUM(quantity) as total FROM " . $this->table . " WHERE user_id = :uid";
        $this->db->query($query);
        $this->db->bind('uid', $userId);
        $result = $this->db->single();
        return $result['total'] ?? 0;
    }
}