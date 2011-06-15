<?php
session_start();
require_once('config.php');
require_once('autoload.php');
if(isset($_POST['username']) && isset($_POST['password'])) {
    $user = new Model_User();
    
    //Ici le "user =" servira si on a besoin de récupérer les données du client, sinon on peut supprimer cette partie.
    if($user = $user->login($_POST['username'], $_POST['password']))
    {
        $_SESSION['id'] = $user->getId();
        $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
    }
}

else { ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <form action="login.php" method="post">
            <label for="username">Username : </label><input name="username" type="text" id="username"/><br/>
            <label for="password">Password : </label><input name="password" type="password" id="password"/><br/>
            <input type="submit" value="Login !"/>            
        </form>
    </body>
</html>
<?php 
} ?>
