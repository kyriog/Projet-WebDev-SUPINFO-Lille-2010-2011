<?php

class Model_Dynamic_Value {
    private $id, $id_field, $id_article, $value;
    
    function __construct($id, $id_field, $id_article, $value) {
        $this->id = $id;
        $this->id_field = $id_field;
        $this->id_article = $id_article;
        $this->value = $value;
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId_field() {
        return $this->id_field;
    }

    public function setId_field($id_field) {
        $this->id_field = $id_field;
    }

    public function getId_article() {
        return $this->id_article;
    }

    public function setId_article($id_article) {
        $this->id_article = $id_article;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }

}

?>
