<?php 
session_start();
if($_SESSION['ip'] == $_SERVER['REMOTE_ADDR']):
    if(isset($_POST['submit'])) {
        $user = new Model_User();
        $user->setFname($_POST['fname']);
        $user->setLname($_POST['lname']);
        $user->setPhone($_POST['phone']);
        $user->password($_POST['password']);
        $user->save();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php include_once 'search.php';?>
        <form action="addUser.php" method="post">
            <table>
            <tr><td><label for="fname">Prénom : </label></td><td><input name="fname" id="fname" type="text"/></td></tr>
            <tr><td><label for="lname">Nom : </label></td><td><input name="lname" id="lname" type="text"/></td></tr>
            <tr><td><label for="phone">Téléphone : </label></td><td><input name="phone" id="phone" type="text"/></td></tr>
            <tr><td><label for="password">Mot de passe : </label></td><td><input name="password" id="password" type="password"/></td></tr>
            </table>
            <input type="submit" name="submit" value="Créer !"/>
        </form>
    </body>
</html>
<?php endif ?>