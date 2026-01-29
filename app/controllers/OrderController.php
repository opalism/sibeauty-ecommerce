<?php
class OrderController extends Controller {
    
    public function __construct() {
        // Wajib Login
        if(!isset($_SESSION['user_session'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    // 1. Daftar Pesanan Saya
    public function index() {
        $data['title'] = 'Pesanan Saya';
        $userId = $_SESSION['user_session']['id'];
        
        // Ambil data dari model yang sudah kita buat sebelumnya
        $data['orders'] = $this->model('Order_model')->getOrdersByUser($userId);
        
        $this->view('layouts/header', $data);
        $this->view('user/orders/index', $data);
        $this->view('layouts/footer');
    }

    // 2. Detail Pesanan Spesifik
    public function detail($id) {
        $userId = $_SESSION['user_session']['id'];
        
        // Ambil data order
        $order = $this->model('Order_model')->getOrderById($id);

        // Security Check: Pastikan order ini milik user yang sedang login
        if(!$order || $order['user_id'] != $userId) {
            header('Location: ' . BASEURL . '/orders'); // Tendang jika coba-coba intip
            exit;
        }

        $data['title'] = 'Detail Pesanan #' . $order['invoice_number'];
        $data['order'] = $order;
        $data['items'] = $this->model('Order_model')->getOrderItems($id);

        $this->view('layouts/header', $data);
        $this->view('user/orders/detail', $data);
        $this->view('layouts/footer');
    }

    // 3. Form Konfirmasi Pembayaran
    public function payment($id) {
        $data['title'] = 'Konfirmasi Pembayaran';
        $data['order'] = $this->model('Order_model')->getOrderById($id);

        // Security: Cek punya user sendiri
        if(!$data['order'] || $data['order']['user_id'] != $_SESSION['user_session']['id']) {
            header('Location: ' . BASEURL . '/order');
            exit;
        }

        $this->view('layouts/header', $data);
        $this->view('user/orders/payment', $data);
        $this->view('layouts/footer');
    }

    // 4. Proses Upload Bukti
    public function submitPayment() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $orderId = $_POST['order_id'];
            
            // Upload Gambar
            $fileName = $_FILES['payment_proof']['name'];
            $tmpName  = $_FILES['payment_proof']['tmp_name'];
            
            // Generate nama baru biar unik
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $newFileName = 'PAY-' . time() . '.' . $ext;
            
            // Pindahkan
            move_uploaded_file($tmpName, '../public/assets/img/payments/' . $newFileName);

            // Update Database (Simpan nama file saja)
            // Kita pakai Query manual disini biar cepat, atau bisa buat fungsi di Model
            $db = new Database;
            $db->query("UPDATE orders SET payment_proof = :proof WHERE id = :id");
            $db->bind('proof', $newFileName);
            $db->bind('id', $orderId);
            $db->execute();

            Flasher::setFlash('berhasil', 'bukti pembayaran diupload, tunggu konfirmasi admin', 'success');
            header('Location: ' . BASEURL . '/order/detail/' . $orderId);
            exit;
        }
    }

    // Halaman Cetak Invoice (Struk)
    public function invoice($id) {
        // Ambil data order
        $data['order'] = $this->model('Order_model')->getOrderById($id);
        $data['items'] = $this->model('Order_model')->getOrderItems($id);

        // Security Check: Pastikan yang cetak adalah pemilik order (atau Admin)
        // Kita cek session user biasa saja dulu
        if($_SESSION['user_session']['role'] != 'admin') {
            if(!$data['order'] || $data['order']['user_id'] != $_SESSION['user_session']['id']) {
                header('Location: ' . BASEURL . '/order');
                exit;
            }
        }

        $data['title'] = 'Invoice #' . $data['order']['invoice_number'];
        
        // Kita tidak pakai header/footer biasa, tapi view khusus invoice
        $this->view('user/orders/invoice', $data);
    }
}