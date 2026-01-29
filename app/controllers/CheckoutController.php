<?php
class CheckoutController extends Controller {
    
    public function index() {
        // Cek Login
        if(!isset($_SESSION['user_session'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }

        $userId = $_SESSION['user_session']['id'];
        
        // Ambil data keranjang untuk ditampilkan di ringkasan
        $data['cart'] = $this->model('Cart_model')->getCartByUser($userId);
        
        // Jika keranjang kosong, tendang balik
        if(empty($data['cart'])) {
            header('Location: ' . BASEURL . '/cart');
            exit;
        }

        $data['title'] = 'Checkout';
        $this->view('layouts/header', $data);
        $this->view('user/checkout/index', $data); // Kita buat view ini nanti
        $this->view('layouts/footer');
    }

    public function process() {
        if(!isset($_SESSION['user_session'])) { header('Location: ' . BASEURL); exit; }

        $userId = $_SESSION['user_session']['id'];
        $cartItems = $this->model('Cart_model')->getCartByUser($userId);
        
        $totalAmount = 0;
        foreach($cartItems as $item) {
            $totalAmount += ($item['price'] * $item['quantity']);
        }

        // TAMBAHKAN 'payment_method' DISINI
        $dataOrder = [
            'user_id' => $userId,
            'address' => $_POST['address'] . ', ' . $_POST['city'] . ', ' . $_POST['postal_code'],
            'total_amount' => $totalAmount,
            'payment_method' => $_POST['payment_method'] // <--- INI BARU
        ];

        $orderId = $this->model('Order_model')->createOrder($dataOrder, $cartItems);

        if($orderId) {
            header('Location: ' . BASEURL . '/checkout/success/' . $orderId);
            exit;
        } else {
            Flasher::setFlash('gagal', 'memproses pesanan', 'danger');
            header('Location: ' . BASEURL . '/checkout');
            exit;
        }
    }

    public function success($orderId) {
        $data['title'] = 'Order Berhasil';
        $data['order_id'] = $orderId;
        
        $this->view('layouts/header', $data);
        $this->view('user/checkout/success', $data);
        $this->view('layouts/footer');
    }
}