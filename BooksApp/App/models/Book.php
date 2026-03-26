<?php

class Book {
    private $conn;

    // Přijme existující připojení z Database.php //
    public function __construct($db) {
        $this->conn = $db;
    }

    // Metoda pro uložení knihy
    public function save($title, $author, $isbn, $year) {
        // DŮLEŽITÉ: Názvy sloupců (title, author...) musí odpovídat vaší tabulce v databázi!
        $sql = "INSERT INTO books (title, author, isbn, year) VALUES (:title, :author, :isbn, :year)";
        
        try {
            $stmt = $this->conn->prepare($sql);
            
            // Provedení dotazu s navázanými parametry pro ochranu před SQL injection
            $stmt->execute([
                ':title' => $title,
                ':author' => $author,
                ':isbn' => $isbn,
                ':year' => $year
            ]);
            return true;
        } catch (PDOException $e) {
            // Při chybě ji můžeme vypsat pro snazší ladění
            echo "Chyba při ukládání: " . $e->getMessage();
            return false;
        }
    }
}