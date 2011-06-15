<?php
session_start();
require_once('config.php');
require_once('autoload.php');
if(isset($_GET['family'])) {
    ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <style type="text/css">
            table{
                border-collapse: collapse;
                border: 1px solid black;
            }
            th, td {
                border: 1px solid black;
                padding-left: 5px;
                padding-right: 5px;
            }
        </style>
        <table>
            <?php 
            $family = new Model_Family($_GET['family']);
            $dynamic_fields = $family->getDynamicFields();
            ?>
            <caption><a href="viewFamily.php">Family : <?php echo $family->getName()?></a></caption>
            <tr>
                <th>Numéro de référencement</th><th>Code bare</th><th>Quantité dispo</th><th>Description</th><th>Etat</th><th>Lieu de stockage</th>
                <?php 
                //On ajoute s'il y en les titre des champs dynamiques
                foreach ($dynamic_fields as $dynamic_field) { ?>
                <th><?php echo $dynamic_field->getName();?></th>
                <?php }
                ?>
            </tr>
            <?php
                //On ajoute les articles dans le tableau
                $articles = Model_Article::getArticlesOfFamily($family->getId());
                foreach($articles as $article) {
            ?>
            <tr>
                <td><?php echo $article->getId(); ?></td><td><?php echo $article->getBarcode(); ?></td><td><?php echo $article->getQuantity(); ?></td><td><?php echo $article->getDescription(); ?></td><td><?php echo $article->getState(); ?></td><td><?php echo $article->getPlace(); ?></td>
                
                <?php 
                //On ajoute toujours s'il y en a les valeurs des champs dynamiques
                foreach ($dynamic_fields as $dynamic_field) { ?>
                <td><?php echo Model_Dynamic_Value::getValueByIds($dynamic_field->getId(), $article->getId());?></td>
                <?php }
                ?>
            </tr>
            <?php 
                }
                ?>
        </table>
    </body>
</html>
<?php 

} ?>
