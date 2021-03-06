<?php

class Model_Family {
    private $_id, $_name, $_parentfamily;
    private $_dynamic_fields = NULL;
    private static $_manager;
    
    function __construct($id = null) {
        self::init();
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

    private static function init() {
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
        self::init();
        return self::$_manager->getAllFamilies();
    }

    public function getDynamicFields() {
        if(is_null($this->_dynamic_fields)) {
            if(is_null($this->_id))
                return array();
            $fields = self::$_manager->getDynamicFieldsIds($this->_id);
            $this->_dynamic_fields = array();
            foreach($fields as $field) {
                $this->_dynamic_fields[] = new Model_Dynamic_Field($field);
            }
        }
        return $this->_dynamic_fields;
    }
    
    public function save() {
        if(is_null($this->_id))
            $this->_id = self::$_manager->add_family($this);
        else
            self::$_manager->edit_family($this);
    }
    
}

?>
