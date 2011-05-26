<?php

class Model_Customer {
    private $id, $lname, $fname, $phone, $structure, $function, $address;
    
    function __construct($id, $lname, $fname, $phone, $structure, $function, $address) {
        $this->id = $id;
        $this->lname = $lname;
        $this->fname = $fname;
        $this->phone = $phone;
        $this->structure = $structure;
        $this->function = $function;
        $this->address = $address;
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getLname() {
        return $this->lname;
    }

    public function setLname($lname) {
        $this->lname = $lname;
    }

    public function getFname() {
        return $this->fname;
    }

    public function setFname($fname) {
        $this->fname = $fname;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function getStructure() {
        return $this->structure;
    }

    public function setStructure($structure) {
        $this->structure = $structure;
    }

    public function getFunction() {
        return $this->function;
    }

    public function setFunction($function) {
        $this->function = $function;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

}

?>
