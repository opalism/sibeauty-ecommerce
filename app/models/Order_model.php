<?php

class Order_model {
    private $table = 'orders';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAllOrders() {
        $this->db->query("SELECT * FROM " . $this->table . " ORDER BY created_at DESC");
        return $this->db->resultSet();
    }

    public function getOrderById($id) {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE id=:id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function getOrderItems($order_id) {
        $this->db->query("SELECT * FROM order_items WHERE order_id=:order_id");
        $this->db->bind('order_id', $order_id);
        return $this->db->resultSet();
    }

    public function createOrder($data) {
        // ... (Logika createOrder biarkan seperti sebelumnya atau sesuaikan jika perlu)
        // Untuk mempersingkat, pastikan fungsi createOrder kamu yang lama tetap ada jika sudah jalan
        // Disini saya fokus menambahkan method baru di bawah ini:
    }
    
    // --- UPDATE STATUS ---
    public function updateStatus($id, $status) {
        $this->db->query("UPDATE " . $this->table . " SET status = :status WHERE id = :id");
        $this->db->bind('status', $status);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    // --- [BARU] HITUNG JUMLAH PESANAN (Untuk Dashboard) ---
    public function countOrders() {
        $this->db->query("SELECT COUNT(*) as total FROM " . $this->table);
        $result = $this->db->single();
        return $result['total'];
    }

    // --- [BARU] HITUNG TOTAL PENDAPATAN (Untuk Dashboard) ---
    public function calculateIncome() {
        $this->db->query("SELECT SUM(total_price) as total FROM " . $this->table . " WHERE status = 'completed'");
        $result = $this->db->single();
        return $result['total'] ?? 0; // Kembalikan 0 jika belum ada data
    }

    // --- [BARU] AMBIL DATA UNTUK LAPORAN ---
    public function getCompletedOrders() {
        // Join dengan tabel users untuk dapat nama pembeli
        $query = "SELECT orders.*, users.name as customer_name 
                  FROM " . $this->table . " 
                  JOIN users ON orders.user_id = users.id 
                  WHERE orders.status = 'completed' 
                  ORDER BY orders.created_at DESC";
        $this->db->query($query);
        return $this->db->resultSet();
    }
}