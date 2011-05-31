<?php

class Model_User {
    private $_id, $_name, $_password;
    private static $_manager;
    
    function __construct($id = null) {
        self::init();
        if(is_null($id)) {
            $this->_id = null;
            $this->_name=null;
            $this->_password=null;
        }
        else {
            $user = self::$_manager->getUser($id);
            $this->_id = $user['id'];
            $this->_name=$user['username'];
            $this->_password=$user['password'];
        }
    }

    private static function init() {
        if(!is_object(self::$_manager)) self::$_manager = new Pdo_User();
    }
    
    public function getId() {
        return $this->_id;
    }

    public function setId($id) {
        $this->_id = $id;
    }

    public function getName() {
        return $this->_name;
    }

    public function setName($name) {
        $this->_name = $name;
    }

    public function getPassword() {
        return $this->_password;
    }

    public function setPassword($password) {
        $this->_password = $password;
    }

    public function login($name, $password) {
        return self::$_manager->login($name, $password);
    }
}

?>
