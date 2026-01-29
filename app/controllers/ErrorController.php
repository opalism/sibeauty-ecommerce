<?php
// app/controllers/ErrorController.php

class ErrorController extends Controller {
    public function index() {
        $data['title'] = '404 - Halaman Tidak Ditemukan';
        
        $this->view('layouts/header', $data);
        $this->view('error/404', $data); // Mengarah ke folder views/error
        $this->view('layouts/footer');
    }
}