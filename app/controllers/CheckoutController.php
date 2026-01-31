<?php

class CheckoutController extends Controller {
    
    public function index() {
        // 1. Cek Login (SESUAIKAN DENGAN OrderController)
        if (!isset($_SESSION['user_session'])) {
            header('Location: ' . BASEURL . '/login');
            exit;
        }

        // Ambil ID User dari 'user_session'
        $userId = $_SESSION['user_session']['id'];

        // 2. Panggil Model
        $userModel = $this->model('User_model');
        $cartModel = $this->model('Cart_model');

        // 3. Ambil Data User & Keranjang
        $user = $userModel->getUserById($userId);
        
        // Pastikan nama fungsi di Cart_model benar
        $cartItems = $cartModel->getCartByUser($userId);

        // Cek kalau keranjang kosong
        if (empty($cartItems)) {
            Flasher::setFlash('Keranjang kosong', 'Silakan belanja dulu.', 'warning');
            header('Location: ' . BASEURL . '/product');
            exit;
        }

        // 4. Kirim Data ke View
        $data = [
            'title' => 'Checkout Pengiriman',
            'user' => $user,
            'cart_items' => $cartItems
        ];

        // 5. Tampilkan View
        $this->view('layouts/header', $data);
        $this->view('user/checkout/index', $data);
        $this->view('layouts/footer');
    }

    public function process() {
        // Cek Login (Samakan juga disini)
        if (!isset($_SESSION['user_session'])) {
            header('Location: ' . BASEURL . '/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Ambil ID dari user_session
            $userId = $_SESSION['user_session']['id'];
            
            // Gabung Alamat
            $fullAddress = $_POST['address'] . ', ' . 
                          $_POST['district'] . ', ' . 
                          $_POST['city'] . ', ' . 
                          $_POST['province'] . ' ' . 
                          $_POST['postal_code'];

            // Data Order
            $orderData = [
                'user_id' => $userId,
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

            // Simpan Order
            $orderId = $orderModel->createOrder($orderData);

            if ($orderId) {
                // Pindahkan Keranjang -> Order Detail
                $cartItems = $cartModel->getCartByUser($userId);
                
                foreach ($cartItems as $item) {
                    $orderModel->addOrderDetail($orderId, $item['product_id'], $item['price'], $item['quantity']);
                }

                // Kosongkan Keranjang
                $cartModel->clearCart($userId);

                // Redirect ke Pembayaran
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