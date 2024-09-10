<?php
// session_start();

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

/*
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $user = new User();
  $loggedInUser = $user->login($_POST['email'], $_POST['password']);

  if ($loggedInUser) {
    header('Location: index.php');
  } else {
    echo 'Login fallido' . PHP_EOL;
    echo $user->getError() . PHP_EOL;
  }
}
*/

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
  <title>Document</title>
</head>
<body>
<section class="section">    
<div class="container" style="max-width: 800px;">
    <h1 class="title">Login</h1>

    <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <!-- email -->
        <div class="field">
            <label class="label">Email</label>
            <div class="control">
                <input 
                class="input" 
                type="email" 
                name="email"
                value= "<?= isset($validator) ? $validator->getEmail() : '' ?>" 
                placeholder="Email" required>
            </div>
            
        </div>
        <!-- password -->
        <div class="field">
            <label class="label">Contraseña</label>
            <div class="control">
                <input 
                class="input" 
                type="password" 
                name="password"
                value= "<?= isset($validator) ? $validator->getPassword() : '' ?>" 
                placeholder="Contraseña" required>
            </div>
            
        </div>
        <!-- submit -->
        <div class="control">
            <button class="button is-primary" type="submit">Entrar</button>
        </div>
    </form>
</div>
</section>

<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST') && empty($errors)) {
    echo '<h2>Your Input:</h2>';
    
    echo 'Email: ' . $validator->getEmail();
    echo '<br>';
    
    echo 'Password: ' . $validator->getPassword();
    echo '<br>';
    
} else {
    echo '<h2>Form Errors</h2>';
    echo '<ul>';
    foreach ($errors as $error) {
        echo "<li>$error</li>";
    }
    echo '</ul>';
}
?>

</body>
</html>
