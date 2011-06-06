<?php

class Model_Loan_Article {
    private $_id, $_loan, $_article, $_begindate, $_enddate;
    private static $_manager;


    function __construct($id = null) {
        self::init();
        if(is_null($id)) {
            $this->_id = null;
            $this->_loan = null;
            $this->_article = null;
            $this->_begindate = null;
            $this->_enddate = null;
        }
        else {
            $loanArticle = self::$_manager->getLoanArticle($id);
            $this->_id = $loanArticle['id'];
            $this->_loan = $loanArticle['loan'];
            $this->_article = $loanArticle['article'];
            $this->_begindate = $loanArticle['begindate'];
            $this->_enddate = $loanArticle['enddate'];
        }
        
    }

    public static function init() {
        if(!is_object(self::$_manager)) self::$_manager = new Pdo_Loan_Article();
    }
    
    public function getId() {
        return $this->_id;
    }

    public function setId($id) {
        $this->_id = $id;
    }

    public function getLoan() {
        return $this->_loan;
    }

    public function setLoan($loan) {
        $this->_loan = $loan;
    }

    public function getArticle() {
        return $this->_article;
    }

    public function setArticle($article) {
        $this->_article = $article;
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

}

?>