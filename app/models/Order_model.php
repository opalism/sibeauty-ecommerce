<?php

class Order_model {
    private $table = 'orders';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // --- FUNGSI CREATE ORDER ---
    public function createOrder($data, $items) {
        // 1. Generate Invoice
        $invoice = 'INV/' . date('Ymd') . '/' . strtoupper(substr(uniqid(), -4));

        // 2. Insert ke Tabel Orders
        // Pastikan kolom 'shipping_address' (bukan address)
        $query = "INSERT INTO orders (user_id, invoice_number, total_amount, status, shipping_address, payment_method, created_at)
                  VALUES (:uid, :inv, :total, 'pending', :addr, :pm, NOW())";

        $this->db->query($query);
        $this->db->bind('uid', $data['user_id']);
        $this->db->bind('inv', $invoice);
        $this->db->bind('total', $data['total_amount']);
        $this->db->bind('addr', $data['address']);
        $this->db->bind('pm', $data['payment_method']);
        $this->db->execute();
        
        $orderId = $this->db->lastInsertId();

        // 3. Pindahkan Keranjang ke Order Details
        foreach($items as $item) {
            // Tanpa kolom 'subtotal' karena di database tidak ada
            $qDetail = "INSERT INTO order_details (order_id, product_id, quantity, price)
                        VALUES (:oid, :pid, :qty, :price)";
            
            $this->db->query($qDetail);
            $this->db->bind('oid', $orderId);
            $this->db->bind('pid', $item['product_id']);
            $this->db->bind('qty', $item['quantity']);
            $this->db->bind('price', $item['price']); 
            $this->db->execute();
        }

        // 4. Hapus Keranjang User
        // PERBAIKAN DI SINI: Gunakan 'cart' (tanpa s)
        $qCart = "DELETE FROM cart WHERE user_id = :uid";
        
        $this->db->query($qCart);
        $this->db->bind('uid', $data['user_id']);
        $this->db->execute();

        return $orderId;
    }

    // --- FUNGSI ADMIN & LAINNYA ---

    public function getAllOrders() {
        $query = "SELECT orders.*, users.name as user_name 
                  FROM " . $this->table . " 
                  JOIN users ON orders.user_id = users.id 
                  ORDER BY orders.created_at DESC";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function getOrderById($id) {
        $query = "SELECT orders.*, users.name as user_name, users.email 
                  FROM " . $this->table . " 
                  JOIN users ON orders.user_id = users.id 
                  WHERE orders.id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function getOrderItems($order_id) {
        // Hitung subtotal virtual
        $query = "SELECT order_details.*, 
                         (order_details.price * order_details.quantity) as subtotal,
                         products.name, products.image 
                  FROM order_details 
                  JOIN products ON order_details.product_id = products.id 
                  WHERE order_details.order_id = :order_id";
        
        $this->db->query($query);
        $this->db->bind('order_id', $order_id);
        return $this->db->resultSet();
    }
    
    public function updateStatus($id, $status) {
        $this->db->query("UPDATE " . $this->table . " SET status = :status WHERE id = :id");
        $this->db->bind('status', $status);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function countOrders() {
        $this->db->query("SELECT COUNT(*) as total FROM " . $this->table);
        $result = $this->db->single();
        return $result['total'];
    }

    public function calculateIncome() {
        $this->db->query("SELECT SUM(total_amount) as total FROM " . $this->table . " WHERE status = 'completed'");
        $result = $this->db->single();
        return $result['total'] ?? 0;
    }
    
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