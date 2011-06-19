<?php
session_start();
require_once('config.php');
require_once('autoload.php');
if(!isset($_POST['barCode'])) {
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
                $("#family").change(function() {
                   $.ajax({
                       type: "POST",
                       url: "addArticlesDetails.php",
                       data: "family="+$("#family").val(),
                       success: function(msg) {
                           $("#addArticle").html(msg); 
                       }
                   });
                });
            });
        </script>
    </head>
    <body>
        <?php include_once 'search.php';?>
        <form method="post" action="addArticle.php">
            <label for="family">Family : </label>
            <select name="family" id="family">
                <option value="-1">Aucune</option>
                <?php 
                foreach($families as $family) { ?>
                <option value="<?php echo $family->getId();?>"><?php echo $family->getName();?></option>
                <?php
                } ?>
            </select>
            <fieldset><legend>Champs standards</legend>
            <table>
                <tr><td><label for="barCode">Code Barre</label></td><td><input id="barCode" name="barCode" type="text"></td></tr>
                <tr><td><label for="quantity">Quantité</label></td><td><input id="quantity" name="quantity" type="text"/></td></tr>
                <tr><td><label for="description">Description</label></td><td><input id="description" name="description" type="text"/></td></tr>
                <tr>
                    <td><label for="state">Etat</label></td>
                    <td>
                        <select name="state" id="state">
                            <option value="OK">OK</option>
                            <option value="NOK">NOK</option>
                            <option value="TR">TR</option>
                        </select>
                    </td>
                </tr>
                <tr><td><label for="place">Lieu de stockage</label></td>
                    <td>
                        <select name="place" id="place">
                            <?php 
                            $places = Model_Place::getAllPlaces();
                            foreach ($places as $place){ ?>
                            <option value="<?php echo $place->getId(); ?>"><?php echo $place->getName(); ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
            </table>
            </fieldset>
            <fieldset><legend>Champs dynamiques</legend>
            <div id="addArticle">
                <p>Merci de d'abord sélectionner une famille</p>
            </div>
            </fieldset>
            <input type="submit" value="valider"/>
        </form>
    </body>
</html>
<?php }

//Si le formulaire a bien été rempli, on ajoute les données à la bdd.
else { 
    $article = new Model_Article();
    $article->setBarcode($_POST['barCode']);
    $article->setDescription($_POST['description']);
    $article->setFamily($_POST['family']);
    $article->setPlace($_POST['place']);
    $article->setQuantity($_POST['quantity']);
    $article->setState($_POST['state']);
    $article->save();
    if(isset($_POST['dynamicvalue'])) {
        $dynamic_values_strings = $_POST['dynamicvalue'];
        foreach ($dynamic_values_strings as $index => $dynamic_value_string) {
            $dynamic_value = new Model_Dynamic_Value();
            $dynamic_value->setId_field($index);
            $dynamic_value->setValue($dynamic_value_string);
            $dynamic_value->setId_article($article->getId());
            $dynamic_value->save();
        }
    }
}
?>
