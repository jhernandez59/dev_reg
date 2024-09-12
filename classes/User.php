<?php

require_once '../config/config.php';
require_once '../classes/Database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = new Database(); 
    }

    public function register($name, $surname, $phone, $email, $password) {
        $password = password_hash($password, PASSWORD_BCRYPT);
        $this->db->query('INSERT INTO users (name, surname, phone, email, password) 
            VALUES (:name, :surname, :phone, :email, :password)');
        $this->db->bind(':name', $name);
        $this->db->bind(':surname', $surname);
        $this->db->bind(':phone', $phone);
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

    public function updatePassword($email, $hashed_password) {
        $db = new Database();
        $conn = $db->getConnection();

        $sql = "UPDATE users SET password = :password WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':email', $email);

        $stmt->execute();
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

