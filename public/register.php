<?php
require_once '../config/config.php';
require_once '../classes/Database.php';
require_once '../classes/User.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $user = new User();
  $user->register($_POST['name'], $_POST['email'], $_POST['password']);

  // header('Location: login.php');
  // header('Location: pagina_protegida.php');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
</head>
<body>
  <section class="section">    
        <div class="container" style="max-width: 800px;">
            <h1 class="title">Registro</h1>

            <form method="post" action="register.php">

                <div class="field">
                    <label class="label">Nombre</label>
                    <div class="control">
                        <input class="input" type="text" name="name" placeholder="Nombre" required>
                    </div>
                </div>

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
                    <button class="button is-primary" type="submit">Registrarse</button>
                </div>
            </form>
        </div>
    </section>    
</body>
</html>
