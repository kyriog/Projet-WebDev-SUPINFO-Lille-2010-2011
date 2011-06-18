<?php

class Model_Loan {
    private $_id, $_customer, $_begindate, $_enddate, $_reason;
    private static $_manager;

    function __construct($id = null) {
        self::init();
        if(is_null($id))
        {
            $this->_id = null;
            $this->_customer = null;
            $this->_begindate = null;
            $this->_enddate = null;
            $this->_reason = null;
        }
        else {
            $loan = self::$_manager->getLoan($id);
            $this->_id = $loan['id'];
            $this->_customer = $loan['customer'];
            $this->_begindate = $loan['begindate'];
            $this->_enddate = $loan['enddate'];
            $this->_reason = $loan['reason'];
        }
    }

    public static function init() {
        if(!is_object(self::$_manager)) self::$_manager = new Pdo_Loan();
    }
    
    public function getId() {
        return $this->_id;
    }

    public function setId($id) {
        $this->_id = $id;
    }

    public function getCustomer() {
        return $this->_customer;
    }

    public function setCustomer($customer) {
        $this->_customer = $customer;
    }

    public function getBegindate() {
        return $this->_begindate;
    }

    public function setBegindate($begindate) {
        $this->_begindate = $begindate;
    }

    public function getEnddate() {
        return $this->_enddate;
    }

    public function setEnddate($enddate) {
        $this->_enddate = $enddate;
    }

    public function getReason() {
        return $this->_reason;
    }

    public function setReason($reason) {
        $this->_reason = $reason;
    }

    public function save() {
        if(is_null($this->_id)) {
            $this->_id = self::$_manager->add_loan($this);
        }
        else {
            self::$_manager->edit_loan($this);
        }
    }
}

?>
