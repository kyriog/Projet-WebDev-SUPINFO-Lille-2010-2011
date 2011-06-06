<?php

class Model_Dynamic_Field {
    private $_id, $_family, $_name;
    private static $_manager;
    
    function __construct($id = null) {
        self::_init();
        if(is_null($id))
        {
            $this->_id = null;
            $this->_family = null;
            $this->_name = null;
        }
        else {
            $dynamicField = self::$_manager->getDynamicField($id);
            $this->_id = $dynamicField['id'];
            $this->_family = $dynamicField['id_family'];
            $this->_name = $dynamicField['name'];
        }
    }
    
    private static function _init() {
        if(!is_object(self::$_manager)) self::$_manager = new Pdo_Dynamic_Field();
    }
    
    public function getId() {
        return $this->_id;
    }

    public function getFamily() {
        return $this->_family;
    }

    public function setFamily($family) {
        if(is_object($family))
            $family = $family->getId();
        $this->_family = $family;
    }

    public function getName() {
        return $this->_name;
    }

    public function setName($name) {
        $this->_name = $name;
    }
    
    public function save() {
        if(is_null($this->_id))
            self::$_manager->add_field($this);
        else 
            self::$_manager->edit_field($this);
    }
    
    public function remove() {
        if(!is_null($this->_id)) 
            self::$_manager->remove_field($this);
    }

    public static function getFieldsByFamilyId($family) {
        self::_init();
        $family = (is_object($family)) ? $family->getId() : $family;
        return self::$_manager->getFieldsByFamilyId($family);
    }
}

?>
