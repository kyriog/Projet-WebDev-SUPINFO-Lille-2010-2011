<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <form action="md5.php" method="post">
            <input type="text" name="md5"/>
            <input type="submit" value="valider"/>
            <?php if(isset($_POST['md5']))
                echo md5($_POST['md5']);
            ?>
        </form>
    </body>
</html>
