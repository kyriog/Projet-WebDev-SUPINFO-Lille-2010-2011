<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pdoAbstract
 *
 * @author thorr
 */
class pdoAbstract {
    protected $_pdo;

    public function __construct() {
        $dsn = 'mysql:host='.MYSQL_DEFAULT_HOST.';dbname='.MYSQL_DEFAULT_DB;
        $this->_pdo = new PDO($dsn, MYSQL_DEFAULT_USER, MYSQL_DEFAULT_PASSWORD);
    }
}
?>
