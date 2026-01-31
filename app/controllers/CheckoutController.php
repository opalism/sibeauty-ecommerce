<?php

class CheckoutController extends Controller {
    
    public function index() {
        // 1. Cek Login (Pastikan user_id ada)
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/login');
            exit;
        }

        $userId = $_SESSION['user_id'];

        // 2. Ambil Data User (Solusi Error Line 13)
        $userModel = $this->model('User_model');
        $user = $userModel->getUserById($userId);

        // 3. Ambil Data Keranjang (Solusi Error Line 83)
        $cartModel = $this->model('Cart_model');
        // Perhatikan: Nama fungsi di Cart_model kamu adalah 'getCartByUser'
        $cartItems = $cartModel->getCartByUser($userId);

        // 4. Cek Keranjang Kosong
        if (empty($cartItems)) {
            Flasher::setFlash('Keranjang kosong', 'Silakan belanja dulu.', 'warning');
            header('Location: ' . BASEURL . '/product');
            exit;
        }

        // 5. BUNGKUS DATA UNTUK DIKIRIM KE VIEW
        $data = [
            'title' => 'Checkout Pengiriman',
            'user' => $user,           // <--- INI WAJIB ADA (Biar form nama terisi)
            'cart_items' => $cartItems // <--- INI WAJIB ADA (Biar ringkasan produk muncul)
        ];

        // 6. Tampilkan View
        $this->view('layouts/header', $data);
        $this->view('user/checkout/index', $data);
        $this->view('layouts/footer');
    }

    public function process() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userId = $_SESSION['user_id'];
            
            // Gabungkan data alamat dari Form yang banyak itu
            $fullAddress = $_POST['address'] . ', ' . 
                          $_POST['district'] . ', ' . 
                          $_POST['city'] . ', ' . 
                          $_POST['province'] . ' ' . 
                          $_POST['postal_code'];

            // Siapkan data order
            $orderData = [
                'user_id' => $userId,
                // Generate Invoice Unik (Contoh: INV/20240131/X7Z9)
                'invoice_number' => 'INV/' . date('Ymd') . '/' . strtoupper(substr(uniqid(), -4)),
                'receiver_name' => $_POST['receiver_name'],
                'receiver_phone' => $_POST['receiver_phone'],
                'shipping_address' => $fullAddress,
                'total_amount' => $_POST['total_amount'],
                'payment_method' => $_POST['payment_method'],
                'status' => 'pending'
            ];

            $orderModel = $this->model('Order_model');
            $cartModel = $this->model('Cart_model');

            // 1. Simpan ke Tabel Orders
            $orderId = $orderModel->createOrder($orderData);

            if ($orderId) {
                // 2. Pindahkan Item Keranjang ke Order Details
                $cartItems = $cartModel->getCartByUser($userId);
                
                foreach ($cartItems as $item) {
                    // Pastikan fungsi addOrderDetail ada di Order_model
                    $orderModel->addOrderDetail($orderId, $item['product_id'], $item['price'], $item['quantity']);
                }

                // 3. Hapus Isi Keranjang (Karena sudah dibeli)
                // Cek Cart_model kamu, dia butuh fungsi clearCart atau hapus manual
                // Kalau belum ada fungsi clearCart, kita pakai loop delete:
                foreach ($cartItems as $item) {
                    $cartModel->removeFromCart($item['id']);
                }

                // 4. Redirect ke Halaman Pembayaran
                header('Location: ' . BASEURL . '/order/payment/' . $orderId);
                exit;
            } else {
                Flasher::setFlash('Gagal', 'Terjadi kesalahan sistem.', 'danger');
                header('Location: ' . BASEURL . '/checkout');
                exit;
            }
        }
    }
}