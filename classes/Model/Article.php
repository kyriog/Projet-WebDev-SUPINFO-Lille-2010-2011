<?php

class Model_Article {
    private $_id, $_barcode, $_family, $_quantity, $_description, $_state, $_place;
    private static $_manager;


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
            $article = self::$_manager->getArticle($id);
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
        if(!is_object(self::$_manager)) self::$_manager = new Pdo_Article();
    }
    
    public function getId() {
        return $this->_id;
    }

    public function setId($id) {
        $this->_id = $id;
    }

    public function getBarcode() {
        return $this->_barcode;
    }

    public function setBarcode($barcode) {
        $this->_barcode = $barcode;
    }

    public function getFamily() {
        return $this->_family;
    }

    public function setFamily($family) {
        $this->_family = $family;
    }

    public function getQuantity() {
        return $this->_quantity;
    }

    public function setQuantity($quantity) {
        $this->_quantity = $quantity;
    }

    public function getDescription() {
        return $this->_description;
    }

    public function setDescription($description) {
        $this->_description = $description;
    }

    public function getState() {
        return $this->_state;
    }

    public function setState($state) {
        $this->_state = $state;
    }

    public function getPlace() {
        return $this->_place;
    }

    public function setPlace($place) {
        $this->_place = $place;
    }
    
    public static function getArticlesOfFamily($id_family) {
        self::init();
        return self::$_manager->getArticlesByFamily($id_family);
    }
}

?>
