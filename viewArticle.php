<?php
session_start();
require_once('config.php');
require_once('autoload.php');

//Si on veut accèder aux articles d'une famille.
if(isset($_GET['family'])) {
    ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
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
            a, .link {
                cursor: pointer;
                color: blue;
                text-decoration: underline;
            }
        </style>
        <script type="text/javascript" src="jquery-1.6.1.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $(".delete").click(function(){
                    var id = $(this).attr("id").split('_')[1];
                    if(confirm("Êtes-vous sûr de vouloir supprimer l'article #"+id+" ?")) {
                        $.ajax({
                            type: "POST",
                            url: "articlesTable.php",
                            data: "action=delete&article="+id,
                            success: function() {
                                $("#article_"+id).hide("200", function() {
                                    $(this).remove();
                                })
                            }
                        })
                    }
                })
            })
        </script>
    </head>
    <body>
        <div id="articles">
        <?php
        require_once "articlesTable.php";
        ?>
        </div>
    </body>
</html>
<?php 
} 

//Si on a décidé d'accéder au détail d'un article, comme le demande l'énoncé ...
elseif(isset($_GET['id'])) { 
    $article = new Model_Article($_GET['id']);
    $place = new Model_Place($article->getPlace());
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
            <caption>Article : <?php echo $article->getId(); ?></caption>
            <tr>
                <th>Numéro de référencement</th><th>Code bare</th><th>Quantité dispo</th><th>Description</th><th>Etat</th><th>Lieu de stockage</th>
                <?php
                //On ajoute s'il y en les titre des champs dynamiques
                foreach ($dynamic_fields as $dynamic_field) { ?>
                <th><?php echo $dynamic_field->getName();?></th>
                <?php }
                ?>
            <tr/>
            <tr>
                <td><?php echo $article->getId();?></td><td><?php echo $article->getBarcode()?></td><td><?php echo $article->getQuantity()?></td><td><?php echo $article->getDescription()?></td><td><?php echo $article->getState()?></td><td><?php echo $place->getName();?></td>
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
            </tr>
        </table>
    </body>
</html>    
<?php
} 
?>
