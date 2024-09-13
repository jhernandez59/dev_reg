<?php
session_start();

require_once '../config/config.php';
require_once '../classes/Database.php';
require_once '../classes/User.php';
require_once '../classes/FormValidator.php';

class PasswordValidator extends FormValidator {
  public function validate() {
      $this->validatePassword();
      $this->validateConfirmPassword();
  }
}

$validator = null;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $validator = new PasswordValidator($_POST);
  $validator->validate();
  $errors = $validator->getErrors();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cambiar Contraseña</title>
</head>
<body>
    <h3>Cambiar Contraseña</h3>
    <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>>
        <!-- nueva contraseña -->
        <div>
        Nueva Contraseña: <input type="password" name="password" value="<?=$validator ? $validator->getPassword() : '' ?>">
        <br><br>
        </div>
        <!-- confirmar nueva contraseña -->
        <div>
        Confirmar Nueva Contraseña: <input type="password" name="confirm_password" value="<?=$validator ? $validator->getConfirmPassword() : '' ?>">
        <br><br>
        </div>
        <!-- submit -->
        <div>
            <button type="submit">Cambiar Contraseña</button>
        </div>
    </form>

<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST') && empty($errors)) {
    $new_password = $_POST['password'];
    $confirm_new_password = $_POST['confirm_password'];
    
    if ($new_password === $confirm_new_password) {
        $user = new User();
        $emailInUser = $user->emailExists($_SESSION['user_email']);
        echo $_SESSION['user_email']; // prueba
        if ($emailInUser) {
            if($user->updatePassword($_SESSION['user_email'], $new_password)) {
                echo '<h3>Contraseña cambiada</h3>';
                echo '<a href="login.php">Iniciar Sesión</a>';
                echo '<br><br>';
            }else {
                echo '<h3>No se pudo cambiar la contraseña</h3>';
                echo '<a href="reset_password.php">Volver</a>';
                echo '<br><br>';
            }

        } else {
            echo '<h3>E-mail NO registrado</h3>';
            echo '<a href="register.php">Regístrate</a>';
            echo '<br><br>';
          
        }               

    } else {
        echo '<h3>Las contraseñas no coinciden</h3>';
        echo '<a href="reset_password.php">Volver</a>';
        echo '<br><br>';
    }
        
} else {
    // echo '<h3>Form Errors</h3>';
    echo '<ul>';
    foreach ($errors as $error) {
        echo "<li>$error</li>";
    }
    echo '</ul>';
}
?>

</body>
</html>
