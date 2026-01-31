<?php

class User_model {
    private $table = 'users';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // 1. Proses Daftar (Register)
    public function register($data) {
        $query = "INSERT INTO " . $this->table . " (name, email, password, role) VALUES (:name, :email, :password, 'user')";
        
        $this->db->query($query);
        $this->db->bind('name', $data['name']);
        $this->db->bind('email', $data['email']);
        // Enkripsi password sebelum simpan ke database
        $this->db->bind('password', password_hash($data['password'], PASSWORD_DEFAULT));

        $this->db->execute();
        return $this->db->rowCount();
    }

    // 2. Cari User Berdasarkan Email (Untuk Login)
    public function getUserByEmail($email) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE email = :email');
        $this->db->bind('email', $email);
        return $this->db->single();
    }

    // 3. Ambil Data User Berdasarkan ID (Untuk Profil)
    public function getUserById($id) {
    $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id=:id');
    $this->db->bind('id', $id);
    return $this->db->single();
    }

    // 4. Update Profile User
    public function updateProfile($data) {
        // Cek apakah user juga ingin mengganti password
        if( !empty($data['password']) ) {
            $query = "UPDATE " . $this->table . " SET name = :name, phone = :phone, address = :address, password = :password WHERE id = :id";
        } else {
            $query = "UPDATE " . $this->table . " SET name = :name, phone = :phone, address = :address WHERE id = :id";
        }
        
        $this->db->query($query);
        $this->db->bind('name', $data['name']);
        $this->db->bind('phone', $data['phone'] ?? null); // Pakai null coalescing supaya tidak error jika kolom belum ada
        $this->db->bind('address', $data['address'] ?? null);
        $this->db->bind('id', $data['id']);
        
        if( !empty($data['password']) ) {
            $this->db->bind('password', password_hash($data['password'], PASSWORD_DEFAULT));
        }

        $this->db->execute();
        return $this->db->rowCount();
    }
}