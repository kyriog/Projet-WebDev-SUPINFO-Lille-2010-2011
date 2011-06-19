<?php

class Model_Customer {
    private $_id, $_lname, $_fname, $_phone, $_structure, $_function, $_address;
    private static $_manager;
    
    function __construct($id = null) {
        self::init();
        if(is_null($id)) {
            $this->_id = null;
            $this->_lname = null;
            $this->_fname = null;
            $this->_phone = null;
            $this->_structure = null;
            $this->_function = null;
            $this->_address = null;
        }
        else {
            $customer = self::$_manager->getCustomer($id);
            $this->_id = $customer['id'];
            $this->_lname = $customer['lname'];
            $this->_fname = $customer['fname'];
            $this->_phone = $customer['phone'];
            $this->_structure = $customer['structure'];
            $this->_function = $customer['function'];
            $this->_address = $customer['address'];
        }
    }
    
    private static function init() {
        if(!is_object(self::$_manager)) self::$_manager = new Pdo_Customer();
    }
    
    public function getId() {
        return $this->_id;
    }

    public function getLname() {
        return $this->_lname;
    }

    public function setLname($lname) {
        $this->_lname = $lname;
    }

    public function getFname() {
        return $this->_fname;
    }

    public function setFname($fname) {
        $this->_fname = $fname;
    }

    public function getPhone() {
        return $this->_phone;
    }

    public function setPhone($phone) {
        $this->_phone = $phone;
    }

    public function getStructure() {
        return $this->_structure;
    }

    public function setStructure($structure) {
        $this->_structure = $structure;
    }

    public function getFunction() {
        return $this->_function;
    }

    public function setFunction($function) {
        $this->_function = $function;
    }

    public function getAddress() {
        return $this->_address;
    }

    public function setAddress($address) {
        $this->_address = $address;
    }

    public function save() {
        if(is_null($this->_id))
            $this->_id = self::$_manager->add_customer($this);
        else
            self::$_manager->edit_customer($this);
    }
    
    public static function getAllCustomers() {
        self::init();
        return self::$_manager->getAllCustomers();
    }
}

?>
