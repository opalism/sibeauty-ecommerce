<?php
class Order_model {
    private $table = 'orders';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function createOrder($data, $cartItems) {
        $this->db->beginTransaction();

        try {
            // PERHATIKAN KOLOM BARU: payment_method
            $queryOrder = "INSERT INTO orders (user_id, invoice_number, total_amount, payment_method, status, shipping_address) 
                           VALUES (:uid, :inv, :total, :pay, 'pending', :address)";
            
            $invoice = 'INV-' . time() . rand(100,999);
            
            $this->db->query($queryOrder);
            $this->db->bind('uid', $data['user_id']);
            $this->db->bind('inv', $invoice);
            $this->db->bind('total', $data['total_amount']);
            $this->db->bind('pay', $data['payment_method']); // <--- INI BINDING BARU
            $this->db->bind('address', $data['address']);
            $this->db->execute();
            
            $orderId = $this->db->lastInsertId();

            // 2. Insert ke Tabel Order Details & Kurangi Stok
            foreach($cartItems as $item) {
                // Insert Detail
                $this->db->query("INSERT INTO order_details (order_id, product_id, price, quantity) VALUES (:oid, :pid, :price, :qty)");
                $this->db->bind('oid', $orderId);
                $this->db->bind('pid', $item['product_id']); // Pastikan di cart model select product_id
                $this->db->bind('price', $item['price']);
                $this->db->bind('qty', $item['quantity']);
                $this->db->execute();

                // Kurangi Stok Produk
                $this->db->query("UPDATE products SET stock = stock - :qty WHERE id = :id");
                $this->db->bind('qty', $item['quantity']);
                $this->db->bind('id', $item['product_id']);
                $this->db->execute();
            }

            // 3. Kosongkan Keranjang User
            $this->db->query("DELETE FROM carts WHERE user_id = :uid");
            $this->db->bind('uid', $data['user_id']);
            $this->db->execute();

            // Jika semua lancar, simpan permanen
            $this->db->commit();
            return $orderId;

        } catch (Exception $e) {
            // Jika ada error, batalkan semua perubahan
            $this->db->rollBack();
            return false;
        }
    }
    
    // Untuk melihat riwayat pesanan (nanti)
    public function getOrdersByUser($userId) {
        // PERBAIKAN: Ganti 'created_at' menjadi 'order_date'
        $this->db->query("SELECT * FROM orders WHERE user_id = :uid ORDER BY order_date DESC");
        $this->db->bind('uid', $userId);
        return $this->db->resultSet();
    }

    public function countOrders() {
        $this->db->query("SELECT COUNT(*) as total FROM orders");
        $result = $this->db->single();
        return $result['total'];
    }

    public function calculateIncome() {
        $this->db->query("SELECT SUM(total_amount) as total FROM orders WHERE status != 'cancelled'");
        $result = $this->db->single();
        return $result['total'] ?? 0;
    }
    
    // Untuk mengambil semua order (fitur nanti)
    public function getAllOrders() {
        // PERBAIKAN: Ganti 'o.created_at' menjadi 'o.order_date'
        $this->db->query("SELECT o.*, u.name as user_name FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.order_date DESC");
        return $this->db->resultSet();
    }

    // Ambil Detail Order spesifik berdasarkan ID (Join dengan User)
    public function getOrderById($id) {
        // Update: Tambahkan 'users.email' di query SELECT
        $query = "SELECT orders.*, users.name as user_name, users.email, users.phone as user_phone, orders.created_at 
                  FROM orders 
                  JOIN users ON orders.user_id = users.id 
                  WHERE orders.id = :id";
        
        $this->db->query($query);
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    // Ambil Item/Barang dalam order tersebut
    public function getOrderItems($orderId) {
        // Update: JOIN ke products biar dapat 'product_name'
        $query = "SELECT order_items.*, products.name as product_name, products.image as product_image
                  FROM order_items 
                  JOIN products ON order_items.product_id = products.id 
                  WHERE order_items.order_id = :order_id";
        
        $this->db->query($query);
        $this->db->bind('order_id', $orderId);
        return $this->db->resultSet();
    }

    // Update Status Order
    public function updateStatus($id, $status) {
        $this->db->query("UPDATE orders SET status = :status WHERE id = :id");
        $this->db->bind('status', $status);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    // Tambahkan ini untuk fitur Laporan
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