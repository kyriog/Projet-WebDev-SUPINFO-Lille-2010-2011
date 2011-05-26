<?php
require_once('config.php');
require_once('autoload.php');
$familyManager = new Pdo_Family();
if(isset($_GET['id'])){
    $family = $familyManager->familyWithId($_GET['id']);
    $families = $familyManager->retrieve_families();
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <title></title>
        </head>
        <body>
            <form action="editFamily.php" method="post">
                <label for="name">Name : </label><input type="text" id="name" name="name" value="<?php echo $family->getName();?>"/><br />
                <label for="parentfamily">Parent Family : </label><select name="parentfamily" id="parentfamily">
                    <?php foreach ($families as $value) {
                        if($value->getId() != $_GET['id']) {?>
                    <option value="<?php echo $value->getId();?>" <?php if($value->getId() == $family->getParentfamily()) {?> selected="true"<?php } ?>><?php echo $value->getName();?></option>
                    <?php } 
                    }?>
                </select> <br />
                <input type="hidden" name="id" value="<?php echo $family->getId();?>" />
                <input type="submit" value="Send !"/>
            </form>
        </body>
    </html>
    <?php 
    
    } 
else if(!isset($_GET['id']) && isset($_POST['name']) && isset($_POST['parentfamily']) && isset($_POST['id'])) {
    $family = new Model_Family($_POST['id'], $_POST['name'], $_POST['parentfamily']);
    $familyManager->edit_family($family);
}

else if(!isset($_GET['id']) && isset($_POST['name']) && isset($_POST['parentfamily'])) {
    $family = new Model_Family(null, $_POST['name'], $_POST['parentfamily']);
    $familyManager->add_family($family);
}

else {
    $families = $familyManager->retrieve_families();
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <title></title>
            <script type="text/javascript" src="jquery-1.6.1.min.js"></script>
            <script type="text/javascript">
                $(document).ready(function() {
                    
                })
            </script>
        </head>
        <body>
            <form action="editFamily.php" method="post">
                <label for="name">Name : </label><input type="text" id="name" name="name" tabindex="1"/><br />
                <label for="parentfamily">Parent Family : </label><select name="parentfamily" id="parentfamily" tabindex="2">
                    <option value="0">No parent family</option>
                    <?php foreach ($families as $value) { ?>
                    <option value="<?php echo $value->getId();?>"><?php echo $value->getName();?></option>
                    <?php 
                    }?>
                </select> <br />
                <table>
                <?php for($i = 1; $i<=3; $i++) {
                ?>
                <tr>
                    <td><label for="champ<?php echo $i;?>">Champ <?php echo $i; ?> : </label><input type="text" name="champ<?php echo $i; ?>" id="champ<?php echo $i; ?>" tabindex="<?php echo $i+2; ?>"/></td>
                <td><label for="champ<?php echo $i+3; ?>">Champ <?php echo $i+3; ?> : </label><input type="text" name="champ<?php echo $i+3; ?>" id="champ<?php echo $i+3; ?>" tabindex="<?php echo $i+5; ?>"/></td>
                </tr>
                <?php } ?>
                </table>
                <input type="submit" value="Send !"/>
            </form>
        </body>
    </html>
<?php } ?>

