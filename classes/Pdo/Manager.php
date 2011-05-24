<?php
abstract class Pdo_Manager {
    const USER = 'root';
    const PASSWORD = '';
    const DSN = 'mysql:host=localhost;port=3306;dbname=webdev';

    protected $pdo;

    public function __construct() {
        $this->pdo = new PDO(self::DSN, self::USER, self::PASSWORD);
    }
}
?>
