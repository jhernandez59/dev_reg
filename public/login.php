<?php
// session_start();

require_once '../config/config.php';
require_once '../classes/Database.php';
require_once '../classes/User.php';
require_once '../classes/FormValidator.php';

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

            <form method="post" action="login.php">

                <div class="field">
                    <label class="label">Email</label>
                    <div class="control">
                        <input class="input" type="email" name="email" placeholder="Email" required>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Contraseña</label>
                    <div class="control">
                        <input class="input" type="password" name="password" placeholder="Contraseña" required>
                    </div>
                </div>
                <div class="control">
                    <button class="button is-primary" type="submit">Entrar</button>
                </div>
            </form>
        </div>
    </section>  
</body>
</html>
