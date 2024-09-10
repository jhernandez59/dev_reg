<?php
// Iniciar la sesión
// Configurar el tiempo de vida de la sesión a 30 minutos (30*60segundos)
// ini_set('session.gc_maxlifetime', 1800);
// session_set_cookie_params(1800);
session_start();

require_once '../classes/User.php';

$user = new User();
if (!$user->isLoggedIn()) {
    header('Location: login.php');
    exit;
}

// Tiempo de inactividad permitido (en segundos)
$inactive = 1800; // 30 minutos

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $inactive) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}
$_SESSION['last_activity'] = time();

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<h1>Bienvenido, <?php echo $_SESSION['user_name']; ?>!</h1>
<a href="logout.php">Cerrar sesión</a>
