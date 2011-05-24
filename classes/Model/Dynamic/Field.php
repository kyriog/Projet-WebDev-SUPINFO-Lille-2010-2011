<?php

class Model_Dynamic_Field {
    private $id, $id_family, $name;
    
    function __construct($id, $id_family, $name) {
        $this->id = $id;
        $this->id_family = $id_family;
        $this->name = $name;
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId_family() {
        return $this->id_family;
    }

    public function setId_family($id_family) {
        $this->id_family = $id_family;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

}

?>
