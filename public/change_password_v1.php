<?php
session_start();

require_once '../config/config.php';
require_once '../classes/Database.php';
require_once '../classes/User.php';
require_once '../classes/FormValidator.php';

class EmailConfirmPassValidator extends FormValidator {
  public function validate() {
      $this->validateEmail();
      $this->validatePassword();
      $this->validateConfirmPassword();
  }
}

$validator = null;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $validator = new EmailConfirmPassValidator($_POST);
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
                <a class="button is-small">
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

  <section class="container">
    <div class="columns is-multiline">
      <div class="column is-8 is-offset-2">
        <!-- columnas arriba  -->
        <div class="columns">
          <div class="column left">
              <h1 class="title is-1">Super Cool Website</h1>
              <h2 class="subtitle colored is-4">Lorem ipsum dolor sit amet.</h2>
              <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. 
                Corporis ex deleniti aliquam tempora libero excepturi vero soluta odio optio sed.</p>
          </div>

          <div class="column right has-text-centered">
            <h1 class="title is-4">¿Olvidaste tu Contraseña?</h1>
            <p class="description">Lorem ipsum dolor, sit amet consectetur adipisicing elit</p>

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
                  <p class="help is-danger has-text-left"><?= $errors['password'] ?? '' ?></p>
                  </div>
                </div>
      
                <!-- confirmar nueva contraseña -->
                <div class="field">
                  <label class="label has-text-left" for="confirm_password">Confirmar Nueva Contraseña</label>
                  <div class="control">
                    <input class="input is-medium" type="password" placeholder="Confirmar Nueva Contraseña" 
                    name="confirm_password" value="<?=$validator ? $validator->getConfirmPassword() : '' ?>">
                    <p class="help is-danger has-text-left"><?= $errors['confirm_password'] ?? '' ?></p>
                  </div>
                </div>
                
                <!-- submit -->
                <div>
                    <button class="button is-block is-primary is-fullwidth is-medium" 
                    type="submit">Cambiar Contraseña <i class="fa fa-key"></i></button>
                </div>

                <br>
                ¿Ya tienes una cuenta? <a href="login.php">Entra</a>
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
    $new_password = $_POST['password'];
    $confirm_new_password = $_POST['confirm_password'];
    
    if ($new_password === $confirm_new_password) {
        $user = new User();
        $emailInUser = $user->emailExists($_POST['email']);
        if ($emailInUser) {
          // actualizar contraseña
          if($user->updatePassword($_POST['email'], $new_password)) {
              echo '<h3>Contraseña cambiada</h3>';
              echo '<a href="login.php">Iniciar Sesión</a>';
              echo '<br><br>';
          } else {
              echo '<h3>No se pudo cambiar la contraseña</h3>';
              echo '<a href="reset_password.php">Volver</a>';
              echo '<br><br>';
          }
        } else {
            echo '<h3>Usuario no registrado</h3>';
            echo '<a href="register.php">Regístrate</a>';
            echo '<br><br>';
        }
    } else {
      echo '<h3>Las contraseñas no coinciden</h3>';
      echo '<a href="change_password.php">Volver</a>';  
    }  
  } else {
      echo '<ul>';
      foreach ($errors as $error) {
          echo "<li>$error</li>";
      }
      echo '</ul>';
  }

?>

</body>
</html>
