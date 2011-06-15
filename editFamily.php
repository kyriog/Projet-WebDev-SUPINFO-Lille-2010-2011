<?php
require_once('config.php');
require_once('autoload.php');
$familyManager = new Pdo_Family();
if(isset($_POST['send'])) {
    $id = (!empty($_POST['id'])) ? $_POST['id'] : NULL;
    $family = new Model_Family($id);
    $family->setName($_POST['name']);
    $parentfamily = ($_POST['parentfamily'] == 0) ? NULL : $_POST['parentfamily'];
    $family->setParentfamily($parentfamily);
    $family->save();
    $fields = Model_Dynamic_Field::getFieldsByFamilyId($family->getId());
    foreach($_POST['field'] as $id=>$field)  {
        if(isset($fields[$id])) {
            if(empty($field))
                $fields[$id]->remove();
            else {
                $fields[$id]->setName($field);
                $fields[$id]->save();
            }
        }
        elseif(!empty($field)) {
            $new_field = new Model_Dynamic_Field();
            $new_field->setFamily($family);
            $new_field->setName($field);
            $new_field->save();
        }
    }
    //header('Location: editFamily.php?id='.$family->getId());
    header('Location: viewFamily.php');
}
else {
    $id = (isset($_GET['id'])) ? $_GET['id'] : NULL;
    $family = new Model_Family($id);
    $families = Model_Family::getAllFamilies();
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <title></title>
            <script type="text/javascript" src="jquery-1.6.1.min.js"></script>
            <script type="text/javascript">
                $(document).ready(function() {
                    $("#add-field").click(function() {
                        $("#fields").append('<input type="text" name="field[]" /><br />');
                    })
                })
            </script>
        </head>
        <body>
            <form action="editFamily.php" method="post">
                <label for="name">Name : </label><input type="text" id="name" name="name" value="<?php echo $family->getName();?>"/><br />
                <label for="parentfamily">Parent Family : </label><select name="parentfamily" id="parentfamily">
                    <option value="0">No parent family</option>
                <?php
                foreach ($families as $value):
                    if($value->getId() != $_GET['id']):
                    ?>
                    <option value="<?php echo $value->getId();?>" <?php if($value->getId() == $family->getParentfamily()) {?> selected="true"<?php } ?>><?php echo $value->getName();?></option>
                    <?php
                    endif;
                endforeach;
                ?>
                </select> <br />
                <span id="fields">
                    <?php
                    $fields = $family->getDynamicFields();
                    if(count($fields) > 0):
                        foreach($fields as $field):
                        ?>
                    <input type="text" name="field[]" value="<?php echo $field->getName() ?>" /><br />
                        <?php
                        endforeach;
                    else:
                    ?>
                    <input type="text" name="field[]" /><br />
                    <?php
                    endif;
                    ?>
                </span>
                <span id="add-field">Ajouter un champs</span><br />
                <input type="hidden" name="id" value="<?php echo $family->getId();?>" />
                <input type="submit" name="send" value="Send !"/>
            </form>
        </body>
    </html>
    <?php
}

?>

