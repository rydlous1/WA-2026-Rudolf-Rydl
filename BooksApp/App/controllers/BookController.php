<?php
// Načtení potřebných modelů (cesty jsou relativní k public/index.php, odkud se kód spouští)
require_once '../App/models/Database.php';
require_once '../App/models/Book.php';

class BookController {
    
    // výchozí metoda pro zobrazení úvodní stránky
    public function index(){
        require_once '../App/views/books/book_list.php';
    }

    // 1. Metoda pro ZOBRAZENÍ formuláře
    public function create() {
        require_once '../App/views/books/book_create.php';
    }

    // 2. Metoda pro ZPRACOVÁNÍ dat z formuláře
    public function store() {
        // Zkontrolujeme, zda sem uživatel přišel přes POST (odesláním formuláře)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Navázání spojení s databází
            $database = new Database();
            $db = $database->getConnection();

            // Pokud se připojení nezdařilo, nemůžeme pokračovat
            if (!$db) {
                die("Nepodařilo se připojit k databázi.");
            }

            // Vytvoření instance modelu Book
            $bookModel = new Book($db);

            // Stažení dat z $_POST pole s ošetřením chybějících hodnot
            $title = $_POST['title'] ?? '';
            $author = $_POST['author'] ?? '';
            $isbn = $_POST['isbn'] ?? '';
            $year = $_POST['year'] ?? '';

            // Pokus o uložení do databáze
            if ($bookModel->save($title, $author, $isbn, $year)) {
                // Po úspěšném uložení přesměrujeme zpět na seznam (Zamezí dvojitému odeslání F5)
                header('Location: /BooksApp/public/index.php?url=book/index');
                exit;
            } else {
                echo "Došlo k chybě při ukládání záznamu.";
            }
        } else {
            // Pokud přijde přes GET, vrátíme ho na formulář
            header('Location: /BooksApp/public/index.php?url=book/create');
            exit;
        }
    }
}