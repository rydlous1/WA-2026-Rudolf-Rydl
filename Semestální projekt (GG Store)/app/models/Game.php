<?php

class Game {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;    
    }

    public function create(
        string $title,
        string $developer,
        int $category_id, 
        string $platform,
        int $release_year,
        float $price,
        string $publisher,
        string $description,
        string $link,
        array $images,
        int $userId
    ): bool {
        
        $sql = "INSERT INTO games (title, developer, category_id, platform, release_year, price, publisher, description, link, images, created_by)
                VALUES (:title, :developer, :category_id, :platform, :release_year, :price, :publisher, :description, :link, :images, :created_by)";
        
        $stmt = $this->db->prepare($sql);

        // Ukládáme pouze název prvního souboru jako čistý text
        $imageName = (is_array($images) && !empty($images)) ? $images[0] : null;

        return $stmt->execute([
            ':title' => $title,
            ':developer' => $developer,
            ':category_id' => $category_id, // Navázáno na ID
            ':platform' => $platform ?: null,
            ':release_year' => $release_year,
            ':price' => $price,
            ':publisher' => $publisher,
            ':description' => $description,
            ':link' => $link,
            ':images' => $imageName, 
            ':created_by' => $userId
        ]);
    }

    public function getAll() {
        // 💡 ZMĚNA: SQL JOIN na tabulku categories, abychom místo ID měli název kategorie
        $sql = "SELECT games.*, categories.name AS category_name 
                FROM games 
                LEFT JOIN categories ON games.category_id = categories.id 
                ORDER BY games.id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        // 💡 ZMĚNA: SQL JOIN přidán i pro detail hry
        $sql = "SELECT games.*, categories.name AS category_name 
                FROM games 
                LEFT JOIN categories ON games.category_id = categories.id 
                WHERE games.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update(
        $id, $title, $developer, $category_id, $platform, // Změna: Teď přijímáme ID kategorie (číslo)
        $release_year, $price, $publisher, $description, $link, $images = []
    ) {
        // Zjistíme, jestli přišel nějaký nový obrázek
        $imageName = (is_array($images) && !empty($images)) ? $images[0] : (is_string($images) ? $images : null);

        // ROZHODNUTÍ: Máme nový obrázek, nebo ne?
        if (!empty($imageName)) {
            // VARIANTA A: Uživatel nahrál NOVÝ obrázek -> aktualizujeme i sloupec 'images'
            $sql = "UPDATE games 
                    SET title = :title, 
                        developer = :developer, 
                        category_id = :category_id, -- Změna: ukládáme category_id
                        platform = :platform, 
                        release_year = :release_year, 
                        price = :price, 
                        publisher = :publisher, 
                        description = :description, 
                        link = :link, 
                        images = :images
                    WHERE id = :id";
        } else {
            // VARIANTA B: Uživatel nevybral nový obrázek -> sloupec 'images' úplně vynecháme!
            $sql = "UPDATE games 
                    SET title = :title, 
                        developer = :developer, 
                        category_id = :category_id, -- Změna: ukládáme category_id
                        platform = :platform, 
                        release_year = :release_year, 
                        price = :price, 
                        publisher = :publisher, 
                        description = :description, 
                        link = :link
                    WHERE id = :id";
        }
                
        $stmt = $this->db->prepare($sql);

        // Tyto parametry posíláme do databáze VŽDY
        $params = [
            ':id' => $id,
            ':title' => $title,
            ':developer' => $developer,
            ':category_id' => $category_id, // Navázáno na ID
            ':platform' => $platform ?: null,
            ':release_year' => $release_year,
            ':price' => $price,
            ':publisher' => $publisher,
            ':description' => $description,
            ':link' => $link
        ];

        // Pokud máme nový obrázek, musíme ho přidat i do parametrů pro uložení
        if (!empty($imageName)) {
            $params[':images'] = $imageName;
        }

        return $stmt->execute($params);
    }

    public function delete($id) {
        $sql = "DELETE FROM games WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}