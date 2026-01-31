<?php

class Order_model {
    private $table = 'orders';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // ==================================================
    // BAGIAN 1: FITUR USER (BELANJA)
    // ==================================================

    public function createOrder($data) {
        $query = "INSERT INTO orders 
                  (user_id, invoice_number, total_amount, payment_method, status, shipping_address, created_at) 
                  VALUES 
                  (:user_id, :invoice, :total, :payment, 'pending', :address, NOW())";
        
        $this->db->query($query);
        $this->db->bind('user_id', $data['user_id']);
        $this->db->bind('invoice', $data['invoice_number']);
        $this->db->bind('total', $data['total_amount']);
        $this->db->bind('payment', $data['payment_method']);
        $this->db->bind('address', $data['shipping_address']);
        $this->db->execute();
        return $this->db->lastInsertId();
    }

    public function addOrderDetail($orderId, $productId, $price, $qty) {
        $query = "INSERT INTO order_details (order_id, product_id, price, quantity) VALUES (:oid, :pid, :price, :qty)";
        $this->db->query($query);
        $this->db->bind('oid', $orderId);
        $this->db->bind('pid', $productId);
        $this->db->bind('price', $price);
        $this->db->bind('qty', $qty);
        $this->db->execute();
    }

    // Dipakai user untuk lihat invoice
    public function getOrderById($id) {
    // Pastikan ada orders.* agar kolom payment_proof ikut terbawa
    $query = "SELECT orders.*, users.name as user_name, users.email 
              FROM orders 
              JOIN users ON orders.user_id = users.id 
              WHERE orders.id = :id";
    
    $this->db->query($query);
    $this->db->bind('id', $id);
    return $this->db->single();
}

    public function updatePaymentProof($id, $fileName) {
    // Pastikan kolom di database namanya 'payment_proof'
    $query = "UPDATE " . $this->table . " SET payment_proof = :proof, status = 'paid' WHERE id = :id";
    $this->db->query($query);
    $this->db->bind('proof', $fileName);
    $this->db->bind('id', $id);
    $this->db->execute();
    return $this->db->rowCount(); // Mengembalikan jumlah baris yang berubah
}

    public function getOrdersByUser($userId) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE user_id=:uid ORDER BY created_at DESC');
        $this->db->bind('uid', $userId);
        return $this->db->resultSet();
    }

    // ==================================================
    // BAGIAN 2: FITUR ADMIN (Sesuai AdminController)
    // ==================================================

    // 1. Dipanggil di AdminController -> index()
    public function countOrders() {
        $this->db->query("SELECT COUNT(*) as total FROM " . $this->table);
        $result = $this->db->single();
        return $result['total'];
    }

    // 2. Dipanggil di AdminController -> index()
    public function calculateIncome() {
        $this->db->query("SELECT SUM(total_amount) as total FROM " . $this->table . " WHERE status = 'completed'");
        $result = $this->db->single();
        return $result['total'] ?? 0;
    }

    // 3. Dipanggil di AdminController -> orders() & index()
    public function getAllOrders() {
        $query = "SELECT orders.*, users.name as user_name 
                  FROM " . $this->table . " 
                  JOIN users ON orders.user_id = users.id 
                  ORDER BY orders.created_at DESC";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    // 4. Dipanggil di AdminController -> updateOrder()
    public function updateStatus($id, $status) {
        $query = "UPDATE " . $this->table . " SET status = :status WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('status', $status);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    // 5. Dipanggil di AdminController -> orderDetail()
    public function getOrderItems($orderId) {
        $query = "SELECT order_details.*, products.name, products.image 
                  FROM order_details 
                  JOIN products ON order_details.product_id = products.id 
                  WHERE order_details.order_id = :oid";
        $this->db->query($query);
        $this->db->bind('oid', $orderId);
        return $this->db->resultSet();
    }

    // 6. Dipanggil di AdminController -> laporan()
    public function getCompletedOrders() {
        $query = "SELECT orders.*, users.name as user_name 
                  FROM " . $this->table . " 
                  JOIN users ON orders.user_id = users.id 
                  WHERE orders.status = 'completed'
                  ORDER BY orders.created_at DESC";
        $this->db->query($query);
        return $this->db->resultSet();
    }
}