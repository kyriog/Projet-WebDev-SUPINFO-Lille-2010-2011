<?php
session_start();
require_once 'include.php';
$familyManager = new Pdo_Family();
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
            $families = $familyManager->retrieve_families();
            foreach($families as $value) {        
            ?>
            <tr><td><?php echo $value->getName(); ?></td><td><?php echo $familyManager->nameWithId($value->getParentfamily()); ?></td><td><a href="editFamily.php?id=<?php echo $value->getId();?>">Editer</a></td></tr>
            <?php } ?>
        </table>    
        <p><a href="editFamily.php">Add a family</a></p>
    </body>
</html>
