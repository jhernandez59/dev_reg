<?php

require_once '../config/config.php';
require_once '../classes/Database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = new Database(); 
    }

    public function register($name, $email, $password) {
        $password = password_hash($password, PASSWORD_BCRYPT);
        $this->db->query('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
        $this->db->bind(':name', $name);
        $this->db->bind(':email', $email);
        $this->db->bind(':password', $password);
        return $this->db->execute();
    }

    public function login($email, $password) {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        $row = $this->db->single();
        if ($row && password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            return true;
        } else {
            return false;
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

}
?>

