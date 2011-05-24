<?php

class Model_Loan {
    private $id, $customer, $begindate, $enddate, $reason;
    
    function __construct($id, $customer, $begindate, $enddate, $reason) {
        $this->id = $id;
        $this->customer = $customer;
        $this->begindate = $begindate;
        $this->enddate = $enddate;
        $this->reason = $reason;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getCustomer() {
        return $this->customer;
    }

    public function setCustomer($customer) {
        $this->customer = $customer;
    }

    public function getBegindate() {
        return $this->begindate;
    }

    public function setBegindate($begindate) {
        $this->begindate = $begindate;
    }

    public function getEnddate() {
        return $this->enddate;
    }

    public function setEnddate($enddate) {
        $this->enddate = $enddate;
    }

    public function getReason() {
        return $this->reason;
    }

    public function setReason($reason) {
        $this->reason = $reason;
    }


}

?>
