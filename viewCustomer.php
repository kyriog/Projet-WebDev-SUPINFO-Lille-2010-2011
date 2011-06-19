<?php
session_start();
require_once('config.php');
require_once('autoload.php');
if(isset($_POST['id'])) {
    $customer = new Model_Customer($_POST['id']);
    $customer->remove();
    echo 'ok';
    die;
}
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
                var action_alert = "<img src=\"media/alert.png\" alt=\"Erreur\" />";
                var action_loading = "<img src=\"media/loading-mini.gif\" alt=\"Chargement\" />";
                var action_delete = "<img src=\"media/delete.png\" alt=\"Supprimer\" class=\"customer_delete pointer\" />";
                $(".customer_delete").live('click',function(){
                    var id = $(".customer_action").index($(this).parent());
                    var id_db = $($(".customer_id")[id]).text()
                    var fname = $($(".customer_fname")[id]).text();
                    var lname = $($(".customer_lname")[id]).text();
                    $($(".customer_action")[id]).html(action_loading);
                    if(confirm("Êtes-vous sûr de vouloir supprimer le client "+fname+" "+lname+" ?")) {
                        $.ajax({
                            type: "POST",
                            url: "viewCustomer.php",
                            data: "id="+id_db,
                            success: function(msg) {
                                if($.trim(msg) == "ok") {
                                    $($(".customer_line")[id]).fadeOut(1000, function() {
                                        $(this).remove();
                                    })
                                } else {
                                    $($(".customer_action")[id]).html(action_alert);
                                }
                            }
                        })
                    } else {
                        $($(".customer_action")[id]).html(action_delete);
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
            
            .pointer {
                cursor: pointer;
            }
        </style>
    </head>
    <body>
        <?php include 'search.php';?>       
        <table>
            <thead><th>Identifiant</th><th>Prénom</th><th>Nom</th><th>Téléphone</th><th>Structure</th><th>Fonction</th><th>Adresse</th></thead>
            <tbody>
                <?php foreach($customers as $customer) { 
                    $structure = new Model_Structure($customer->getStructure());?>
                <tr class="customer_line">
                    <td class="customer_id"><?php echo $customer->getId(); ?></td>
                    <td class="customer_fname"><?php echo $customer->getFname();?></td>
                    <td class="customer_lname"><?php echo $customer->getLname();?></td>
                    <td><?php echo $customer->getPhone();?></td>
                    <td><?php echo $structure->getName();?></td>
                    <td><?php echo $customer->getFunction();?></td>
                    <td><?php echo $customer->getAddress();?></td>
                    <td class="customer_action"><img src="media/delete.png" alt="Supprimer" class="customer_delete pointer" /></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </body>
</html>
