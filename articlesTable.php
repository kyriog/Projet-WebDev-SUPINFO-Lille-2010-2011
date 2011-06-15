<?php
require_once('config.php');
require_once('autoload.php');
?>
<table>
<?php 
if(!isset($_POST['family']))
    $family = new Model_Family($_GET['family']);
else {
    $family = new Model_Family($_POST['family']);
    $article = new Model_Article($_POST['article']);
    $article->deleteArticle();
}
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
    //On ajoute, toujours s'il y en a, les valeurs des champs dynamiques
    foreach ($dynamic_fields as $dynamic_field) { ?>
    <td><?php echo Model_Dynamic_Value::getValueByIds($dynamic_field->getId(), $article->getId());?></td>
    <?php }
    ?>
    <td><a href="#" onclick="return deleteArticle(<?php echo $family->getId() ?>, <?php echo $article->getId();?>)">Supprimer</a></td>
</tr>
<?php 
    }
    ?>
</table>
