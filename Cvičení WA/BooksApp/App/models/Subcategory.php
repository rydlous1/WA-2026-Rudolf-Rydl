<?php

class Subcategory {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Metoda pro získání všech subkategorií
    public function getAllSubcategories() {
        $stmt = $this->db->prepare("SELECT * FROM subcategories ORDER BY name ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Volitelně: Metoda pro získání subkategorií podle konkrétní hlavní kategorie
    public function getSubcategoriesByCategoryId($categoryId) {
        $stmt = $this->db->prepare("SELECT * FROM subcategories WHERE category_id = :category_id ORDER BY name ASC");
        $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}