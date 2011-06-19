<?php 
session_start();
require_once('config.php');
require_once('autoload.php');

if(isset($_SESSION['ip']) && $_SESSION['ip'] == $_SERVER['REMOTE_ADDR'] && isset($_POST['search'])) {
$typeSearch = substr($_POST['search'], 0, 1);

switch ($typeSearch) {
    case 1:
        $search = new Model_Article($_POST['search']);
        $id = $search->getId();
        if(!is_null($id))
            header("Location: viewArticle.php?id=$id");
        break;
    case 4:
        $search = new Model_Customer($_POST['search']);
        $id = $search->getId();
        if(!is_null($id))
            header("Location: viewCustomer.php?id=$id");
        break;
    case 5:
        $search = new Model_Loan($_POST['search']);
        $id = $search->getId();
        if(!is_null($id))
            header ("Location: editLoan.php?id=$id");
        break;
            
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <style type="text/css">
            table {
                border-collapse: collapse;
            }
            td {
                border: 1px solid black;
                padding: 5px 5px 5px 5px;
            }
            th {
                border: 1px solid black;
                padding: 5px 5px 5px 5px;              
            }
        </style>
    </head>
    <body>
        <h3>Votre recherche n'a pas pu aboutir, voici la liste des éléments du même type que votre recherche</h3>
    <?php switch($typeSearch) {
        case 1: 
            $articles = Model_Article::getAllArticles();?>
        <table>
            <tr><th>Numéro de référencement</th><th>Description</th></tr>
        <?php foreach($articles as $article) { ?>
            <tr><td><a href="viewArticle.php?id=<?php echo $article->getId();?>"><?php echo $article->getId(); ?></a></td><td><?php echo $article->getDescription() ?></td></tr>            
        <?php } ?>
        </table>
    <?php break;

        case 4: 
            $customers = Model_Customer::getAllCustomers();?>
        <table>
            <tr><th>Numéro d'identification</th><th>Prénom</th><th>Nom</th></tr>
        <?php foreach($customers as $customer) { ?>
            <tr><td><a href="viewCustomer.php?id=<?php echo $customer->getId();?>"><?php echo $customer->getId(); ?></a></td><td><?php echo $customer->getFname(); ?></td><td><?php echo $customer->getLname(); ?></td></tr>            
        <?php } ?>
        </table>
    <?php break;

        case 5: 
            $loans = Model_Loan::getAllLoans(); ?>
        <table>
            <tr><th>Numéro du prêt</th><th>Raison</th></tr>
        <?php foreach($loans as $loan) { ?>
            <tr><td><a href="editLoan.php?id=<?php echo $loan->getId();?>"><?php echo $loan->getId(); ?></a></td><td><?php echo $loan->getReason(); ?></td></tr>            
        <?php } ?>
        </table>
    <?php break; 
    
    } ?>
    </body>
</html>
<?php 
} ?>
