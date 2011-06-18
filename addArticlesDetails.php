<?php
require_once('config.php');
require_once('autoload.php');

if(isset($_POST['family'])):
$family = new Model_Family($_POST['family']);
$dynamic_fields = $family->getDynamicFields();
$i = 0;
?>
<table>
    <?php foreach ($dynamic_fields as $dynamic_field): ?>
    <tr>
        <td><label for="dynamicvalue[<?php echo $dynamic_field->getId(); ?>]"><?php echo $dynamic_field->getName();?> :</label></td>
        <td><input id="dynamicvalue[<?php echo $dynamic_field->getId(); ?>"name="dynamicvalue[<?php echo $dynamic_field->getId(); ?>]" type="text"/></td>
    </tr>
    <?php endforeach ?>
</table>
<?php endif ?>