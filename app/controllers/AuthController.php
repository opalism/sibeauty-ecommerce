<?php

class AuthController extends Controller {

    public function index() {
        // Jika sudah login, lempar ke home, bukan katalog
        if(isset($_SESSION['user_session'])) {
            header('Location: ' . BASEURL . '/home');
            exit;
        }
        $data['title'] = 'Login SIBEAUTY';
        $this->view('auth/login', $data);
    }

    public function register() {
        $data['title'] = 'Join SIBEAUTY';
        $this->view('auth/register', $data);
    }

    // --- 1. PROSES PENDAFTARAN (STORE) ---
    public function store() {
        if($this->model('User_model')->register($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'Pendaftaran sukses! Silakan login.', 'success');
            header('Location: ' . BASEURL . '/auth'); 
        } else {
            Flasher::setFlash('Gagal', 'Pendaftaran gagal, email mungkin sudah ada.', 'danger');
            header('Location: ' . BASEURL . '/auth/register');
        }
        exit;
    }

    // --- 2. PROSES LOGIN (LOGINPROCESS) ---
    public function loginProcess() {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->model('User_model')->getUserByEmail($email);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                
                $_SESSION['user_session'] = [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'role' => $user['role']
                ];

                // --- REDIRECT BERDASARKAN ROLE ---
                if ($user['role'] == 'admin') {
                    header('Location: ' . BASEURL . '/admin');
                } else {
                    // SEBELUMNYA: /product -> SEKARANG: /home
                    header('Location: ' . BASEURL . '/home');
                }
                exit;

            } else {
                Flasher::setFlash('Gagal', 'Password salah!', 'danger');
                header('Location: ' . BASEURL . '/auth');
            }
        } else {
            Flasher::setFlash('Gagal', 'Email tidak terdaftar!', 'danger');
            header('Location: ' . BASEURL . '/auth');
        }
        exit;
    }

    // --- COPY DARI SINI ---
    public function logout() {
        session_start();
        session_destroy();
        session_unset();
        
        session_start(); // Mulai sesi baru sebentar untuk kirim pesan sukses
        Flasher::setFlash('Berhasil', 'Anda telah logout dari sistem.', 'success');
        
        header('Location: ' . BASEURL . '/auth');
        exit;
    }
    // --- SAMPAI SINI ---
}