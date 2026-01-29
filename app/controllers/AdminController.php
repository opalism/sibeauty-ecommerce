<?php
class AdminController extends Controller {

    public function __construct() {
        // Proteksi Halaman Admin
        if(!isset($_SESSION['user_session']) || $_SESSION['user_session']['role'] != 'admin') {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function index() {
        $data['title'] = 'Dashboard Admin';
        
        // Ambil data statistik untuk dashboard
        $data['total_products'] = $this->model('Product_model')->countProducts();
        $data['total_orders']   = $this->model('Order_model')->countOrders();
        $data['total_income']   = $this->model('Order_model')->calculateIncome();
        
        // Ambil 5 order terbaru
        $data['recent_orders']  = $this->model('Order_model')->getAllOrders(); 

        $this->view('layouts/admin_header', $data);
        $this->view('admin/index', $data);
        $this->view('layouts/admin_footer');
    }

    // 1. Halaman Daftar Produk
    public function products() {
        $data['title'] = 'Kelola Produk';
        $data['products'] = $this->model('Product_model')->getAllProducts();
        
        $this->view('layouts/admin_header', $data);
        $this->view('admin/products/index', $data);
        $this->view('layouts/admin_footer');
    }

    // 2. Halaman Form Tambah Produk
    public function productCreate() {
        $data['title'] = 'Tambah Produk';
        // GANTI INI: Ambil kategori dari model yang benar
        $data['categories'] = $this->model('Category_model')->getAllCategories();
        
        $this->view('layouts/admin_header', $data);
        $this->view('admin/products/create', $data);
        $this->view('layouts/admin_footer');
    }

    // 3. Proses Simpan Produk
    public function productStore() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            // A. Handle Upload Gambar
            $imageName = $this->uploadImage();
            if( !$imageName ) {
                return false; // Error handled inside uploadImage
            }

            // B. Siapkan Data
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

            // C. Kirim ke Model
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

    // 4. Proses Hapus
    public function productDelete($id) {
        try {
            // Coba hapus produk
            if($this->model('Product_model')->deleteProduct($id) > 0) {
                Flasher::setFlash('berhasil', 'dihapus', 'success');
            } else {
                Flasher::setFlash('gagal', 'dihapus', 'danger');
            }
        } catch (PDOException $e) {
            // Jika error karena Foreign Key (Integrity Constraint)
            if($e->getCode() == '23000') {
                Flasher::setFlash('gagal', 'Produk ini tidak bisa dihapus karena sudah memiliki riwayat pesanan (Order). Silakan ubah stok menjadi 0 saja jika produk sudah tidak dijual.', 'danger');
            } else {
                Flasher::setFlash('gagal', 'Terjadi kesalahan sistem.', 'danger');
            }
        }
        
        header('Location: ' . BASEURL . '/admin/products');
        exit;
    }

    // --- HELPER UPLOAD GAMBAR ---
    private function uploadImage() {
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $error    = $_FILES['image']['error'];
        $tmpName  = $_FILES['image']['tmp_name'];

        // Cek apakah ada gambar yang diupload
        if( $error === 4 ) {
            Flasher::setFlash('gagal', 'pilih gambar terlebih dahulu', 'danger');
            header('Location: ' . BASEURL . '/admin/productCreate');
            exit;
        }

        // Cek ekstensi valid
        $validExtension = ['jpg', 'jpeg', 'png'];
        $extension = explode('.', $fileName);
        $extension = strtolower(end($extension));

        if( !in_array($extension, $validExtension) ) {
            Flasher::setFlash('gagal', 'yang anda upload bukan gambar', 'danger');
            header('Location: ' . BASEURL . '/admin/productCreate');
            exit;
        }

        // Cek ukuran (max 2MB)
        if( $fileSize > 2000000 ) {
            Flasher::setFlash('gagal', 'ukuran gambar terlalu besar (max 2MB)', 'danger');
            header('Location: ' . BASEURL . '/admin/productCreate');
            exit;
        }

        // Generate nama file baru
        $newFileName = uniqid();
        $newFileName .= '.';
        $newFileName .= $extension;

        // Pindahkan file
        move_uploaded_file($tmpName, '../public/assets/img/products/' . $newFileName);

        return $newFileName;
    }

    // --- MANAJEMEN ORDER ---

    // 1. Daftar Semua Pesanan
    public function orders() {
        $data['title'] = 'Kelola Pesanan';
        $data['orders'] = $this->model('Order_model')->getAllOrders();
        
        $this->view('layouts/admin_header', $data);
        $this->view('admin/orders/index', $data);
        $this->view('layouts/admin_footer');
    }

    // 2. Detail Pesanan (Invoice View)
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

    // 3. Proses Update Status
    public function orderUpdateStatus() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['order_id'];
            $status = $_POST['status'];

            if($this->model('Order_model')->updateStatus($id, $status) > 0) {
                Flasher::setFlash('berhasil', 'status pesanan diperbarui', 'success');
            } else {
                Flasher::setFlash('gagal', 'memperbarui status (tidak ada perubahan)', 'warning');
            }
            header('Location: ' . BASEURL . '/admin/orderDetail/' . $id);
            exit;
        }
    }

