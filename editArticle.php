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
                <tr><td><label for="barcode">Code barre</label></td><td><input id="barCode" name="barcode" type="text" value="<?php echo $article->getBarcode();?>"></td></tr>
                <tr><td><label for="quantity">Quantité</label></td><td><input id="quantity" name="quantity" type="text" value="<?php echo $article->getQuantity();?>"/></td></tr>
                <tr><td><label for="description">Description</label></td><td><input id="description" name="description" type="text" value="<?php echo $article->getDescription();?>"/></td></tr>
                <tr>
                    <td><label for="state">Etat</label></td>
                    <td>
                        <select name="state" id="state">
                            <option value="OK" <?php if($article->getState() == 'OK') echo "selected='selected'";?>>OK</option>
                            <option value="NOK"<?php if($article->getState() == 'NOK') echo "selected='selected'";?>>NOK</option>
                            <option value="TR" <?php if($article->getState() == 'TR') echo "selected='selected'";?>>TR</option>
                        </select>
                    </td>
                </tr>
                <tr><td><label for="place">Lieu de stockage</label></td>
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
                    <td><label for="dynamicvalue[<?php echo $dynamic_value->getId(); ?>]"><?php echo $dynamic_field->getName();?> :</label></td>
                    <td><input id="dynamicvalue[<?php echo $dynamic_value->getId(); ?>]"name="dynamicvalue[<?php echo $dynamic_value->getId(); ?>]" type="text" value="<?php echo $dynamic_value->getValue();?>"/></td>
                </tr>
                <?php } ?>
            </table>
            <input type="submit" value="valider"/>
            <input type="hidden" name="id" value="<?php echo $_GET['id']?>" />
        </form>
    </body>
</html>
<?php } 
else if(isset($_POST)) {
    $article = new Model_Article($_POST['id']);
    $article->setBarcode($_POST['barcode']);
    $article->setQuantity($_POST['quantity']);
    $article->setDescription($_POST['description']);
    $article->setState($_POST['state']);
    $article->setPlace($_POST['place']);
    $article->save();
    if(isset($_POST['dynamicvalue'])) {
        $dynamic_values_strings = $_POST['dynamicvalue'];
        foreach ($dynamic_values_strings as $index => $dynamic_value_string) {
            $dynamic_value = new Model_Dynamic_Value($index);
            $dynamic_value->setValue($dynamic_value_string);
            $dynamic_value->save();
        }
    }
    $id_article = $article->getId();
    header("Location: viewArticle.php?id=$id_article");
}
?>
