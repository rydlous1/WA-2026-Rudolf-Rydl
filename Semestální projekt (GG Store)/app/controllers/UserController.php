<?php

class UserController {
    
    public function index() {
        // Zabezpečení: Jen admin může vidět seznam uživatelů
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            $_SESSION['messages']['error'][] = "Přístup odepřen.";
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/User.php';

        $db = (new Database())->getConnection();
        $userModel = new User($db);
        $users = $userModel->getAll();

        require_once '../app/views/users/user_list.php';
    }

    public function delete($id) {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/User.php';

        $db = (new Database())->getConnection();
        $userModel = new User($db);

        if ($userModel->delete($id)) {
            $_SESSION['messages']['success'][] = "Uživatel byl smazán.";
        } else {
            $_SESSION['messages']['error'][] = "Nelze smazat sám sebe.";
        }

        header('Location: ' . BASE_URL . '/index.php?url=user/index');
        exit;
    }
}