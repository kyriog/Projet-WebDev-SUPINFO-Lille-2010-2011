<?php
session_start();
require_once('config.php');
require_once('autoload.php');
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
            <tr><th>Name</th><th>Parent Family</th></tr>
            <?php 
            $families = Model_Family::getAllFamilies();
            foreach($families as $value) { 
                $parent_family = new Model_Family($value->getParentfamily());
            ?>
            <tr><td><a href="viewArticle.php?family=<?php echo $value->getId()?>"><?php echo $value->getName(); ?></a></td><td><?php echo $parent_family->getName(); ?></td><td><a href="editFamily.php?id=<?php echo $value->getId();?>">Editer</a></td></tr>
            <?php } ?>
        </table>    
        <p><a href="editFamily.php">Add a family</a></p>
    </body>
</html>
