<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Verifica que las contraseñas coincidan
    if ($password !== $confirm_password) {
        echo "Las contraseñas no coinciden. Por favor, inténtalo de nuevo.";
        exit();
    }

    // Aquí puedes agregar la lógica para guardar el usuario en la base de datos
    // Asegúrate de cifrar la contraseña antes de guardarla
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Ejemplo de inserción en la base de datos (ajusta según tu configuración)
    // $conn = new mysqli('localhost', 'usuario', 'contraseña', 'base_de_datos');
    // $stmt = $conn->prepare("INSERT INTO users (name, phone, email, password) VALUES (?, ?, ?, ?)");
    // $stmt->bind_param("ssss", $name, $phone, $email, $hashed_password);
    // $stmt->execute();
    // $stmt->close();
    // $conn->close();

    echo "Registro exitoso.";
}
?>
