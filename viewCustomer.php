<?php
session_start();
require_once('config.php');
require_once('autoload.php');
if(!isset($_GET['id']))
    $customers = Model_Customer::getAllCustomers();
else
    $customers = array(new Model_Customer($_GET['id']));
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <script type="text/javascript" src="jquery-1.6.1.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $(".delete").click(function(){
                    var id = $(this).attr("id").split('_')[1];
                    if(confirm("Êtes-vous sûr de vouloir supprimer le client "+id+" ?")) {
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
        <style type="text/css">
            table {
                border-collapse: collapse;
            }
            
            td, th {
                border: 1px black solid;
                padding: 5px 5px 5px 5px;
            }
        </style>
    </head>
    <body>
        <?php include 'search.php';?>       
        <table>
            <tr><th>Identifiant</th><th>Prénom</th><th>Nom</th><th>Téléphone</th><th>Structure</th><th>Fonction</th><th>Adresse</th></tr>
            <?php foreach($customers as $customer) { 
                $structure = new Model_Structure($customer->getStructure());?>
            <tr>
                <td><?php echo $customer->getId(); ?></td>
                <td><?php echo $customer->getFname();?></td>
                <td><?php echo $customer->getLname();?></td>
                <td><?php echo $customer->getPhone();?></td>
                <td><?php echo $structure->getName();?></td>
                <td><?php echo $customer->getFunction();?></td>
                <td><?php echo $customer->getAddress();?></td>
            </tr>
            <?php } ?>
        </table>
    </body>
</html>
