<?php

class GameController {

    public function index() {
        require_once '../app/models/Database.php';
        require_once '../app/models/Game.php';
        $db = (new Database())->getConnection();
        $gameModel = new Game($db);
        $games = $gameModel->getAll(); 
        require_once '../app/views/games/games_list.php';
    }

    public function create() {
        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('Nejdříve se přihlaste.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }
        require_once '../app/models/Database.php';
        require_once '../app/models/Category.php';
        $db = (new Database())->getConnection();
        $categoryModel = new Category($db);
        $categories = $categoryModel->getAll();
        require_once '../app/views/games/game_create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user_id'])) exit;
            
            $title = $_POST['title'] ?? ''; 
            $developer = $_POST['developer'] ?? '';
            $publisher = $_POST['publisher'] ?? '';
            $category_id = (int)($_POST['category_id'] ?? 0);
            $platform = $_POST['platform'] ?? '';
            $release_year = (int)($_POST['release_year'] ?? 0);
            $price = (float)($_POST['price'] ?? 0);
            $link = $_POST['link'] ?? '';
            $description = $_POST['description'] ?? '';

            $uploadedImages = $this->processImageUploads(); 
            require_once '../app/models/Database.php';
            require_once '../app/models/Game.php';
            $db = (new Database())->getConnection();
            $gameModel = new Game($db);

            if ($gameModel->create($title, $developer, $category_id, $platform, $release_year, $price, $publisher, $description, $link, $uploadedImages, $_SESSION['user_id'])) {
                $this->addSuccessMessage('Hra byla úspěšně uložena.');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            }
        }
    }

    public function edit($id = null) {
        if (!$id || ($_SESSION['role'] ?? '') !== 'admin') {
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }
        require_once '../app/models/Database.php';
        require_once '../app/models/Game.php';
        require_once '../app/models/Category.php';
        $db = (new Database())->getConnection();
        $gameModel = new Game($db);
        $game = $gameModel->getById($id);
        $categoryModel = new Category($db);
        $categories = $categoryModel->getAll();
        require_once '../app/views/games/game_edit.php';
    }

    public function update($id = null) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id && ($_SESSION['role'] ?? '') === 'admin') {
            require_once '../app/models/Database.php';
            require_once '../app/models/Game.php';
            $db = (new Database())->getConnection();
            $gameModel = new Game($db);
            $oldGame = $gameModel->getById($id);

            $title = $_POST['title'] ?? '';
            $developer = $_POST['developer'] ?? '';
            $publisher = $_POST['publisher'] ?? '';
            $category_id = (int)($_POST['category_id'] ?? 0);
            $platform = $_POST['platform'] ?? '';
            $release_year = (int)($_POST['release_year'] ?? 0);
            $price = (float)($_POST['price'] ?? 0);
            $link = $_POST['link'] ?? '';
            $description = $_POST['description'] ?? '';

            $newImages = $this->processImageUploads();
            $finalImages = !empty($newImages) ? $newImages : json_decode($oldGame['images'] ?? '[]', true);

            if ($gameModel->update($id, $title, $developer, $category_id, $platform, $release_year, $price, $publisher, $description, $link, $finalImages)) {
                $this->addSuccessMessage('Hra byla úspěšně upravena.');
                header('Location: ' . BASE_URL . '/index.php?url=game/show/' . $id);
                exit;
            }
        }
    }

    public function show($id = null) {
        if (!$id) header('Location: ' . BASE_URL . '/index.php');
        require_once '../app/models/Database.php';
        require_once '../app/models/Game.php';
        $db = (new Database())->getConnection();
        $gameModel = new Game($db);
        $game = $gameModel->getById($id);
        
        $stmt = $db->prepare("SELECT comments.*, users.username FROM comments JOIN users ON comments.user_id = users.id WHERE game_id = :game_id ORDER BY comments.created_at DESC");
        $stmt->execute([':game_id' => $id]);
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require_once '../app/views/games/game_show.php';
    }

    public function addComment($game_id = null) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $game_id && isset($_SESSION['user_id'])) {
            $content = htmlspecialchars($_POST['content'] ?? '');
            require_once '../app/models/Database.php';
            $db = (new Database())->getConnection();
            $stmt = $db->prepare("INSERT INTO comments (game_id, user_id, content) VALUES (:game_id, :user_id, :content)");
            if ($stmt->execute([':game_id' => $game_id, ':user_id' => $_SESSION['user_id'], ':content' => $content])) {
                $this->addSuccessMessage('Komentář přidán.');
            }
        }
        header('Location: ' . BASE_URL . '/index.php?url=game/show/' . $game_id);
        exit;
    }

    public function editComment($comment_id = null, $game_id = null) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $comment_id && isset($_SESSION['user_id'])) {
            $content = htmlspecialchars($_POST['content'] ?? '');
            require_once '../app/models/Database.php';
            $db = (new Database())->getConnection();
            
            // Úprava pouze pro autora (i pokud je admin, musí být autorem)
            $stmt = $db->prepare("UPDATE comments SET content = :content WHERE id = :id AND user_id = :user_id");
            $stmt->execute([':content' => $content, ':id' => $comment_id, ':user_id' => $_SESSION['user_id']]);
            
            $this->addSuccessMessage('Komentář byl upraven.');
        }
        header('Location: ' . BASE_URL . '/index.php?url=game/show/' . $game_id);
        exit;
    }

    public function deleteComment($comment_id = null, $game_id = null) {
        if ($comment_id && isset($_SESSION['user_id'])) {
            require_once '../app/models/Database.php';
            $db = (new Database())->getConnection();
            $stmt = $db->prepare("DELETE FROM comments WHERE id = :id AND (user_id = :u_id OR 'admin' = :role)");
            $stmt->execute([':id' => $comment_id, ':u_id' => $_SESSION['user_id'], ':role' => $_SESSION['role'] ?? '']);
            $this->addSuccessMessage('Odstraněno.');
        }
        header('Location: ' . BASE_URL . '/index.php?url=game/show/' . $game_id);
        exit;
    }

    public function delete($id = null) {
        if (isset($_SESSION['user_id']) && $id) {
            require_once '../app/models/Database.php';
            require_once '../app/models/Game.php';
            $db = (new Database())->getConnection();
            $gameModel = new Game($db);
            $game = $gameModel->getById($id);
            if ($game && ($game['created_by'] === $_SESSION['user_id'] || ($_SESSION['role'] ?? '') === 'admin')) {
                $gameModel->delete($id);
                $this->addSuccessMessage('Hra smazána.');
            }
        }
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    protected function addSuccessMessage($message) { $_SESSION['messages']['success'][] = $message; }
    protected function addErrorMessage($message) { $_SESSION['messages']['error'][] = $message; }
    protected function addNoticeMessage($message) { $_SESSION['messages']['notice'][] = $message; }

    protected function processImageUploads() {
        $uploadedFiles = [];
        $uploadDir = __DIR__ . '/../../public/uploads/'; 
        if (!is_dir($uploadDir)) { mkdir($uploadDir, 0777, true); }
        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            foreach ($_FILES['images']['name'] as $i => $name) {
                if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                    $newName = 'game_' . uniqid() . '.' . $ext;
                    if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $uploadDir . $newName)) $uploadedFiles[] = $newName; 
                }
            }
        }
        return $uploadedFiles;
    }
}