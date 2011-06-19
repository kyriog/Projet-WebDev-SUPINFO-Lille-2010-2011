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
        <form action="addUser.php" method="post">
            <label for="fname">First Name : </label><input name="fname" id="fname" type="text"/><br />
            <label for="lname">Last Name : </label><input name="lname" id="lname" type="text"/><br />
            <label for="phone">Phone number : </label><input name="phone" id="phone" type="text"/><br />
            <label for="password">Password : </label><input name="password" id="password" type="password"/><br />
            <input type="submit" name="submit" value="Create !"/>
        </form>
    </body>
</html>
<?php endif ?>