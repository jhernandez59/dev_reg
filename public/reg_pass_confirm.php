<?php
session_start();
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
</head>
<body>
    <form method="post" action="process_registration.php">
        <input type="text" name="name" placeholder="Nombre" required>
        <input type="text" name="phone" placeholder="Teléfono" required>
        <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <input type="password" name="confirm_password" placeholder="Confirmar Contraseña" required>
        <input type="submit" value="Registrar">
    </form>
</body>
</html>
