<?php 
session_start();
require_once('config.php');
require_once('autoload.php');

if(isset($_GET['id'])) {
    $article = new Model_Article($_GET['id']);
    $family = new Model_Family($article->getFamily());
    $dynamic_fields = $family->getDynamicFields();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <form method="post" action="editArticle.php">
            <table>
                <tr><td><label for="barCode">Barcode</label></td><td><input id="barCode" name="barCode" type="text" value="<?php echo $article->getBarcode();?>"></td></tr>
                <tr><td><label for="quantity">Quantity</label></td><td><input id="quantity" name="quantity" type="text" value="<?php echo $article->getQuantity();?>"/></td></tr>
                <tr><td><label for="description">Description</label></td><td><input id="description" name="description" type="text" value="<?php echo $article->getDescription();?>"/></td></tr>
                <tr>
                    <td><label for="state">State</label></td>
                    <td>
                        <select name="state" id="state">
                            <option value="OK" <?php if($article->getState() == 'OK') echo "selected='selected'";?>>OK</option>
                            <option value="NOK"<?php if($article->getState() == 'NOK') echo "selected='selected'";?>>NOK</option>
                            <option value="TR" <?php if($article->getState() == 'TR') echo "selected='selected'";?>>TR</option>
                        </select>
                    </td>
                </tr>
                <tr><td><label for="place">Storage place</label></td>
                    <td>
                        <select name="place" id="place">
                            <?php 
                            $places = Model_Place::getAllPlaces();
                            foreach ($places as $place){ ?>
                            <option value="<?php echo $place->getId(); ?>" <?php if($place->getId() == $article->getPlace()) echo "selected='selected'";?>><?php echo $place->getName(); ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
            
                <?php
                foreach ($dynamic_fields as $dynamic_field)
                {
                    $dynamic_value = new Model_Dynamic_Value();
                    $dynamic_value->setId_article($article->getId());
                    $dynamic_value->setId_field($dynamic_field->getId());
                ?>
                <tr>
                    <td><label for="dynamicvalue[<?php echo $dynamic_field->getId(); ?>]"><?php echo $dynamic_field->getName();?> :</label></td>
                    <td><input id="dynamicvalue[<?php echo $dynamic_field->getId(); ?>"name="dynamicvalue[<?php echo $dynamic_field->getId(); ?>]" type="text" value="<?php echo $dynamic_value->getValue();?>"/></td>
                </tr>
                <?php } ?>
            </table>
        </form>
    </body>
</html>
<?php } ?>
