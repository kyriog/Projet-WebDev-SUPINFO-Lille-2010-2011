<?php
session_start();
require_once('config.php');
require_once('autoload.php');
if(!isset($_POST['submit']) || $_POST['lname'] == "" || $_POST['fname'] == "" || $_POST['phone'] == "" || $_POST['structure'] == "" || $_POST['function'] == "" || isset($_GET['id']))
{
    if(isset($_GET['id']))
        $customer = new Model_Customer ($_GET['id']);
    else if(isset($_POST['id'])) 
        $customer = new Model_Customer ($_POST['id']);
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
                    <td>
                        <input type="text" name="lname" id="lname" 
                        <?php 
                        if(isset($_POST['lname']))
                            $lname = $_POST['lname']; 
                        else if(isset($customer))
                            $lname = $customer->getLname();
                        else $lname = null;
                        echo "value='$lname'";
                            ?>/>
                    </td>
                            <?php if(isset($_POST['submit']) && $_POST['lname'] == "") { ?><td>Champ obligatoire !</td><?php } ?>
                </tr>
                
                
                <tr>
                    <td><label for="fname">First name : </label></td>
                    <td>
                        <input type="text" name="fname" id="fname" 
                            <?php 
                            if(isset($_POST['fname'])) 
                                $fname = $_POST['fname'];
                            else if(isset($customer))
                                $fname = $customer->getFname();
                            else $fname = null;
                            echo "value='$fname'"; 
                                ?>/>
                    </td>
                            <?php if(isset($_POST['submit']) && $_POST['fname'] == "") { ?><td>Champ obligatoire !</td><?php } ?>
                </tr>
                
                
                <tr>
                    <td><label for="phone">Phone : </label></td>
                    <td>
                        <input type="text" name="phone" id="phone" 
                            <?php 
                            if(isset($_POST['phone'])) 
                                $phone = $_POST['phone']; 
                            else if(isset($customer))
                                $phone = $customer->getPhone();
                            else $phone = null;
                            echo "value='$phone'";
                                ?>/>
                    </td>
                            <?php if(isset($_POST['submit']) && $_POST['phone'] == "") { ?><td>Champ obligatoire !</td><?php } ?>
                </tr>
                
                
                <tr>
                    <td><label for="structure">Structure : </label></td>
                    <td>
                        <select name="structure" id="structure">
                            <option value="">select a structure</option>
                            <?php foreach($structures as $structure) { ?>
                            <option value="<?php echo $structure->getId();?>" <?php if(isset($customer) && $structure->getId() == $customer->getStructure()) echo "selected='selected'";?>><?php echo $structure->getName();?></option>
                            <?php } ?>
                        </select>
                    </td>
                            <?php if(isset($_POST['submit']) && $_POST['structure'] == "") { ?><td>Champ obligatoire !</td><?php } ?>
                </tr>
                
                
                <tr>
                    <td><label for="function">Function : </label></td>
                    <td>
                        <input type="text" name="function" id="function" 
                            <?php 
                            if(isset($_POST['function']))  
                                $function = $_POST['function']; 
                            else if(isset($customer))
                                $function = $customer->getFunction ();
                            else $function = null;
                            echo "value='$function'"; 
                            ?>/>
                    </td>
                            <?php if(isset($_POST['submit']) && $_POST['function'] == "") { ?><td>Champ obligatoire !</td><?php } ?>
                </tr>
                
                
                <tr><td><label for="address">Address : </label></td>
                    <td>
                        <input type="text" name="address" id="address"
                               <?php
                               if(isset($_POST['address']))
                                   $address = $_POST['address'];
                               else if(isset($customer))
                                   $address = $customer->getAddress();
                               else $address = null;
                               echo "value='$address'";
                               ?>/>
                    </td>
                </tr>
            </table>
            <?php if(isset($customer)) { ?>
            <input type="hidden" name="id" value="<?php echo $customer->getId();?>" />
            <?php } ?>
            <input type="submit" name="submit"/>
        </form>
    </body>
</html>
<?php }
else {
    if(isset($_POST['id']))
        $customer = new Model_Customer ($_POST['id']);
    else
        $customer = new Model_Customer();
    $customer->setLname($_POST['lname']);
    $customer->setFname($_POST['fname']);
    $customer->setPhone($_POST['phone']);
    $customer->setStructure($_POST['structure']);
    $customer->setFunction($_POST['function']);
    $customer->setAddress($_POST['address']);
    $customer->save();
}

