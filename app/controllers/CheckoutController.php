<?php

class CheckoutController extends Controller {
    
    public function index() {
        // 1. Cek Login Dulu (Wajib!)
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/login');
            exit;
        }

        $userId = $_SESSION['user_id'];

        // 2. Panggil Model
        $userModel = $this->model('User_model');
        $cartModel = $this->model('Cart_model');

        // 3. Ambil Data User (Solusi Error Null)
        $user = $userModel->getUserById($userId);

        // 4. Ambil Data Keranjang (Solusi Error Undefined Key)
        // Pastikan nama fungsinya di Cart_model adalah 'getCartByUser'
        $cartItems = $cartModel->getCartByUser($userId);

        // Cek kalau keranjang kosong, jangan kasih masuk checkout
        if (empty($cartItems)) {
            Flasher::setFlash('Keranjang kosong', 'Silakan belanja dulu.', 'warning');
            header('Location: ' . BASEURL . '/product');
            exit;
        }

        // 5. Bungkus Data buat Dikirim ke View
        $data = [
            'title' => 'Checkout Pengiriman',
            'user' => $user,           // <--- INI PENTING! (Data User)
            'cart_items' => $cartItems // <--- INI PENTING! (Data Keranjang)
        ];

        // 6. Tampilkan Halaman
        $this->view('layouts/header', $data);
        $this->view('user/checkout/index', $data);
        $this->view('layouts/footer');
    }

    public function process() {
        // Cek Login lagi biar aman
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userId = $_SESSION['user_id'];
            
            // Gabungin Alamat jadi satu string panjang
            $fullAddress = $_POST['address'] . ', ' . 
                          $_POST['district'] . ', ' . 
                          $_POST['city'] . ', ' . 
                          $_POST['province'] . ' ' . 
                          $_POST['postal_code'];

            // Siapkan Data Order
            $orderData = [
                'user_id' => $userId,
                // Bikin Nomor Invoice Unik (Contoh: INV/20260131/ABCD)
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

            // 1. Simpan Data Order Utama
            $orderId = $orderModel->createOrder($orderData);

            if ($orderId) {
                // 2. Pindahin Item Keranjang ke Detail Order
                $cartItems = $cartModel->getCartByUser($userId);
                
                foreach ($cartItems as $item) {
                    // Panggil fungsi tambah detail order
                    $orderModel->addOrderDetail($orderId, $item['product_id'], $item['price'], $item['quantity']);
                }

                // 3. Hapus Isi Keranjang (Karena sudah dibeli)
                $cartModel->clearCart($userId);

                // 4. Lempar ke Halaman Pembayaran
                header('Location: ' . BASEURL . '/order/payment/' . $orderId);
                exit;
            } else {
                // Kalau Gagal
                Flasher::setFlash('Gagal', 'Terjadi kesalahan sistem.', 'danger');
                header('Location: ' . BASEURL . '/checkout');
                exit;
            }
        }
    }
}