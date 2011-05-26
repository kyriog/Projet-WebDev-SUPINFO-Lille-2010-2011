<?php

class Model_Family {
    private $id, $name, $parentfamily;
    
    function __construct($id, $name, $parentfamily) {
        $this->id = $id;
        $this->name = $name;
        $this->parentfamily = $parentfamily;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getParentfamily() {
        return $this->parentfamily;
    }

    public function setParentfamily($parentfamily) {
        $this->parentfamily = $parentfamily;
    }


}

?>
