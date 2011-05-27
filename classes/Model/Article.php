<?php

class Model_Article {
    private $_id, $_barcode, $_family, $_quantity, $_description, $_state, $_place;
    private abstract $_manager;


    function __construct($id = null) {
        self::init();
        if(is_null($id)) {
            $this->_id=null;
            $this->_barcode=null;
            $this->_family=null;
            $this->_quantity=null;
            $this->_description=null;
            $this->_state=null;
            $this->_place=null;
        }
        else {
            $article = $this->_manager->getArticle($id);
            $this->_id=$article['id'];
            $this->_barcode=$article['barcode'];
            $this->_family=$article['family'];
            $this->_quantity=$article['quantity'];
            $this->_description=$article['description'];
            $this->_state=$article['state'];
            $this->_place=$article['place'];
        }
    }

    public static function init() {
        if(!is_object(self::$_manager)) self::$_manager = new Pdo_Place();
    }
    
    public function get_id() {
        return $this->_id;
    }

    public function set_id($id) {
        $this->_id = $id;
    }

    public function get_barcode() {
        return $this->_barcode;
    }

    public function set_barcode($barcode) {
        $this->_barcode = $barcode;
    }

    public function get_family() {
        return $this->_family;
    }

    public function set_family($family) {
        $this->_family = $family;
    }

    public function get_quantity() {
        return $this->_quantity;
    }

    public function set_quantity($quantity) {
        $this->_quantity = $quantity;
    }

    public function get_description() {
        return $this->_description;
    }

    public function set_description($description) {
        $this->_description = $description;
    }

    public function get_state() {
        return $this->_state;
    }

    public function set_state($state) {
        $this->_state = $state;
    }

    public function get_place() {
        return $this->_place;
    }

    public function set_place($place) {
        $this->_place = $place;
    }


}

?>
