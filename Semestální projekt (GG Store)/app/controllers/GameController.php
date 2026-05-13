<?php

class GameController {

    // 0. Výchozí metoda pro zobrazení úvodní stránky se seznamem her
    public function index() {
        require_once '../app/models/Database.php';
        require_once '../app/models/Game.php';

        $database = new Database();
        $db = $database->getConnection();

        $gameModel = new Game($db);
        $games = $gameModel->getAll(); 
        
        require_once '../app/views/games/games_list.php';
    }

    // 1. Zobrazení formuláře pro přidání nové hry
    public function create() {
        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('Pro přidání hry se musíte nejprve přihlásit.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }
        
        require_once '../app/models/Database.php';
        $database = new Database();
        $db = $database->getConnection();

        require_once '../app/views/games/game_create.php';
    }

    // 2. Zpracování dat odeslaných z formuláře (uložení hry)
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            if (!isset($_SESSION['user_id'])) {
                $this->addErrorMessage('Pro uložení hry musíte být přihlášeni.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/login');
                exit;
            }
            $userId = $_SESSION['user_id'];

            $title = htmlspecialchars($_POST['title'] ?? '');
            $developer = htmlspecialchars($_POST['developer'] ?? '');
            $publisher = htmlspecialchars($_POST['publisher'] ?? '');
            $genre = htmlspecialchars($_POST['genre'] ?? ''); 
            $platform = htmlspecialchars($_POST['platform'] ?? '');
            $release_year = (int)($_POST['release_year'] ?? 0);
            $price = (float)($_POST['price'] ?? 0);
            $link = htmlspecialchars($_POST['link'] ?? '');
            $description = htmlspecialchars($_POST['description'] ?? '');

            $uploadedImages = $this->processImageUploads(); 

            require_once '../app/models/Database.php';
            require_once '../app/models/Game.php';

            $database = new Database();
            $db = $database->getConnection();

            $gameModel = new Game($db);
            $isSaved = $gameModel->create(
                $title, $developer, $genre, $platform, 
                $release_year, $price, $publisher, $description, $link, $uploadedImages,
                $userId 
            );

            if ($isSaved) {
                $this->addSuccessMessage('Hra byla úspěšně uložena do databáze.');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            } else {
                $this->addErrorMessage('Nastala chyba. Nepodařilo se uložit hru.');
            }
            
        } else {
            $this->addNoticeMessage('Pro přidání hry je nutné odeslat formulář.');
        }
    }

    // --- NOVÁ METODA: Zobrazení formuláře pro úpravu ---
    public function edit($id = null) {
        if (!$id) {
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Kontrola admina
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            $this->addErrorMessage('Ke správě her má přístup pouze administrátor.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/Game.php';

        $database = new Database();
        $db = $database->getConnection();
        
        $gameModel = new Game($db);
        $game = $gameModel->getById($id);

        if (!$game) {
            $this->addErrorMessage('Hra nebyla nalezena.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        require_once '../app/views/games/game_edit.php';
    }

    // --- NOVÁ METODA: Uložení upravených dat ---
    public function update($id = null) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            
            if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            }

            require_once '../app/models/Database.php';
            require_once '../app/models/Game.php';
            $database = new Database();
            $db = $database->getConnection();
            $gameModel = new Game($db);

            // Získání starých dat kvůli obrázkům
            $oldGame = $gameModel->getById($id);

            $title = htmlspecialchars($_POST['title'] ?? '');
            $developer = htmlspecialchars($_POST['developer'] ?? '');
            $publisher = htmlspecialchars($_POST['publisher'] ?? '');
            $genre = htmlspecialchars($_POST['genre'] ?? ''); 
            $platform = htmlspecialchars($_POST['platform'] ?? '');
            $release_year = (int)($_POST['release_year'] ?? 0);
            $price = (float)($_POST['price'] ?? 0);
            $link = htmlspecialchars($_POST['link'] ?? '');
            $description = htmlspecialchars($_POST['description'] ?? '');

            // Pokud byly nahrány nové obrázky, použijeme je. Jinak necháme ty staré.
            $newImages = $this->processImageUploads();
            $finalImages = !empty($newImages) ? $newImages : json_decode($oldGame['images'], true);

            $isUpdated = $gameModel->update(
                $id, $title, $developer, $genre, $platform, 
                $release_year, $price, $publisher, $description, $link, $finalImages
            );

            if ($isUpdated) {
                $this->addSuccessMessage('Hra byla úspěšně upravena.');
                header('Location: ' . BASE_URL . '/index.php?url=game/show/' . $id);
                exit;
            } else {
                $this->addErrorMessage('Chyba při ukládání úprav.');
                header('Location: ' . BASE_URL . '/index.php?url=game/edit/' . $id);
                exit;
            }
        }
    }

    // 3. Zobrazení detailu hry a jejích komentářů
    public function show($id = null) {
        if (!$id) {
            $this->addErrorMessage('Nebylo zadáno ID hry.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/Game.php';

        $database = new Database();
        $db = $database->getConnection();
        
        $gameModel = new Game($db);
        $game = $gameModel->getById($id);

        if (!$game) {
            $this->addErrorMessage('Hra nebyla nalezena.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        $stmt = $db->prepare("
            SELECT comments.*, users.username 
            FROM comments 
            JOIN users ON comments.user_id = users.id 
            WHERE game_id = :game_id 
            ORDER BY comments.created_at DESC
        ");
        $stmt->execute([':game_id' => $id]);
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once '../app/views/games/game_show.php';
    }

    // 4. Přidání komentáře
    public function addComment($game_id = null) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $game_id) {
            if (!isset($_SESSION['user_id'])) {
                $this->addErrorMessage('Pro přidání komentáře se musíte přihlásit.');
                header('Location: ' . BASE_URL . '/index.php?url=game/show/' . $game_id);
                exit;
            }

            $content = htmlspecialchars($_POST['content'] ?? '');
            $user_id = $_SESSION['user_id'];

            if (!empty(trim($content))) {
                require_once '../app/models/Database.php';
                $database = new Database();
                $db = $database->getConnection();

                $stmt = $db->prepare("INSERT INTO comments (game_id, user_id, content) VALUES (:game_id, :user_id, :content)");
                if ($stmt->execute([':game_id' => $game_id, ':user_id' => $user_id, ':content' => $content])) {
                    $this->addSuccessMessage('Komentář byl úspěšně přidán.');
                }
            }
        }
        header('Location: ' . BASE_URL . '/index.php?url=game/show/' . $game_id);
        exit;
    }

    // 5. Smazání komentáře
    public function deleteComment($comment_id = null, $game_id = null) {
        if (!$comment_id || !isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        require_once '../app/models/Database.php';
        $database = new Database();
        $db = $database->getConnection();

        $stmt = $db->prepare("SELECT user_id FROM comments WHERE id = :id");
        $stmt->execute([':id' => $comment_id]);
        $comment = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($comment) {
            $isAdmin = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');
            
            if ($comment['user_id'] === $_SESSION['user_id'] || $isAdmin) {
                $delStmt = $db->prepare("DELETE FROM comments WHERE id = :id");
                $delStmt->execute([':id' => $comment_id]);
                $this->addSuccessMessage('Komentář byl odstraněn.');
            } else {
                $this->addErrorMessage('Nemáte právo mazat cizí komentáře.');
            }
        }

        header('Location: ' . BASE_URL . '/index.php?url=game/show/' . $game_id);
        exit;
    }

    // 6. Smazání existující hry
    public function delete($id = null) {
        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('Pro smazání hry se musíte nejprve přihlásit.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/Game.php';

        $database = new Database();
        $db = $database->getConnection();
        $gameModel = new Game($db);
        $game = $gameModel->getById($id);

        if ($game && ($game['created_by'] === $_SESSION['user_id'] || $_SESSION['role'] === 'admin')) {
            $gameModel->delete($id);
            $this->addSuccessMessage('Hra byla smazána.');
        } else {
            $this->addErrorMessage('Nemáte oprávnění ke smazání této hry.');
        }

        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    // --- Pomocné metody ---

    protected function addSuccessMessage($message) {
        $_SESSION['messages']['success'][] = $message;
    }

    protected function addErrorMessage($message) {
        $_SESSION['messages']['error'][] = $message;
    }

    protected function addNoticeMessage($message) {
        $_SESSION['messages']['notice'][] = $message;
    }

    protected function processImageUploads() {
        $uploadedFiles = [];
        $uploadDir = __DIR__ . '/../../public/uploads/'; 
        if (!is_dir($uploadDir)) { mkdir($uploadDir, 0777, true); }

        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            $fileCount = count($_FILES['images']['name']);
            for ($i = 0; $i < $fileCount; $i++) {
                if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                    $tmpName = $_FILES['images']['tmp_name'][$i];
                    $ext = strtolower(pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION));
                    $newName = 'game_' . uniqid() . '.' . $ext;
                    if (move_uploaded_file($tmpName, $uploadDir . $newName)) {
                        $uploadedFiles[] = $newName; 
                    }
                }
            }
        }
        return $uploadedFiles;
    }
}