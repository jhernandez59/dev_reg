<?php
session_start();

require_once '../config/config.php';
require_once '../classes/Database.php';
require_once '../classes/User.php';
require_once '../classes/FormValidator.php';

class RegisterValidator extends FormValidator {
    public function validate() {
        $this->validateName();
        $this->validateSurname();
        $this->validatePhone();
        $this->validatePassword();
    }
  }

$validator = null;
$errors = [];
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $validator = new RegisterValidator($_POST);
  $validator->validate();
  $errors = $validator->getErrors();
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
    <title>Registro</title>
</head>
<body>
  
    <h1 class="title">Registro</h1>

    <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">

        <!-- Name -->
        <div class="field">
        <label class="label">Nombre</label>
        <div class="control">
            <input class="input" type="text" name="name" value="<?=$validator ? $validator->getName() : '' ?>" placeholder="Nombre">
        </div>
        </div>

        <!-- Surname -->
        <div class="field">
        <label class="label">Apellidos</label>
        <div class="control">
            <input class="input" type="text" name="surname" value="<?=$validator ? $validator->getSurname() : '' ?>"placeholder="Apellido">
        </div>
        </div>

        <!-- Phone  -->
        <div class="field">
            <label class="label">Teléfono</label>
            <div class="control">
                <input class="input" type="text" name="phone" value="<?=$validator ? $validator->getPhone() : '' ?>" placeholder="Teléfono">
            </div>
        </div>

        <!-- Password -->
        <div class="field">
            <label class="label">Tu contraseña</label>
            <div class="control">
                <input class="input" type="password" name="password" value="<?=$validator ? $validator->getPassword() : '' ?>"placeholder="Contraseña">
            </div>
        </div>
        
        <!-- Submit -->
        <div class="control">
            <button class="button is-primary" type="submit">Registrarse</button>
        </div>

    </form>
        

<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST') && empty($errors)) {  
    
    $user = new User();
    $user->register($_POST['name'], $_POST['surname'], $_POST['phone'], $email, $_POST['password']);
    
    header('Location: index_tmp.html');
    exit();
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
