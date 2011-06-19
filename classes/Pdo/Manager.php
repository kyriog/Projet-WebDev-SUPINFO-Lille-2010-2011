<?php
abstract class Pdo_Manager {
    const USER = MYSQL_DEFAULT_USER;
    const PASSWORD = MYSQL_DEFAULT_PASSWORD;

    protected $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host='.MYSQL_DEFAULT_HOST.';port=3306;dbname='.MYSQL_DEFAULT_DB, self::USER, self::PASSWORD);
    }
    
    //TODO : Améliorer la classe Pdo_Manager pour éviter qu'une nouvelle connexion à la BDD soit créée à chaque instanciation.
}
?>
