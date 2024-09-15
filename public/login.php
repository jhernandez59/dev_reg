<?php
ob_start();
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
  <title>Login</title>
  <link 
      rel="stylesheet" 
      href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
      />    
  <link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css"
  />
</head>
<body>
  <nav class="navbar topNav">
    <div class="container">
      <!-- Logo -->
      <div class="navbar-brand">
        <a class="navbar-item" href="../">
          <img src="../assets/restaurant-icon-png-4890_white.png" height="28">
        </a>
        <div class="navbar-burger burger" data-target="topNav">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
      <!-- Menu -->
      <div id="topNav" class="navbar-menu">
        <div class="navbar-start">          
          <a class="navbar-item" href="cover.html">Home</a>
          <a class="navbar-item" href="landing.html">Landing</a>
          <a class="navbar-item" href="blog.html">Blog</a>
          <a class="navbar-item" href="instaAlbum.html">Album</a>
          <a class="navbar-item" href="kanban[search].html">Kanban</a>
          <a class="navbar-item" href="search.html">Search</a>
          <a class="navbar-item" href="tabs.html">Tabs</a>
        </div>
        <!-- Menu Login -->
        <div class="navbar-end">
          <div class="navbar-item">
            <div class="field is-grouped">
              <p class="control">
                <a class="button is-small" href="register.php">
                  <span class="icon">
                    <i class="fa fa-user-plus"></i>
                  </span>
                  <span>
                    Registrar
                  </span>
                </a>
              </p>
              <p class="control">
                <a class="button is-small is-info is-outlined">
                  <span class="icon">
                    <i class="fa fa-user"></i>
                  </span>
                  <span>Entrar</span>
                </a>
              </p>
            </div>
          </div>
        </div>
        <!-- Fin Menu Login -->
      </div>
    </div>
  </nav>
  <!-- Fin Nav -->

  <section class="hero is-fullheight">
    <div class="hero-body">
      <div class="container has-text-centered">
        <div class="column is-4 is-offset-4">

          <h1 class="title is-4">Entrada</h1>
          <hr>
          <p class="subtitle">Inicia sesión para continuar</p>
          <div class="box">
            <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                <!-- email -->        
                <div class="field">
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
                  <p class="help <?= empty($errors) ? 'is-info' : 'is-danger' ?> has-text-left">
                    <?= $errors['password'] ?? 'El password debe tener al menos 6 caracteres' ?></p>
                  </div>
                </div>
                
                <!-- submit -->
                <div>
                    <button class="button is-block is-primary is-fullwidth is-medium" 
                    type="submit">Entrar <i class="fa fa-sign-in" aria-hidden="true"></i></button>
                </div>
            </form>
          </div>
          <nav class="level">
            <div class="level-item has-text-centered">
              <div>
                <a href="change_password.php">¿Cambiar contraseña?</a>
              </div>
            </div>
            <div class="level-item has-text-centered">
              <div>
                <a href="register.php">Registrarte</a>
              </div>
            </div>
          </nav>

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

      $_SESSION['user_name'] = $_POST['name'];
      $_SESSION['user_surname'] = $_POST['surname'];
      $_SESSION['user_email'] = $_POST['email'];

      header('Location: cover.html');
      exit();
      ob_end_flush();
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
