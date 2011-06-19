<?php

class Model_Place {
    private $_id, $_name;
    private static $_manager;


    function __construct($id = null) {
        self::init();
        if(is_null($id)) {
            $this->_id = null;
            $this->_name = null;
        }
        else
        {
            $place = self::$_manager->getPlace($id);
            $this->_id = $place['id'];
            $this->_name = $place['name'];
        }
    }

    public static function init() {
        if(!is_object(self::$_manager)) self::$_manager = new Pdo_Place();
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
            $this->_id = self::$_manager->add_place($this);
        }
        else {
            self::$_manager->edit_place($this);
        }
    }
    
    public function remove() {
        if(!is_null($this->_id)) {
            self::$_manager->delete_place($this->_id);
            $this->_id = null;
            $this->_name = null;
        }
    }
    
    public static function getAllPlaces() {
        self::init();
        return self::$_manager->getAllPlaces();
    }

}

?>
