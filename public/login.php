<?php
session_start();

require_once '../config/config.php';
require_once '../classes/Database.php';
require_once '../classes/User.php';
require_once '../classes/FormValidator.php';

class EmailPasswordValidator extends FormValidator {
  public function validate() {
      $this->validateEmail();
      $this->validatePassword();
  }
}

$validator = null;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $validator = new EmailPasswordValidator($_POST);
  $validator->validate();
  $errors = $validator->getErrors();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>

    <h3>Login</h3>

    <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        
        <!-- email -->        
        <div>
        E-mail: <input type="text" name="email" value="<?=$validator ? $validator->getEmail() : '' ?>">
        <span class="error">* <?= $errors['email'] ?? '' ?></span>
        <br><br>
        </div>

        <!-- password -->
        <div>
        Password: <input type="password" name="password" value="<?=$validator ? $validator->getPassword() : '' ?>">
        <span class="error"><?= $errors['password'] ?? '' ?></span>
        <br><br>
        </div>
        
        <a href="change_password.php">¿Olvidaste tu contraseña?</a>

        <!-- submit -->
        <div>
            <button type="submit">Entrar</button>
        </div>
    </form>

<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST') && empty($errors)) {
    // input values ok => login
    $user = new User();
    $loggedInUser = $user->login($_POST['email'], $_POST['password']);
  
    if ($loggedInUser) {
      header('Location: index_tmp.html');
      exit();
    } else {
      // login failed - email o contraseña no registrados o incorrectos      
      // registrase 
      $_SESSION['email'] = $_POST['email'];
      header('Location: register.php');
      exit();
    }
    
} else {
    echo '<h3>Form Errors</h3>';
    echo '<ul>';
    foreach ($errors as $error) {
        echo "<li>$error</li>";
    }
    echo '</ul>';
}
?>

</body>
</html>
