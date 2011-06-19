<?php

class Model_Structure {
    private $_id, $_name;
    private static $_manager;
    
    function __construct($id = null) {
        self::init();
        if(is_null($id)) {
            $this->_id = null;
            $this->_name = null;
        }
        else {
            $structure = self::$_manager->getStructure($id);
            $this->_id=$structure['id'];
            $this->_name=$structure['name'];
        }
    }

    public static function init() {
        if(!is_object(self::$_manager)) self::$_manager = new Pdo_Structure();
    }
    
    public function getId() {
        return $this->_id;
    }

    public function getName() {
        return $this->_name;
    }

    public function setName($name) {
        $this->_name = $name;
    }
    
    public function save() {
        if(is_null($this->_id)) {
            $this->_id = self::$_manager->add_structure($this);
        }
        else {
            self::$_manager->edit_structure($this);
        }
    }
    
    public static function getAllStructures(){
        self::init();
        return self::$_manager->getAllStructures();
    }
}

?>
