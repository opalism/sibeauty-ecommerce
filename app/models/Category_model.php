<?php
class Category_model {
    private $table = 'categories';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // Ambil Semua Kategori
    public function getAllCategories() {
        $this->db->query("SELECT * FROM " . $this->table);
        return $this->db->resultSet();
    }

    // Tambah Kategori
    public function addCategory($name) {
        $query = "INSERT INTO " . $this->table . " (name) VALUES (:name)";
        $this->db->query($query);
        $this->db->bind('name', $name);
        $this->db->execute();
        return $this->db->rowCount();
    }

    // Hapus Kategori
    public function deleteCategory($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }
}