<?php
session_start();
require_once('config.php');
require_once('autoload.php');
if(!isset($_POST['submit']) || $_POST['lname'] == "" || $_POST['fname'] == "" || $_POST['phone'] == "" || $_POST['structure'] == "" || $_POST['function'] == "")
{
    $structures = Model_Structure::getAllStructures();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <form action="addCustomer.php" method="post">
            <table>
                <tr>
                    <td><label for="lname">Last name : </label></td>
                    <td><input type="text" name="lname" id="lname" <?php if(isset($_POST['lname'])) { $lname = $_POST['lname']; echo "value='$lname'"; }?>/></td>
                            <?php if(isset($_POST['submit']) && $_POST['lname'] == "") { ?><td>Champ obligatoire !</td><?php } ?>
                </tr>
                
                
                <tr>
                    <td><label for="fname">First name : </label></td>
                    <td><input type="text" name="fname" id="fname" <?php if(isset($_POST['fname'])) { $fname = $_POST['fname']; echo "value='$fname'"; }?>/></td>
                            <?php if(isset($_POST['submit']) && $_POST['fname'] == "") { ?><td>Champ obligatoire !</td><?php } ?>
                </tr>
                
                
                <tr>
                    <td><label for="phone">Phone : </label></td>
                    <td><input type="text" name="phone" id="phone" <?php if(isset($_POST['phone'])) { $phone = $_POST['phone']; echo "value='$phone'"; }?>/></td>
                            <?php if(isset($_POST['submit']) && $_POST['phone'] == "") { ?><td>Champ obligatoire !</td><?php } ?>
                </tr>
                
                
                <tr>
                    <td><label for="structure">Structure : </label></td>
                    <td>
                        <select name="structure" id="structure">
                            <?php foreach($structures as $structure) { ?>
                            <option value="<?php echo $structure->getId();?>"><?php echo $structure->getName();?></option>
                            <?php } ?>
                        </select>
                    </td>
                            <?php if(isset($_POST['submit']) && $_POST['structure'] == "") { ?><td>Champ obligatoire !</td><?php } ?>
                </tr>
                
                
                <tr>
                    <td><label for="function">Function : </label></td>
                    <td><input type="text" name="function" id="function" <?php if(isset($_POST['function'])) { $function = $_POST['function']; echo "value='$function'"; }?>/></td>
                            <?php if(isset($_POST['submit']) && $_POST['function'] == "") { ?><td>Champ obligatoire !</td><?php } ?>
                </tr>
                
                
                <tr><td><label for="address">Address : </label></td>
                    <td><input type="text" name="address" id="address"/></td>
                </tr>
            </table>
            <input type="submit" name="submit"/>
        </form>
    </body>
</html>
<?php }
else {
    $customer = new Model_Customer();
    $customer->setLname($_POST['lname']);
    $customer->setFname($_POST['fname']);
    $customer->setPhone($_POST['phone']);
    $customer->setStructure($_POST['structure']);
    $customer->setFunction($_POST['function']);
    $customer->setAddress($_POST['address']);
    $customer->save();
}

