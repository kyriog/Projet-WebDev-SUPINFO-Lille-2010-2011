<?php

class Model_Family {
    private $_id, $_name, $_parentfamily;
    private static $_manager;
    
    function __construct($id = null) {
        self::_init();
        if(is_null($id)) {
            $this->_id = null;
            $this->_name = null;
            $this->_parentfamily = null;
        }
        else {
            $family = self::$_manager->familyWithId($id);
            $this->_id = $family['id'];
            $this->_name = $family['name'];
            $this->_parentfamily = $family['parentfamily'];
        }
    }

    private static function _init() {
        if(!is_object(self::$_manager)) self::$_manager = new Pdo_Family();
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

    public function getParentfamily() {
        return $this->_parentfamily;
    }

    public function setParentfamily($parentfamily) {
        $this->_parentfamily = $parentfamily;
    }

    public static function getAllFamilies() {
        self::_init();
        return self::$_manager->getAllFamilies();
    }
    
}

?>
