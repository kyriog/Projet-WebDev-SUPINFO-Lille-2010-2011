<?php 
session_start();
if($_SESSION['ip'] == $_SERVER['REMOTE_ADDR'])
{
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <form action="addUser.php" method="post">
            <label for="username">Username : </label><input name="username" id="username" type="text"/><br />
            <label for="password">Password : </label><input name="password" id="password" type="password"/><br />
            <input type="submit" name="submit" value="Create !"/>
        </form>
    </body>
</html>
<?php
    if(isset($_POST['submit'])) {
        $user = new Model_User();
        $user->setName($_POST['name']);
        $user->password($_POST['password']);
        $user->save();
    }
} 
?>