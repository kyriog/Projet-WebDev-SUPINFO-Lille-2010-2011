<?php 
session_start();
require_once('config.php');
require_once('autoload.php');
$loans = Model_Loan::getAllLoans();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <style>
            table {
                border-collapse: collapse;
            }
            th, td {
                border: 1px solid black;
                padding: 5px 5px 5px 5px;
            }
        </style>
    </head>
    <body>
        <?php include 'search.php'; ?>
        <table>
            <thead><th>Numéro du prêt</th><th>Client</th><th>Date de début</th><th>Date de fin</th><th>Motif</th></thead>
            <tbody>
                <?php foreach($loans as $loan) { ?>
                <tr><td><a href="printPage.php?id=<?php echo $loan->getId(); ?>"><?php echo $loan->getId();?></a></td><td><a href="viewCustomer.php?id=<?php echo $loan->getCustomer();?>"><?php echo $loan->getCustomer();?></a></td><td><?php echo $loan->getBegindate();?></td><td><?php echo $loan->getEnddate(); ?></td><td><?php echo $loan->getReason();?></td></tr>
                <?php } ?>
            </tbody>
        </table>
    </body>
</html>
