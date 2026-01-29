<?php

class App {
    // Default controller jika URL kosong
    protected $controller = 'AuthController'; 
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseURL();

        // 1. Setup Controller
        if (isset($url[0])) {
            $controllerName = ucfirst($url[0]) . 'Controller';
            
            if (file_exists('../app/controllers/' . $controllerName . '.php')) {
                $this->controller = $controllerName;
                unset($url[0]);
            } else {
                // Jika controller tidak ditemukan, arahkan ke ErrorController
                $this->controller = 'ErrorController';
                // Kita hapus url[0] agar tidak dianggap sebagai parameter nantinya
                unset($url[0]);
            }
        }

        // Load file controller yang terpilih
        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // 2. Setup Method
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // 3. Setup Params
        if (!empty($url)) {
            $this->params = array_values($url);
        }

        // Jalankan Controller & Method
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseURL() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
        return []; // Pastikan return array kosong jika URL tidak ada
    }
}