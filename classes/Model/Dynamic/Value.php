<?php

class Model_Dynamic_Value {
    private $_id, $_id_field, $_id_article, $_value;
    private static $_manager;
    
    function __construct($id = null) {
        self::init();
        if(is_null($id))
        {
            $this->_id = null;
            $this->_id_field = null;
            $this->_id_article = null;
            $this->_value = null;
        }
        else {
            $dynamicValue = self::$_manager->getDynamicValue($id);
            $this->_id = $dynamicValue['id'];
            $this->_id_field = $dynamicValue['id_field'];
            $this->_id_article = $dynamicValue['id_article'];
            $this->_value = $dynamicValue['value'];
        }
    }
    
    public static function init() {
        if(!is_object(self::$_manager)) self::$_manager = new Pdo_Dynamic_Value();
    }
    
    public function getId() {
        return $this->_id;
    }

    public function setId($id) {
        $this->_id = $id;
    }

    public function getId_field() {
        return $this->_id_field;
    }

    public function setId_field($id_field) {
        $this->_id_field = $id_field;
        if(!is_null($this->_id_article) && is_null($this->_id))
            $this->_id = self::$_manager->getId($this->_id_field, $this->_id_article);
    }

    public function getId_article() {
        return $this->_id_article;
    }

    public function setId_article($id_article) {
        $this->_id_article = $id_article;
        if(!is_null($this->_id_field) && is_null($this->_id));
            $this->_id = self::$_manager->getId($this->_id_field, $this->_id_article);
    }

    public function getValue() {
        if(is_null($this->_value)) {
            $this->_id = self::$_manager->getId($this->_id_field, $this->_id_article);
            return self::$_manager->getValue($this->_id_field, $this->_id_article);
        }
        return $this->_value;
    }

    public function setValue($value) {
        $this->_value = $value;
    }

    public function save() {
        if(is_null($this->_id))
            $this->_id = self::$_manager->add_value($this);
        else
            self::$_manager->edit_value($this);
    }
}

?>
