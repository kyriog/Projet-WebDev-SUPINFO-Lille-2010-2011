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
        <script type="text/javascript">
            //Fonction pour initialiser le xhr, suivant si l'utilisateur utilisateur utilise ou non
            //un vrai navigateur (donc pas Internet Explorer ...)
            function getXMLHttpRequest() {
                    var xhr = null;

                    if (window.XMLHttpRequest || window.ActiveXObject) {
                            if (window.ActiveXObject) {
                                    xhr = new ActiveXObject("Msxml2.XMLHTTP");
                            } else {
                                    xhr = new XMLHttpRequest();
                            }
                    } else {
                            alert("Impossible to use AJAX on your web browser !");
                    }

                    return xhr;
            }

            function loaddetails() {
                var xhr = getXMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == XMLHttpRequest.DONE) {
                        if(xhr.status == 200) {
                            //L'élément à recharger, avec les données qu'il va recevoir.
                            document.getElementById("addArticle").innerHTML = xhr.responseText;
                        }
                    }
                }
                //Les argument à passer, en POST.
                xhr.open("POST", "addArticlesDetails.php");
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                choice = document.getElementById("family");
                idfamily = choice.options[choice.selectedIndex].value;
                xhr.send("family=" + idfamily);
            }
        </script>
    </head>
    <body>
        <form method="post" action="addArticle.php">
            <label for="family">Family : </label>
            <select name="family" id="family" onchange='loaddetails()'>
                <option value="-1">None</option>
                <?php 
                foreach($families as $family) { ?>
                <option value="<?php echo $family->getId();?>"><?php echo $family->getName();?></option>
                <?php
                } ?>
            </select>
            <fieldset><legend>Standard fields</legend>
            <table>
                <tr><td><label for="barCode">Barcode</label></td><td><input id="barCode" name="barCode" type="text"></td></tr>
                <tr><td><label for="quantity">Quantity</label></td><td><input id="quantity" name="quantity" type="text"/></td></tr>
                <tr><td><label for="description">Description</label></td><td><input id="description" name="description" type="text"/></td></tr>
                <tr>
                    <td><label for="state">State</label></td>
                    <td>
                        <select name="state" id="state">
                            <option value="OK">OK</option>
                            <option value="NOK">NOK</option>
                            <option value="TR">TR</option>
                        </select>
                    </td>
                </tr>
                <tr><td><label for="place">Storage place</label></td>
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
            <fieldset><legend>Dynamics fields</legend>
            <div id="addArticle">
                <p>Merci de d'abord sélectionner une famille</p>
            </div>
            </fieldset>
            <input type="submit" />
        </form>
    </body>
</html>
<?php } 
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
        $dynamic_values = $_POST['dynamicvalue'];
        foreach ($dynamic_values as $index => $dynamic_value) {
            $dynamic_value = new Model_Dynamic_Value();
            $dynamic_value->setId_field($index);
            $dynamic_value->setValue($dynamic_value);
            $dynamic_value->setId_article($article->getId());
            /*var_dump($dynamic_value);
            die;*/
            $dynamic_value->save();
        }
    }
}
?>
