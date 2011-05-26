<?php

class Model_Place {
    private $_id, $_name;
    private static $_manager;


    function __construct($id = null) {
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

    public function init() {
        if(!is_object(self::$_manager)) self::$_manager = new Pdo_Place();
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

}

?>
