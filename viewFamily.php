<?php
session_start();
require_once 'include.php';
$familyManager = new PdoFamilyManager();
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
            <tr><td><?php echo $value->getName(); ?></td><td><?php echo $value->getParentfamily(); ?></td></tr>
            <?php } ?>
        </table>    
    </body>
</html>
