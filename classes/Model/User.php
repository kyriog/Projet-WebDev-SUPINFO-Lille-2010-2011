<?php

class Model_User {
    private $_id, $_fname, $_lname, $_phone, $_password;
    private static $_manager;
    
    function __construct($id = null) {
        self::init();
        if(is_null($id)) {
            $this->_id = null;
            $this->_fname=null;
            $this->_lname=null;
            $this->_phone=null;
            $this->_password=null;
        }
        else {
            $user = self::$_manager->getUser($id);
            $this->_id = $user['id'];
            $this->_fname=$user['fname'];
            $this->_lname=$user['lname'];
            $this->_phone=$user['phone'];
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

    public function getFname() {
        return $this->_fname;
    }

    public function setFname($fname) {
        $this->_fname = $fname;
    }

    public function getLname() {
        return $this->_lname;
    }

    public function setLname($_lname) {
        $this->_lname = $_lname;
    }

    public function getPhone() {
        return $this->_phone;
    }

    public function setPhone($_phone) {
        $this->_phone = $_phone;
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
    
    public function save() {
        if(is_null($this->_id))
            $this->_id = self::$_manager->add_user($this);
        else
            self::$_manager->edit_user($this);
    }
}

?>
