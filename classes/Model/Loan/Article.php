<?php

class Model_Loan_Article {
    private $id, $loan, $article, $begindate, $enddate;
    
    function __construct($id, $loan, $article, $begindate, $enddate) {
        $this->id = $id;
        $this->loan = $loan;
        $this->article = $article;
        $this->begindate = $begindate;
        $this->enddate = $enddate;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getLoan() {
        return $this->loan;
    }

    public function setLoan($loan) {
        $this->loan = $loan;
    }

    public function getArticle() {
        return $this->article;
    }

    public function setArticle($article) {
        $this->article = $article;
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

}

?>
