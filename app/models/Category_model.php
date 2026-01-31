<?php

class Category_model {
    private $table = 'categories';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAllCategories() {
        // Kita JOIN tabelnya dengan dirinya sendiri (Self Join)
        // Biar ketahuan kategori ini punya induk atau nggak
        $query = "SELECT c1.*, c2.name as parent_name 
                  FROM " . $this->table . " c1 
                  LEFT JOIN " . $this->table . " c2 ON c1.parent_id = c2.id 
                  ORDER BY c1.parent_id ASC, c1.name ASC";
        
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function getCategoryById($id) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id=:id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function addCategory($data) {
        // Cek apakah user milih parent atau kosong (jadi induk utama)
        $parentId = empty($data['parent_id']) ? null : $data['parent_id'];

        $query = "INSERT INTO " . $this->table . " (name, parent_id) VALUES (:name, :pid)";
        $this->db->query($query);
        $this->db->bind('name', $data['name']);
        $this->db->bind('pid', $parentId);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function updateCategory($data) {
        $parentId = empty($data['parent_id']) ? null : $data['parent_id'];

        $query = "UPDATE " . $this->table . " SET name = :name, parent_id = :pid WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('name', $data['name']);
        $this->db->bind('pid', $parentId);
        $this->db->bind('id', $data['id']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function deleteCategory($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }
}