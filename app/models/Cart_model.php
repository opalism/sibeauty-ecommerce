<?php
class Cart_model {
    private $table = 'carts';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // 1. Ambil semua isi keranjang user tertentu
    public function getCartByUser($userId) {
        // Kita JOIN dengan tabel products untuk ambil nama, harga, dan gambar
        $query = "SELECT c.id as cart_id, c.quantity, p.id as product_id, p.name, p.price, p.image, p.slug 
                  FROM carts c 
                  JOIN products p ON c.product_id = p.id 
                  WHERE c.user_id = :user_id";
        
        $this->db->query($query);
        $this->db->bind('user_id', $userId);
        return $this->db->resultSet();
    }

    // 2. Tambah barang ke keranjang
    public function addItem($data) {
        // Cek dulu apakah barang ini sudah ada di keranjang user?
        $this->db->query("SELECT * FROM carts WHERE user_id = :uid AND product_id = :pid");
        $this->db->bind('uid', $data['user_id']);
        $this->db->bind('pid', $data['product_id']);
        $existingItem = $this->db->single();

        if($existingItem) {
            // Jika sudah ada, update quantity-nya saja (+1)
            $query = "UPDATE carts SET quantity = quantity + :qty WHERE id = :id";
            $this->db->query($query);
            $this->db->bind('qty', $data['quantity']);
            $this->db->bind('id', $existingItem['id']);
        } else {
            // Jika belum ada, buat baris baru
            $query = "INSERT INTO carts (user_id, product_id, quantity) VALUES (:uid, :pid, :qty)";
            $this->db->query($query);
            $this->db->bind('uid', $data['user_id']);
            $this->db->bind('pid', $data['product_id']);
            $this->db->bind('qty', $data['quantity']);
        }

        $this->db->execute();
        return $this->db->rowCount();
    }

    // 3. Hapus item dari keranjang
    public function deleteItem($cartId) {
        $this->db->query("DELETE FROM carts WHERE id = :id");
        $this->db->bind('id', $cartId);
        $this->db->execute();
        return $this->db->rowCount();
    }
    
    // 4. Hitung jumlah barang (untuk badge di navbar)
    public function countCart($userId) {
        $this->db->query("SELECT SUM(quantity) as total FROM carts WHERE user_id = :uid");
        $this->db->bind('uid', $userId);
        $result = $this->db->single();
        return $result['total'] ?? 0;
    }
}