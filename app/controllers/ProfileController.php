<?php
class ProfileController extends Controller {
    
    public function __construct() {
        if(!isset($_SESSION['user_session'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function index() {
        $data['title'] = 'Akun Saya';
        $userId = $_SESSION['user_session']['id'];
        
        $data['user'] = $this->model('User_model')->getUserById($userId);
        
        $this->view('layouts/header', $data);
        $this->view('user/profile/index', $data);
        $this->view('layouts/footer');
    }

    public function update() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validasi sederhana
            if( $this->model('User_model')->updateProfile($_POST) >= 0 ) {
                // Update session name juga agar navbar berubah realtime
                $_SESSION['user_session']['name'] = $_POST['name'];
                
                Flasher::setFlash('berhasil', 'diperbarui', 'success');
            } else {
                Flasher::setFlash('gagal', 'memperbarui profil', 'danger');
            }
            header('Location: ' . BASEURL . '/profile');
            exit;
        }
    }
}