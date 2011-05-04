<?php

class articlesModel {
    public $id, $barcode, $family, $quantity, $description, $state, $place;
    
    function __construct($id, $barcode, $family, $quantity, $description, $state, $place) {
        $this->id = $id;
        $this->barcode = $barcode;
        $this->family = $family;
        $this->quantity = $quantity;
        $this->description = $description;
        $this->state = $state;
        $this->place = $place;
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getBarcode() {
        return $this->barcode;
    }

    public function setBarcode($barcode) {
        $this->barcode = $barcode;
    }

    public function getFamily() {
        return $this->family;
    }

    public function setFamily($family) {
        $this->family = $family;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getState() {
        return $this->state;
    }

    public function setState($state) {
        $this->state = $state;
    }

    public function getPlace() {
        return $this->place;
    }

    public function setPlace($place) {
        $this->place = $place;
    }

}

?>
