<?php
require_once('config.php');
require_once('autoload.php');
?>
<table>
<?php
if(isset($_POST['action'])) {
    switch($_POST['action']) {
        case 'delete':
            $article = new Model_Article($_POST['article']);
            $article->deleteArticle();
            break;
    }
}
else {
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
            $place = new Model_Place($article->getPlace());
    ?>
    <tr id="article_<?php echo $article->getId() ?>">
        <td><?php echo $article->getId(); ?></td><td><?php echo $article->getBarcode(); ?></td><td><?php echo $article->getQuantity(); ?></td><td><?php echo $article->getDescription(); ?></td><td><?php echo $article->getState(); ?></td><td><?php echo $place->getName(); ?></td>

        <?php 
        //On ajoute, toujours s'il y en a, les valeurs des champs dynamiques
        foreach ($dynamic_fields as $dynamic_field) { 
            $dynamic_value = new Model_Dynamic_Value;
            $dynamic_value->setId_field($dynamic_field->getId());
            $dynamic_value->setId_article($article->getId());
            ?>
        <td><?php echo $dynamic_value->getValue();?></td>
        <?php }
        ?>
        <td><a href="editArticle.php?id=<?php echo $article->getId();?>">Editer</a></td>
        <td><span class="link delete" id="delete_<?php echo $article->getId() ?>">Supprimer</span></td>
    </tr>
    <?php 
        }
        ?>
    </table>
<?php } ?>
