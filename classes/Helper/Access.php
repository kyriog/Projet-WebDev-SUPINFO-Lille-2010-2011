<?php
class Helper_Access {
    public static function rejectIfLogout() {
        if(!isset($_SESSION['ip']) || $_SESSION['ip'] != $_SERVER['REMOTE_ADDR']) {
            echo '
<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
    </head>
    <body>
        <h1>Accès refusé</h1>
        <h2>Vous n\'êtes pas connecté</h2>
        <p><a href="login.php">Se connecter</a></p>
    </body>
</html>';
            die();
        }
    }
}

?>
