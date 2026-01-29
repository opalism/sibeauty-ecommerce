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

    // PERBAIKAN 1: Ganti 'order_items' jadi 'order_details' sesuai data di SQL kamu
    public function getOrderItems($order_id) {
        // Kita JOIN ke products biar bisa ambil nama dan gambar produknya sekalian
        $query = "SELECT order_details.*, products.name, products.image 
                  FROM order_details 
                  JOIN products ON order_details.product_id = products.id 
                  WHERE order_details.order_id = :order_id";
                  
        $this->db->query($query);
        $this->db->bind('order_id', $order_id);
        return $this->db->resultSet();
    }

    public function createOrder($data) {
        // ... (Logika createOrder disesuaikan dengan controller Checkout kamu)
    }
    
    // --- UPDATE STATUS ---
    public function updateStatus($id, $status) {
        $this->db->query("UPDATE " . $this->table . " SET status = :status WHERE id = :id");
        $this->db->bind('status', $status);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    // --- HITUNG JUMLAH PESANAN (Untuk Dashboard) ---
    public function countOrders() {
        $this->db->query("SELECT COUNT(*) as total FROM " . $this->table);
        $result = $this->db->single();
        return $result['total'];
    }

    // --- HITUNG TOTAL PENDAPATAN (Untuk Dashboard) ---
    public function calculateIncome() {
        // PERBAIKAN 2: Ganti 'total_price' jadi 'total_amount'
        $this->db->query("SELECT SUM(total_amount) as total FROM " . $this->table . " WHERE status = 'completed'");
        $result = $this->db->single();
        return $result['total'] ?? 0;
    }

    // --- AMBIL DATA UNTUK LAPORAN ---
    public function getCompletedOrders() {
        $query = "SELECT orders.*, users.name as customer_name 
                  FROM " . $this->table . " 
                  JOIN users ON orders.user_id = users.id 
                  WHERE orders.status = 'completed' 
                  ORDER BY orders.created_at DESC";
        $this->db->query($query);
        return $this->db->resultSet();
    }
}