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
  <link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css"
  />
</head>
<body>
  <section class="container">
    <div class="columns is-multiline">
      <div class="column is-8 is-offset-2">
        <!-- columnas arriba  -->
        <div class="columns">
          <div class="column left">
              <h1 class="title is-1">Super Cool Website</h1>
              <h2 class="subtitle colored is-4">Lorem ipsum dolor sit amet.</h2>
              <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Corporis ex deleniti aliquam tempora libero excepturi vero soluta odio optio sed.</p>
          </div>

          <div class="column right has-text-centered">
            <h1 class="title is-4">Regístrate hoy</h1>
            <p class="description">Lorem ipsum dolor, sit amet consectetur adipisicing elit</p>

            <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        
                <!-- email -->        
                <div class="field is-left">
                  <label class="label has-text-left" for="email">Email</label>
                  <div class="control">
                    <input class="input is-medium" type="text" placeholder="Email" 
                  name="email" value="<?=$validator ? $validator->getEmail() : '' ?>">
                </div>
                <p class="help is-danger has-text-left"><?= $errors['email'] ?? '' ?></p>                  
                </div>

                <!-- password -->
                <div class="field">
                  <label class="label has-text-left" for="password">Contraseña</label>
                  <div class="control">
                  <input class="input is-medium" type="password" placeholder="Contraseña"
                  name="password" value="<?=$validator ? $validator->getPassword() : '' ?>">
                  <p class="help is-danger has-text-left"><?= $errors['password'] ?? '' ?></p>
                  </div>
                </div>
                
                <!-- submit -->
                <div>
                    <button class="button is-block is-primary is-fullwidth is-medium" type="submit">Entrar</button>
                </div>

                <br>
                <a href="change_password.php">Cambiar contraseña</a>
                <br><br>

                <br>
            </form>

          </div>
        </div>
      </div>
      <!-- Fin columnas arriba -->

      <div class="column is-8 is-offset-2">
        <!-- columnas abajo -->
        <div class="columns">

        </div>
      </div>
    </div>
  </section>


    
<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST') && empty($errors)) {
    // input values ok => login
    $user = new User();
    $loggedInUser = $user->login($_POST['email'], $_POST['password']);
  
    if ($loggedInUser) {
      header('Location: index_tmp.html');
      exit();
    } else {
      // login failed
      $emailInUser = $user->emailExists($_POST['email']);
      
      if (!$emailInUser) {
        echo '<h3>E-mail no registrado</h3>';
        echo '<a href="register.php">Regístrate</a>';
        echo '<br><br>';
      } else {
        echo '<h3>Contraseña Incorrecta</h3>';
        echo '<a href="reset_password.php">¿Olvidaste tu contraseña?</a>';
        echo '<br><br>';
        echo $_SESSION['user_email'];
      }            
    }
    
} else {
    // echo '<h3>Form Errors</h3>';
    // echo '<ul>';
    // foreach ($errors as $error) {
    //    echo "<li>$error</li>";
    // }
    // echo '</ul>';
}
?>

</body>
</html>