    // --- MANAJEMEN KATEGORI ---

    // 1. Halaman Kategori
    public function categories() {
        $data['title'] = 'Kelola Kategori';
        // GANTI INI: Pakai Category_model
        $data['categories'] = $this->model('Category_model')->getAllCategories();
        
        $this->view('layouts/admin_header', $data);
        $this->view('admin/categories/index', $data);
        $this->view('layouts/admin_footer');
    }

    // 2. Proses Tambah Kategori
    public function categoryStore() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            if(!empty($name)) {
                // GANTI INI: Pakai Category_model
                if($this->model('Category_model')->addCategory($name) > 0) {
                    Flasher::setFlash('berhasil', 'ditambahkan', 'success');
                } else {
                    Flasher::setFlash('gagal', 'menambahkan kategori', 'danger');
                }
            }
            header('Location: ' . BASEURL . '/admin/categories');
            exit;
        }
    }

    // 3. Proses Hapus Kategori
    public function categoryDelete($id) {
        // GANTI INI: Pakai Category_model
        if($this->model('Category_model')->deleteCategory($id) > 0) {
            Flasher::setFlash('berhasil', 'dihapus', 'success');
        } else {
            Flasher::setFlash('gagal', 'dihapus', 'danger');
        }
        header('Location: ' . BASEURL . '/admin/categories');
        exit;
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

    // Proses Restock Cepat
    public function productRestock() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['product_id'];
            $qty = $_POST['quantity'];

            // Validasi: Angka harus positif
            if($qty > 0) {
                if($this->model('Product_model')->addStock($id, $qty) > 0) {
                    Flasher::setFlash('berhasil', 'stok ditambahkan', 'success');
                } else {
                    Flasher::setFlash('gagal', 'menambahkan stok', 'danger');
                }
            }
            
            header('Location: ' . BASEURL . '/admin/products');
            exit;
        }
    }

    // --- HALAMAN FORM EDIT ---
    public function productEdit($id) {
        $data['title'] = 'Edit Produk';
        
        // Ambil data produk & kategori
        $data['product'] = $this->model('Product_model')->getProductById($id);
        $data['categories'] = $this->model('Category_model')->getAllCategories();

        if(!$data['product']) {
            Flasher::setFlash('gagal', 'produk tidak ditemukan', 'danger');
            header('Location: ' . BASEURL . '/admin/products');
            exit;
        }

        $this->view('layouts/admin_header', $data);
        $this->view('admin/products/edit', $data); // <--- Memanggil file edit.php
        $this->view('layouts/admin_footer');
    }

    // --- PROSES UPDATE DATA ---
    public function productUpdate() {
        if($this->model('Product_model')->updateProduct($_POST, $_FILES) > 0) {
            Flasher::setFlash('berhasil', 'diubah', 'success');
        } else {
            Flasher::setFlash('info', 'tidak ada perubahan data', 'secondary');
        }
        header('Location: ' . BASEURL . '/admin/products');
        exit;
    }

    public function laporan() {
        // Cek login admin dulu (Copy dari method index)
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }

        $data['title'] = 'Laporan Penjualan';
        $data['orders'] = $this->model('Order_model')->getCompletedOrders();
        
        // Kita tidak pakai header/footer admin biasa, 
        // tapi buat view khusus biar hasil print-nya bersih.
        $this->view('admin/laporan', $data);
    }
}