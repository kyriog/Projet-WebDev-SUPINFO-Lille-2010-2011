<?php
require_once 'include.php';
$familyManager = new PdoFamilyManager();
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
                <label for="name">Name :</label><input type="text" id="name" name="name" value="<?php echo $family->getName();?>"/><br />
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
    $family = new familiesModel($_POST['id'], $_POST['name'], $_POST['parentfamily']);
    $familyManager->edit_family($family);
}
?>