<?php
function __autoload($class) {
    $tree = explode('_', $class);
    $dir = BASE_PATH.'/classes/'.implode('/', $tree);
    if(is_dir($dir))
        require_once($dir.'/'.$tree[count($tree)-1].'.php');
    else
        require_once($dir.'.php');
    //TODO : Utiliser une exception plutôt qu'une erreur.
    /* 
     * Il serait peut-être judicieux d'utiliser include_once au lieu de require_once
     * afin de pouvoir gérer une exception plutôt que d'afficher une erreur qui
     * interrompra l'exécution du code.
     * Cyril
     */
}
?>
