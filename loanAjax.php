<?php
require_once('config.php');
require_once('autoload.php');
if(isset($_POST['action'])) {
    switch($_POST['action']) {
        case 'search':
            switch($_POST['type']) {
                case 'customer':
                    $customer = new Model_Customer($_POST['id']);
                    if(is_null($customer->getLname()))
                        echo 'Client inconnu, veuillez vérifier sa référence';
                    else
                        echo $customer->getFname().' '.$customer->getLname();
                    break;
                case 'article':
                    $article = new Model_Article($_POST['id']);
                    if(is_null($article->getDescription()))
                        echo 'Article inconnu, veuillez vérifier sa référence';
                    else
                        echo $article->getDescription();
                    break;
            }
            break;
    }
}
?>
