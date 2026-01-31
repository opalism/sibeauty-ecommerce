<?php

class Order_model {
    private $table = 'orders';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

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
        return $this->db->lastInsertId(); // Kembalikan ID Order yang baru dibuat
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
}