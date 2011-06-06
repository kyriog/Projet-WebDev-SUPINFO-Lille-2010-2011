<?php

class Model_Dynamic_Field {
    private $_id, $_id_family, $_name;
    private static $_manager;
    
    function __construct($id = null) {
        self::init();
        if(is_null($id))
        {
            $this->_id = null;
            $this->_id_family = null;
            $this->_name = null;
        }
        else {
            $dynamicField = self::$_manager->getDynamicField($id);
            $this->_id = $dynamicField['id'];
            $this->_id_family = $dynamicField['id_family'];
            $this->_name = $dynamicField['name'];
        }
    }
    
    public static function init() {
        if(!is_object(self::$_manager)) self::$_manager = new Pdo_Dynamic_Field();
    }
    
    public function getId() {
        return $this->_id;
    }

    public function setId($id) {
        $this->_id = $id;
    }

    public function getId_family() {
        return $this->_id_family;
    }

    public function setId_family($id_family) {
        $this->_id_family = $id_family;
    }

    public function getName() {
        return $this->_name;
    }

    public function setName($name) {
        $this->_name = $name;
    }

    public static function getFieldsByFamilyId($family) {
        self::init();
        $family = (is_object($family)) ? $family->getId() : $family;
        return self::$_manager->getFieldsByFamilyId($family);
    }
}

?>
