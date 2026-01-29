<?php
class AdminController extends Controller {

    public function __construct() {
        // Proteksi Halaman Admin (Cukup satu penjaga gerbang di sini)
        if(!isset($_SESSION['user_session']) || $_SESSION['user_session']['role'] != 'admin') {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function index() {
        $data['title'] = 'Dashboard Admin';
        $data['total_products'] = $this->model('Product_model')->countProducts();
        $data['total_orders']   = $this->model('Order_model')->countOrders();
        $data['total_income']   = $this->model('Order_model')->calculateIncome();
        $data['recent_orders']  = $this->model('Order_model')->getAllOrders(); 

        $this->view('layouts/admin_header', $data);
        $this->view('admin/index', $data);
        $this->view('layouts/admin_footer');
    }

    public function products() {
        $data['title'] = 'Kelola Produk';
        $data['products'] = $this->model('Product_model')->getAllProducts();
        $this->view('layouts/admin_header', $data);
        $this->view('admin/products/index', $data);
        $this->view('layouts/admin_footer');
    }

    public function productCreate() {
        $data['title'] = 'Tambah Produk';
        $data['categories'] = $this->model('Category_model')->getAllCategories();
        $this->view('layouts/admin_header', $data);
        $this->view('admin/products/create', $data);
        $this->view('layouts/admin_footer');
    }

    public function productStore() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $imageName = $this->uploadImage();
            if( !$imageName ) return false;

            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_POST['name'])));
            $data = [
                'name' => $_POST['name'],
                'slug' => $slug,
                'category_id' => $_POST['category_id'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'stock' => $_POST['stock'],
                'gender' => $_POST['gender'],
                'image' => $imageName
            ];

            if( $this->model('Product_model')->addProduct($data) > 0 ) {
                Flasher::setFlash('berhasil', 'ditambahkan', 'success');
                header('Location: ' . BASEURL . '/admin/products');
                exit;
            } else {
                Flasher::setFlash('gagal', 'menambahkan produk', 'danger');
                header('Location: ' . BASEURL . '/admin/products');
                exit;
            }
        }
    }

    public function productEdit($id) {
        $data['title'] = 'Edit Produk';
        $data['product'] = $this->model('Product_model')->getProductById($id);
        $data['categories'] = $this->model('Category_model')->getAllCategories();

        if(!$data['product']) {
            Flasher::setFlash('gagal', 'produk tidak ditemukan', 'danger');
            header('Location: ' . BASEURL . '/admin/products');
            exit;
        }

        $this->view('layouts/admin_header', $data);
        $this->view('admin/products/edit', $data);
        $this->view('layouts/admin_footer');
    }

    public function productUpdate() {
        // Logika update (pastikan method updateProduct handle $_FILES untuk ganti gambar jika ada)
        if($this->model('Product_model')->updateProduct($_POST, $_FILES) > 0) {
            Flasher::setFlash('berhasil', 'diubah', 'success');
        } else {
            Flasher::setFlash('info', 'tidak ada perubahan data', 'secondary');
        }
        header('Location: ' . BASEURL . '/admin/products');
        exit;
    }

    public function productDelete($id) {
        try {
            if($this->model('Product_model')->deleteProduct($id) > 0) {
                Flasher::setFlash('berhasil', 'dihapus', 'success');
            } else {
                Flasher::setFlash('gagal', 'dihapus', 'danger');
            }
        } catch (PDOException $e) {
            if($e->getCode() == '23000') {
                Flasher::setFlash('gagal', 'Produk tidak bisa dihapus karena ada di riwayat pesanan.', 'danger');
            } else {
                Flasher::setFlash('gagal', 'Terjadi kesalahan sistem.', 'danger');
            }
        }
        header('Location: ' . BASEURL . '/admin/products');
        exit;
    }

    private function uploadImage() {
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $error    = $_FILES['image']['error'];
        $tmpName  = $_FILES['image']['tmp_name'];

        if( $error === 4 ) {
            Flasher::setFlash('gagal', 'pilih gambar terlebih dahulu', 'danger');
            header('Location: ' . BASEURL . '/admin/productCreate');
            exit;
        }

        $validExtension = ['jpg', 'jpeg', 'png'];
        $extension = explode('.', $fileName);
        $extension = strtolower(end($extension));

        if( !in_array($extension, $validExtension) ) {
            Flasher::setFlash('gagal', 'bukan file gambar', 'danger');
            header('Location: ' . BASEURL . '/admin/productCreate');
            exit;
        }

        if( $fileSize > 2000000 ) {
            Flasher::setFlash('gagal', 'ukuran gambar terlalu besar (max 2MB)', 'danger');
            header('Location: ' . BASEURL . '/admin/productCreate');
            exit;
        }

        $newFileName = uniqid() . '.' . $extension;
        move_uploaded_file($tmpName, '../public/assets/img/products/' . $newFileName);
        return $newFileName;
    }

    public function orders() {
        $data['title'] = 'Kelola Pesanan';
        $data['orders'] = $this->model('Order_model')->getAllOrders();
        $this->view('layouts/admin_header', $data);
        $this->view('admin/orders/index', $data);
        $this->view('layouts/admin_footer');
    }

    public function orderDetail($id) {
        $data['title'] = 'Detail Pesanan #' . $id;
        $data['order'] = $this->model('Order_model')->getOrderById($id);
        $data['items'] = $this->model('Order_model')->getOrderItems($id);

        if(!$data['order']) {
            header('Location: ' . BASEURL . '/admin/orders');
            exit;
        }

        $this->view('layouts/admin_header', $data);
        $this->view('admin/orders/detail', $data);
        $this->view('layouts/admin_footer');
    }

    public function orderUpdateStatus() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['order_id'];
            $status = $_POST['status'];
            if($this->model('Order_model')->updateStatus($id, $status) > 0) {
                Flasher::setFlash('berhasil', 'status diperbarui', 'success');
            }
            header('Location: ' . BASEURL . '/admin/orderDetail/' . $id);
            exit;
        }
    }

    public function categories() {
        $data['title'] = 'Kelola Kategori';
        $data['categories'] = $this->model('Category_model')->getAllCategories();
        $this->view('layouts/admin_header', $data);
        $this->view('admin/categories/index', $data);
        $this->view('layouts/admin_footer');
    }

    public function categoryStore() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($this->model('Category_model')->addCategory($_POST['name']) > 0) {
                Flasher::setFlash('berhasil', 'ditambahkan', 'success');
            }
            header('Location: ' . BASEURL . '/admin/categories');
            exit;
        }
    }

    public function categoryDelete($id) {
        if($this->model('Category_model')->deleteCategory($id) > 0) {
            Flasher::setFlash('berhasil', 'dihapus', 'success');
        }
        header('Location: ' . BASEURL . '/admin/categories');
        exit;
    }

    public function productRestock() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($_POST['quantity'] > 0) {
                $this->model('Product_model')->addStock($_POST['product_id'], $_POST['quantity']);
                Flasher::setFlash('berhasil', 'stok ditambahkan', 'success');
            }
            header('Location: ' . BASEURL . '/admin/products');
            exit;
        }
    }
    
    // --- FITUR LAPORAN (SUDAH DIPERBAIKI) ---
    public function laporan() {
        // Tidak perlu cek session lagi karena sudah ada di __construct
        
        $data['title'] = 'Laporan Penjualan';
        
        // Ambil data pesanan 'completed'
        $data['orders'] = $this->model('Order_model')->getCompletedOrders();
        
        // Load view khusus (tanpa header admin biasa)
        $this->view('admin/laporan', $data);
    }
}