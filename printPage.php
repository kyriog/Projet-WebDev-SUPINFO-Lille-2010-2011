<?php
session_start();
require_once('config.php');
require_once('autoload.php');

if(isset($_GET['id']) && $_SESSION['ip'] == $_SERVER['REMOTE_ADDR']) {
    $user = new Model_User($_SESSION['id']);
    $loan = new Model_Loan($_GET['id']);
    $customer = new Model_Customer($loan->getCustomer());
    $structure = new Model_Structure($customer->getStructure());
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <style type="text/css">
            body {
                text-align: center;
                width: 800px;
                /*border: 1px solid black;*/
            }
            
            h1 {
                text-align: center;
            }
            
            .header {
                width: 800px;
            }
            
            .header img {
                width: 600px;
            }
            
            .customer {
                min-width: 300px;
                display: inline;
                border: solid 1px black;
                float:left;
                padding: 5px 20px 5px 20px;
            }
            
            .customer table {
                text-align: left;
            }
            
            .employee {
                min-width: 300px;
                text-align: left;
                padding: 5px 20px 5px 20px;
                display: inline;
                border: 1px solid black;
                float:right;
            }
            
            .firstLine {
                border-collapse: collapse;
                width: 800px;
            }
            
            .firstLine td{
                vertical-align: top;
            }
            
            .dates {
                margin-top: 20px;
                border: 1px solid black;
                width: 500px;
            }
            
            .dates table {
                width: 500px;
            }
            
            .articles table {
                width: 700px;
                margin-top: 20px;
                margin-bottom: 1px;
                border-collapse: collapse;
            }
            
            .articles td {
                text-align: left;
                border: 1px solid black;
                min-width: 75px;
                padding-right: 20px;
            }
            
            .articles th {
                text-align: left;
                border: 1px solid black;
                min-width: 75px;
                padding-right: 20px;
            }
            
            .signatures {
                margin-top: 20px;
                border-collapse: collapse;
                width: 700px;
            }
            
            .articles tr {
                height: 20px;
            }
            
            .articles .id_article {
                text-align: center;
            }
            
            .signature {
                border: 1px solid black;
                height: 75px;
                width: 300px;
                text-align: left;
                vertical-align: top;
            }
        </style>
    </head>
    <body>
        <div class="header"><img src="media/header.png" alt="bannière" /></div>
        <h1>Fiche de prêt N° <?php echo $loan->getId();?></h1>
        <table class="firstLine">
            <tr>
                <td>
                    <div class="customer">
                        <table>
                            <tr><td>N° de client : </td><td><?php echo $customer->getId()?></td></tr>
                            <tr><td>Nom : </td><td><?php echo $customer->getLname()?></td></tr>
                            <tr><td>Prénom : </td><td><?php echo $customer->getFname()?></td></tr>
                            <tr><td>Structure : </td><td><?php echo $structure->getName()?></td></tr>
                            <tr><td>Tél : </td><td><?php echo $customer->getPhone()?></td></tr>
                        </table>
                    </div>
                </td>
                <td>
                    <div class="employee">
                        Contact :<br/>
                        <?php echo $user->getfname(); echo " "; echo $user->getLname(); echo "<br />"; echo "Tel : "; echo $user->getPhone();?>
                    </div>
                </td>
            </tr>
        </table>
        <div class="dates">
            <table><tr><td>Date départ :</td><td><?php echo $loan->getBegindate(); ?></td><td>Date retour :</td><td><?php echo $loan->getEnddate(); ?></td></tr></table>
        </div>
        
        <div class="articles">
            <table>
                <tr><th>Code</th><th>Désignation</th><th>Qté</th><th></th><th></th><th></th></tr>
                <?php
                $articles = Model_Loan_Article::getAllArticlesByLoanId($loan->getId());
                for($i = 0; $i < 25; $i++) {
                    if($i < count($articles))
                        $article = $articles[$i];
                    else
                        $article = new Model_Article();
                    ?>
                <tr><td class="id_article"><?php echo $article->getId();?></td><td><?php echo $article->getDescription();?></td><td><?php echo $article->getQuantity(); ?></td><td></td><td></td><td></td></tr>
                <?php }
                ?>
            </table>
        </div>
        
        <table class="signatures">
            <tr>
                <td class="signature">
                    Emprunteur :
                </td>
                <td class="space"></td>
                <td class="signature">
                    Prêteur :
                </td>
            </tr>
        </table>
    </body>
</html>
<?php } ?>